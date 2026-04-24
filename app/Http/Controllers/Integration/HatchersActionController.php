<?php

namespace App\Http\Controllers\Integration;

use App\Http\Controllers\Controller;
use App\helper\helper;
use App\Models\Blog;
use App\Models\Category;
use App\Models\CustomStatus;
use App\Models\Booking;
use App\Models\Order;
use App\Models\Promocode;
use App\Models\Settings;
use App\Models\Service;
use App\Models\AdditionalService;
use App\Models\Tax;
use App\Models\Timing;
use App\Models\User;
use App\Services\HatchersOsSnapshotService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class HatchersActionController extends Controller
{
    public function __construct(private HatchersOsSnapshotService $snapshotService)
    {
    }

    public function __invoke(Request $request)
    {
        $sharedSecret = trim((string) env('WEBSITE_PLATFORM_SHARED_SECRET', env('HATCHERS_SHARED_SECRET', '')));
        if ($sharedSecret === '') {
            return response()->json(['success' => false, 'error' => 'WEBSITE_PLATFORM_SHARED_SECRET is not configured.'], 500);
        }

        $rawBody = $request->getContent();
        $signature = trim((string) $request->header('X-Hatchers-Signature', ''));
        $expected = hash_hmac('sha256', $rawBody, $sharedSecret);
        if ($signature === '' || !hash_equals($expected, $signature)) {
            return response()->json(['success' => false, 'error' => 'Invalid action signature.'], 403);
        }

        $payload = $request->json()->all();
        $user = $this->findUser($payload);
        if (empty($user)) {
            return response()->json(['success' => false, 'error' => 'Founder vendor account was not found in Servio.'], 404);
        }

        $category = trim((string) ($payload['category'] ?? ''));
        if (!in_array($category, ['service', 'blog', 'page', 'website', 'coupon', 'booking', 'order', 'catalog'], true)) {
            return response()->json(['success' => false, 'error' => 'Unsupported Servio action category.'], 422);
        }

        $vendorId = (int) ($user->type == 4 ? $user->vendor_id : $user->id);
        $operation = trim((string) ($payload['operation'] ?? 'create'));

        if ($category === 'website') {
            return match ($operation) {
                'update' => $this->updateWebsite($user, $vendorId, $payload),
                'publish' => $this->publishWebsite($user),
                default => response()->json(['success' => false, 'error' => 'Unsupported Servio website action.'], 422),
            };
        }

        if ($operation === 'update') {
            return match ($category) {
                'service' => $this->updateService($user, $vendorId, $payload),
                'blog' => $this->updateBlog($user, $vendorId, $payload),
                'page' => $this->updatePage($user, $vendorId, $payload),
                'coupon' => $this->updateCoupon($user, $vendorId, $payload),
                'booking' => $this->updateBooking($user, $vendorId, $payload),
                'order' => $this->updateOrder($user, $vendorId, $payload),
                'catalog' => $this->updateCatalogEntry($user, $vendorId, $payload),
                default => response()->json(['success' => false, 'error' => 'Unsupported Servio update action.'], 422),
            };
        }

        if ($category === 'blog') {
            return $this->createBlog($user, $vendorId, $payload);
        }

        if ($category === 'page') {
            return response()->json(['success' => false, 'error' => 'Pages in Servio are updated, not created.'], 422);
        }

        if ($category === 'coupon') {
            return $this->createCoupon($user, $vendorId, $payload);
        }

        if ($category === 'booking') {
            return $this->createBooking($user, $vendorId, $payload);
        }

        if ($category === 'catalog') {
            return $this->createCatalogEntry($user, $vendorId, $payload);
        }

        $title = trim((string) ($payload['title'] ?? ''));
        if ($title === '') {
            $title = 'New service draft';
        }

        $slug = $this->uniqueSlug($title);
        $categoryId = $this->ensureCategory($vendorId);

        $service = new Service();
        $service->vendor_id = $vendorId;
        $service->category_id = (string) $categoryId;
        $service->name = $title;
        $service->slug = $slug;
        $service->price = (float) ($payload['price'] ?? 0);
        $service->original_price = (float) ($payload['original_price'] ?? ($payload['price'] ?? 0));
        $service->discount_percentage = 0;
        $service->tax = '';
        $service->description = trim((string) ($payload['description'] ?? 'Created from Hatchers OS by Atlas.'));
        $service->interval_time = 30;
        $service->interval_type = 2;
        $service->per_slot_limit = 1;
        $service->video_url = '';
        $service->additional_services = 2;
        $service->staff_id = '';
        $service->staff_assign = 2;
        $service->is_available = 1;
        $service->is_deleted = 2;
        $service->is_imported = 2;
        $service->save();

        $this->cloneVendorTimings($vendorId, (int) $service->id);
        $this->snapshotService->syncFounder($user, 'os_service_created');

        return response()->json([
            'success' => true,
            'record_id' => $service->id,
            'slug' => $service->slug,
            'edit_url' => url('/admin/services/edit-' . $service->slug),
            'title' => $service->name,
        ]);
    }

    private function updateWebsite(User $user, int $vendorId, array $payload)
    {
        $websiteTitle = trim((string) ($payload['website_title'] ?? ''));
        $themeTemplate = trim((string) ($payload['theme_template'] ?? ''));
        $customDomain = trim((string) ($payload['custom_domain'] ?? ''));
        if ($websiteTitle === '' && $themeTemplate === '' && $customDomain === '') {
            return response()->json(['success' => false, 'error' => 'Website update needs a title, theme, or custom domain.'], 422);
        }

        $settings = Settings::firstOrNew(['vendor_id' => $vendorId]);
        $settings->vendor_id = $vendorId;
        if ($websiteTitle !== '') {
            $settings->web_title = $websiteTitle;
        }
        if ($themeTemplate !== '') {
            $settings->theme = $themeTemplate;
            $settings->template = $themeTemplate;
        }
        if ($customDomain !== '') {
            $settings->custom_domain = $customDomain;
        }
        $settings->save();

        $this->snapshotService->syncFounder($user, 'service_setup');

        return response()->json([
            'success' => true,
            'title' => $websiteTitle !== '' ? $websiteTitle : (string) ($settings->web_title ?? ''),
            'theme_template' => $themeTemplate !== '' ? $themeTemplate : (string) ($settings->theme ?? ''),
            'custom_domain' => $customDomain,
            'public_url' => helper::storefront_url($user),
            'edit_url' => url('/admin/basic_settings'),
        ]);
    }

    private function publishWebsite(User $user)
    {
        $this->snapshotService->syncFounder($user, 'service_dashboard');

        return response()->json([
            'success' => true,
            'public_url' => helper::storefront_url($user),
            'edit_url' => url('/admin/dashboard'),
            'title' => 'Servio website published',
        ]);
    }

    private function createBlog(User $user, int $vendorId, array $payload)
    {
        $title = trim((string) ($payload['title'] ?? ''));
        if ($title === '') {
            $title = 'New blog draft';
        }

        $blog = new Blog();
        $blog->vendor_id = $vendorId;
        $blog->title = $title;
        $blog->slug = $this->uniqueBlogSlug($title);
        $blog->description = trim((string) ($payload['description'] ?? 'Created from Hatchers OS by Atlas.'));
        $blog->image = '';
        $blog->save();

        $this->snapshotService->syncFounder($user, 'os_blog_created');

        return response()->json([
            'success' => true,
            'record_id' => $blog->id,
            'slug' => $blog->slug,
            'edit_url' => url('/admin/blogs/edit-' . $blog->slug),
            'title' => $blog->title,
        ]);
    }

    private function updateService(User $user, int $vendorId, array $payload)
    {
        $service = $this->findTargetService($vendorId, $payload);
        if (empty($service)) {
            return response()->json(['success' => false, 'error' => 'The requested service was not found in Servio for this founder.'], 404);
        }

        $field = trim((string) ($payload['field'] ?? ''));
        $value = trim((string) ($payload['value'] ?? ''));
        if ($field === '' || $value === '') {
            return response()->json(['success' => false, 'error' => 'Update field and value are required.'], 422);
        }

        if ($field === 'title') {
            $service->name = $value;
            $service->slug = $this->uniqueSlug($value, (int) $service->id);
        } elseif ($field === 'description') {
            $service->description = $value;
        } elseif ($field === 'price') {
            $service->price = (float) $value;
            if ((float) $service->original_price < (float) $service->price) {
                $service->original_price = (float) $service->price;
            }
            $service->discount_percentage = $service->original_price > 0
                ? number_format(100 - ($service->price * 100) / $service->original_price, 1)
                : 0;
        } elseif (in_array($field, ['status', 'is_available'], true)) {
            $service->is_available = $this->normalizeEnabledFlag($value) === 1 ? 1 : 2;
        } elseif (in_array($field, ['category_name', 'category'], true)) {
            $service->category_id = (string) $this->ensureCategory($vendorId, $value);
        } elseif (in_array($field, ['tax_rules', 'tax'], true)) {
            $service->tax = $this->ensureTaxRules($vendorId, $value);
        } elseif (in_array($field, ['duration', 'interval_time'], true)) {
            $service->interval_time = max(1, (int) $value);
        } elseif (in_array($field, ['duration_unit', 'interval_type'], true)) {
            $service->interval_type = in_array(strtolower($value), ['hour', 'hours', '1'], true) ? 1 : 2;
        } elseif (in_array($field, ['capacity', 'slot_limit', 'per_slot_limit'], true)) {
            $service->per_slot_limit = max(1, (int) $value);
        } elseif (in_array($field, ['staff_mode', 'staff_assign'], true)) {
            $service->staff_assign = in_array(strtolower($value), ['specific', 'assigned', '1'], true) ? 1 : 2;
            if ($service->staff_assign !== 1) {
                $service->staff_id = '';
            }
        } elseif ($field === 'staff_ids') {
            $ids = collect(explode('|', $value))
                ->map(fn ($item) => trim((string) $item))
                ->filter()
                ->values()
                ->all();
            $service->staff_id = implode('|', $ids);
            $service->staff_assign = $ids !== [] ? 1 : 2;
        } elseif ($field === 'staff_id') {
            $service->staff_id = $value;
            if ($value !== '') {
                $service->staff_assign = 1;
            }
        } elseif ($field === 'availability_days') {
            $this->updateServiceTimings($vendorId, (int) $service->id, explode('|', $value), null, null);
        } elseif ($field === 'open_time') {
            $this->updateServiceTimings($vendorId, (int) $service->id, null, $value, null);
        } elseif ($field === 'close_time') {
            $this->updateServiceTimings($vendorId, (int) $service->id, null, null, $value);
        } elseif ($field === 'additional_services') {
            $this->syncAdditionalServices((int) $service->id, $value);
        } else {
            return response()->json(['success' => false, 'error' => 'Unsupported service field update.'], 422);
        }

        $service->save();
        $this->snapshotService->syncFounder($user, 'os_service_updated');

        return response()->json([
            'success' => true,
            'record_id' => $service->id,
            'slug' => $service->slug,
            'edit_url' => url('/admin/services/edit-' . $service->slug),
            'title' => $service->name,
        ]);
    }

    private function updateBlog(User $user, int $vendorId, array $payload)
    {
        $blog = $this->findTargetBlog($vendorId, $payload);
        if (empty($blog)) {
            return response()->json(['success' => false, 'error' => 'The requested blog was not found in Servio for this founder.'], 404);
        }

        $field = trim((string) ($payload['field'] ?? ''));
        $value = trim((string) ($payload['value'] ?? ''));
        if ($field === '' || $value === '') {
            return response()->json(['success' => false, 'error' => 'Update field and value are required.'], 422);
        }

        if ($field === 'title') {
            $blog->title = $value;
            $blog->slug = $this->uniqueBlogSlug($value, (int) $blog->id);
        } elseif (in_array($field, ['description', 'content'], true)) {
            $blog->description = $value;
        } else {
            return response()->json(['success' => false, 'error' => 'Unsupported blog field update.'], 422);
        }

        $blog->save();
        $this->snapshotService->syncFounder($user, 'os_blog_updated');

        return response()->json([
            'success' => true,
            'record_id' => $blog->id,
            'slug' => $blog->slug,
            'edit_url' => url('/admin/blogs/edit-' . $blog->slug),
            'title' => $blog->title,
        ]);
    }

    private function updatePage(User $user, int $vendorId, array $payload)
    {
        $field = trim((string) ($payload['field'] ?? ''));
        $value = trim((string) ($payload['value'] ?? ''));
        $targetName = trim((string) ($payload['target_name'] ?? ''));
        if (!in_array($field, ['content', 'description'], true) || $value === '' || $targetName === '') {
            return response()->json(['success' => false, 'error' => 'Page name and content are required.'], 422);
        }

        $page = $this->normalizePageName($targetName);
        if ($page === '') {
            return response()->json(['success' => false, 'error' => 'Unsupported Servio page target.'], 422);
        }

        $settings = Settings::firstOrNew(['vendor_id' => $vendorId]);
        $settings->vendor_id = $vendorId;

        if ($page === 'about') {
            $settings->about_content = $value;
            $title = 'About Us';
            $editUrl = url('/admin/aboutus');
        } elseif ($page === 'privacy') {
            $settings->privacy_content = $value;
            $title = 'Privacy Policy';
            $editUrl = url('/admin/privacy-policy');
        } elseif ($page === 'terms') {
            $settings->terms_content = $value;
            $title = 'Terms & Conditions';
            $editUrl = url('/admin/terms-conditions');
        } else {
            $settings->refund_policy = $value;
            $title = 'Refund Policy';
            $editUrl = url('/admin/refund_policy');
        }

        $settings->save();
        $this->snapshotService->syncFounder($user, 'os_page_updated');

        return response()->json([
            'success' => true,
            'record_id' => $settings->id,
            'edit_url' => $editUrl,
            'title' => $title,
        ]);
    }

    private function createCoupon(User $user, int $vendorId, array $payload)
    {
        $title = trim((string) ($payload['offer_name'] ?? $payload['title'] ?? ''));
        $code = trim((string) ($payload['offer_code'] ?? strtoupper(Str::slug($title, ''))));
        if ($title === '' || $code === '') {
            return response()->json(['success' => false, 'error' => 'Coupon name and code are required.'], 422);
        }

        $coupon = new Promocode();
        $coupon->vendor_id = $vendorId;
        $coupon->offer_name = $title;
        $coupon->offer_code = $code;
        $coupon->offer_type = $this->normalizeDiscountType((string) ($payload['offer_type'] ?? ''));
        $coupon->usage_type = $this->normalizeUsageType((string) ($payload['usage_type'] ?? ''), (int) ($payload['usage_limit'] ?? 0));
        $coupon->usage_limit = $coupon->usage_type == 1 ? max(1, (int) ($payload['usage_limit'] ?? 1)) : 0;
        $coupon->start_date = (string) ($payload['start_date'] ?? now()->toDateString());
        $coupon->exp_date = (string) ($payload['exp_date'] ?? now()->addDays(30)->toDateString());
        $coupon->offer_amount = (float) ($payload['offer_amount'] ?? 0);
        $coupon->min_amount = (float) ($payload['min_amount'] ?? 0);
        $coupon->description = trim((string) ($payload['description'] ?? 'Created from Hatchers OS.'));
        $coupon->is_available = $this->normalizeEnabledFlag($payload['is_available'] ?? 1);
        $coupon->save();

        $this->snapshotService->syncFounder($user, 'os_coupon_created');

        return response()->json([
            'success' => true,
            'record_id' => $coupon->id,
            'title' => $coupon->offer_name,
            'edit_url' => url('/admin/promocode'),
        ]);
    }

    private function createBooking(User $user, int $vendorId, array $payload)
    {
        $service = $this->findTargetService($vendorId, $payload);
        if (empty($service)) {
            return response()->json(['success' => false, 'error' => 'The requested service was not found in Servio for this founder.'], 404);
        }

        $customerName = trim((string) ($payload['customer_name'] ?? ''));
        $customerEmail = trim((string) ($payload['customer_email'] ?? ''));
        $customerMobile = trim((string) ($payload['customer_mobile'] ?? ''));
        $bookingDate = trim((string) ($payload['booking_date'] ?? ''));
        $bookingTime = trim((string) ($payload['booking_time'] ?? ''));
        $bookingEndTime = trim((string) ($payload['booking_endtime'] ?? ''));

        if ($customerName === '' || $customerEmail === '' || $customerMobile === '' || $bookingDate === '' || $bookingTime === '' || $bookingEndTime === '') {
            return response()->json(['success' => false, 'error' => 'Public booking requests need customer details plus date and time.'], 422);
        }

        $appData = helper::appdata($vendorId);
        $lastBooking = Booking::select('booking_number_digit', 'order_number_start')->where('vendor_id', $vendorId)->orderByDesc('id')->first();
        if (empty($lastBooking?->booking_number_digit)) {
            $nextNumber = (int) ($appData->order_number_start ?? 1001);
        } elseif ((int) ($lastBooking->order_number_start ?? 0) === (int) ($appData->order_number_start ?? 1001)) {
            $nextNumber = (int) $lastBooking->booking_number_digit + 1;
        } else {
            $nextNumber = (int) ($appData->order_number_start ?? 1001);
        }

        $bookingNumberDigit = str_pad((string) $nextNumber, 0, STR_PAD_LEFT);
        $bookingNumber = (string) ($appData->order_prefix ?? 'BKG') . $bookingNumberDigit;
        $selectedAdditionalServices = collect((array) ($payload['selected_additional_services'] ?? []))
            ->map(fn ($value) => Str::lower(trim((string) $value)))
            ->filter()
            ->values();
        $additionalServices = $selectedAdditionalServices->isEmpty()
            ? collect()
            : AdditionalService::where('service_id', $service->id)->get()->filter(function (AdditionalService $item) use ($selectedAdditionalServices): bool {
                return $selectedAdditionalServices->contains(Str::lower(trim((string) $item->name)));
            });
        $additionalServicesPrice = (float) $additionalServices->sum(fn (AdditionalService $item): float => (float) ($item->price ?? 0));

        $defaultStatus = CustomStatus::query()
            ->where('vendor_id', $vendorId)
            ->where('status_use', 1)
            ->where('type', 1)
            ->where('is_available', 1)
            ->where('is_deleted', 2)
            ->orderBy('id')
            ->first();

        $booking = new Booking();
        $booking->booking_number = $bookingNumber;
        $booking->booking_number_digit = $bookingNumberDigit;
        $booking->order_number_start = (int) ($appData->order_number_start ?? 1001);
        $booking->vendor_id = $vendorId;
        $booking->user_id = null;
        $booking->service_id = $service->id;
        $booking->service_image = '';
        $booking->service_name = $service->name;
        $booking->offer_code = '';
        $booking->offer_amount = 0;
        $booking->booking_date = date('Y-m-d', strtotime($bookingDate));
        $booking->booking_time = $bookingTime;
        $booking->booking_endtime = $bookingEndTime;
        $booking->customer_name = $customerName;
        $booking->mobile = $customerMobile;
        $booking->email = $customerEmail;
        $booking->city = trim((string) ($payload['city'] ?? ''));
        $booking->state = trim((string) ($payload['state'] ?? ''));
        $booking->country = trim((string) ($payload['country'] ?? ''));
        $booking->postalcode = trim((string) ($payload['postal_code'] ?? ''));
        $booking->landmark = trim((string) ($payload['landmark'] ?? ''));
        $booking->address = trim((string) ($payload['address'] ?? ''));
        $baseNotes = trim((string) ($payload['notes'] ?? $payload['description'] ?? 'Public website booking request from Hatchers OS.'));
        $addOnNote = $additionalServices->isNotEmpty() ? 'Add-ons: ' . $additionalServices->pluck('name')->implode(', ') : '';
        $booking->booking_notes = trim($baseNotes . ($addOnNote !== '' ? "\n" . $addOnNote : ''));
        $booking->sub_total = (float) ($service->price ?? 0);
        $booking->tax = '';
        $booking->tax_name = '';
        $booking->grand_total = (float) ($service->price ?? 0) + $additionalServicesPrice;
        $booking->payment_status = 1;
        $booking->transaction_id = '';
        $booking->transaction_type = '';
        $booking->status = $defaultStatus?->id;
        $booking->status_type = (int) ($defaultStatus?->type ?? 1);
        $booking->staff_id = trim((string) ($service->staff_id ?? ''));
        $booking->additional_service_name = $additionalServices->pluck('name')->implode(', ');
        $booking->save();

        $traceurl = url('/' . trim((string) ($user->slug ?? ''), '/') . '/booking-' . $bookingNumber);
        $contacturl = url('/' . trim((string) ($user->slug ?? ''), '/') . '/contact');
        helper::send_mail_forbooking($booking, $traceurl, $contacturl);

        $this->snapshotService->syncFounder($user, 'os_public_booking_created');

        return response()->json([
            'success' => true,
            'record_id' => $booking->id,
            'title' => $bookingNumber,
            'edit_url' => url('/admin/bookings'),
        ]);
    }

    private function createCatalogEntry(User $user, int $vendorId, array $payload)
    {
        $resource = trim((string) ($payload['resource'] ?? ''));
        $title = trim((string) ($payload['title'] ?? ''));

        if ($resource === 'category') {
            if ($title === '') {
                return response()->json(['success' => false, 'error' => 'Category title is required.'], 422);
            }

            $categoryId = $this->ensureCategory($vendorId, $title);
            $category = Category::find($categoryId);
            $this->snapshotService->syncFounder($user, 'os_catalog_updated');

            return response()->json([
                'success' => true,
                'record_id' => $categoryId,
                'title' => (string) ($category?->name ?? $title),
                'edit_url' => url('/admin/categories'),
            ]);
        }

        if ($resource === 'tax') {
            $value = trim((string) ($payload['value'] ?? ''));
            if ($title === '' || $value === '') {
                return response()->json(['success' => false, 'error' => 'Tax name and value are required.'], 422);
            }

            $taxIds = $this->ensureTaxRules($vendorId, (string) json_encode([[
                'name' => $title,
                'value' => $value,
                'type' => (string) ($payload['type'] ?? 'percent'),
            ]]));
            $taxId = (int) collect(explode('|', $taxIds))->filter()->first();
            $tax = $taxId > 0 ? Tax::find($taxId) : null;
            $this->snapshotService->syncFounder($user, 'os_catalog_updated');

            return response()->json([
                'success' => true,
                'record_id' => $taxId,
                'title' => (string) ($tax?->name ?? $title),
                'edit_url' => url('/admin/taxes'),
            ]);
        }

        if ($resource === 'staff') {
            $email = trim((string) ($payload['email'] ?? ''));
            $mobile = trim((string) ($payload['mobile'] ?? ''));
            if ($title === '' || $email === '' || $mobile === '') {
                return response()->json(['success' => false, 'error' => 'Staff name, email, and mobile are required.'], 422);
            }

            $staff = User::where('vendor_id', $vendorId)
                ->where('type', 4)
                ->where('role_type', 1)
                ->where('email', $email)
                ->first();

            if (empty($staff)) {
                $staff = new User();
                $staff->vendor_id = $vendorId;
                $staff->type = 4;
                $staff->role_type = 1;
                $staff->password = Hash::make(Str::random(24));
                $staff->login_type = 'email';
                $staff->image = 'default.png';
                $staff->is_available = 1;
                $staff->is_verified = 1;
                $staff->is_deleted = 2;
            }

            $staff->name = $title;
            $staff->email = $email;
            $staff->mobile = $mobile;
            $staff->save();

            $this->snapshotService->syncFounder($user, 'os_staff_created');

            return response()->json([
                'success' => true,
                'record_id' => $staff->id,
                'title' => (string) ($staff->name ?? $title),
                'edit_url' => url('/admin/profile'),
            ]);
        }

        return response()->json(['success' => false, 'error' => 'Unsupported Servio catalog resource.'], 422);
    }

    private function updateCatalogEntry(User $user, int $vendorId, array $payload)
    {
        $resource = trim((string) ($payload['resource'] ?? ''));
        $field = trim((string) ($payload['field'] ?? ''));
        $value = trim((string) ($payload['value'] ?? ''));

        if ($resource === 'category') {
            $category = $this->findTargetCategory($vendorId, $payload);
            if (empty($category)) {
                return response()->json(['success' => false, 'error' => 'The requested Servio category was not found for this founder.'], 404);
            }

            if (in_array($field, ['title', 'name'], true)) {
                $category->name = $value;
                $category->slug = $this->uniqueCategorySlug($value);
            } elseif (in_array($field, ['status', 'is_available'], true)) {
                $category->is_available = $this->normalizeEnabledFlag($value);
            } else {
                return response()->json(['success' => false, 'error' => 'Unsupported Servio category update.'], 422);
            }

            $category->save();
            $this->snapshotService->syncFounder($user, 'os_catalog_updated');

            return response()->json([
                'success' => true,
                'record_id' => $category->id,
                'title' => (string) $category->name,
                'edit_url' => url('/admin/categories'),
            ]);
        }

        if ($resource === 'tax') {
            $tax = $this->findTargetTax($vendorId, $payload);
            if (empty($tax)) {
                return response()->json(['success' => false, 'error' => 'The requested Servio tax was not found for this founder.'], 404);
            }

            if (in_array($field, ['title', 'name'], true)) {
                $tax->name = $value;
            } elseif (in_array($field, ['value', 'tax'], true)) {
                $tax->tax = (float) $value;
            } elseif ($field === 'type') {
                $tax->type = in_array(strtolower($value), ['fixed', 'flat', 'amount', '1'], true) ? 1 : 2;
            } elseif (in_array($field, ['status', 'is_available'], true)) {
                $tax->is_available = $this->normalizeEnabledFlag($value);
            } else {
                return response()->json(['success' => false, 'error' => 'Unsupported Servio tax update.'], 422);
            }

            $tax->save();
            $this->snapshotService->syncFounder($user, 'os_catalog_updated');

            return response()->json([
                'success' => true,
                'record_id' => $tax->id,
                'title' => (string) $tax->name,
                'edit_url' => url('/admin/taxes'),
            ]);
        }

        if ($resource === 'staff') {
            $staff = $this->findTargetStaff($vendorId, $payload);
            if (empty($staff)) {
                return response()->json(['success' => false, 'error' => 'The requested Servio staff record was not found for this founder.'], 404);
            }

            if (in_array($field, ['title', 'name'], true)) {
                $staff->name = $value;
            } elseif ($field === 'email') {
                $staff->email = $value;
            } elseif ($field === 'mobile') {
                $staff->mobile = $value;
            } elseif (in_array($field, ['status', 'is_available'], true)) {
                $staff->is_available = $this->normalizeEnabledFlag($value);
            } else {
                return response()->json(['success' => false, 'error' => 'Unsupported Servio staff update.'], 422);
            }

            $staff->save();
            $this->snapshotService->syncFounder($user, 'os_staff_updated');

            return response()->json([
                'success' => true,
                'record_id' => $staff->id,
                'title' => (string) $staff->name,
                'edit_url' => url('/admin/profile'),
            ]);
        }

        return response()->json(['success' => false, 'error' => 'Unsupported Servio catalog resource.'], 422);
    }

    private function updateCoupon(User $user, int $vendorId, array $payload)
    {
        $coupon = $this->findTargetCoupon($vendorId, $payload);
        if (empty($coupon)) {
            return response()->json(['success' => false, 'error' => 'The requested coupon was not found in Servio for this founder.'], 404);
        }

        $field = trim((string) ($payload['field'] ?? ''));
        if ($field === 'config') {
            $coupon->offer_name = trim((string) ($payload['offer_name'] ?? $coupon->offer_name));
            $coupon->offer_code = trim((string) ($payload['offer_code'] ?? $coupon->offer_code));
            $coupon->offer_type = $this->normalizeDiscountType((string) ($payload['offer_type'] ?? $coupon->offer_type));
            $coupon->usage_type = $this->normalizeUsageType((string) ($payload['usage_type'] ?? $coupon->usage_type), (int) ($payload['usage_limit'] ?? $coupon->usage_limit));
            $coupon->usage_limit = $coupon->usage_type == 1 ? max(1, (int) ($payload['usage_limit'] ?? $coupon->usage_limit)) : 0;
            $coupon->start_date = (string) ($payload['start_date'] ?? $coupon->start_date);
            $coupon->exp_date = (string) ($payload['exp_date'] ?? $coupon->exp_date);
            $coupon->offer_amount = (float) ($payload['offer_amount'] ?? $coupon->offer_amount);
            $coupon->min_amount = (float) ($payload['min_amount'] ?? $coupon->min_amount);
            $coupon->description = trim((string) ($payload['description'] ?? $coupon->description));
            if (array_key_exists('is_available', $payload)) {
                $coupon->is_available = $this->normalizeEnabledFlag($payload['is_available']);
            }
        } else {
            $value = trim((string) ($payload['value'] ?? ''));
            if ($field === '' || $value === '') {
                return response()->json(['success' => false, 'error' => 'Coupon update field and value are required.'], 422);
            }

            if (in_array($field, ['title', 'offer_name'], true)) {
                $coupon->offer_name = $value;
            } elseif (in_array($field, ['code', 'offer_code'], true)) {
                $coupon->offer_code = $value;
            } elseif (in_array($field, ['description'], true)) {
                $coupon->description = $value;
            } elseif (in_array($field, ['discount_value', 'offer_amount'], true)) {
                $coupon->offer_amount = (float) $value;
            } elseif (in_array($field, ['min_amount'], true)) {
                $coupon->min_amount = (float) $value;
            } elseif (in_array($field, ['usage_limit'], true)) {
                $coupon->usage_limit = (int) $value;
                $coupon->usage_type = $coupon->usage_limit > 0 ? 1 : 2;
            } elseif (in_array($field, ['status', 'is_available'], true)) {
                $coupon->is_available = $this->normalizeEnabledFlag($value);
            } else {
                return response()->json(['success' => false, 'error' => 'Unsupported Servio coupon update.'], 422);
            }
        }

        $coupon->save();
        $this->snapshotService->syncFounder($user, 'os_coupon_updated');

        return response()->json([
            'success' => true,
            'record_id' => $coupon->id,
            'title' => $coupon->offer_name,
            'edit_url' => url('/admin/promocode'),
        ]);
    }

    private function updateBooking(User $user, int $vendorId, array $payload)
    {
        $booking = $this->findTargetBooking($vendorId, $payload);
        if (empty($booking)) {
            return response()->json(['success' => false, 'error' => 'The requested booking was not found in Servio for this founder.'], 404);
        }

        $field = trim((string) ($payload['field'] ?? ''));
        $value = trim((string) ($payload['value'] ?? ''));
        if ($field === '' || $value === '') {
            return response()->json(['success' => false, 'error' => 'Booking update field and value are required.'], 422);
        }

        if ($field === 'status') {
            $statusType = $this->normalizeWorkflowStatus($value);
            $customStatus = CustomStatus::query()
                ->where('vendor_id', $vendorId)
                ->where('status_use', 1)
                ->where('type', $statusType)
                ->where('is_available', 1)
                ->where('is_deleted', 2)
                ->orderBy('id')
                ->first();

            if ($customStatus) {
                $booking->status = $customStatus->id;
            }
            $booking->status_type = $statusType;
        } elseif ($field === 'payment_status') {
            $booking->payment_status = $this->normalizePaymentStatus($value);
        } elseif ($field === 'vendor_note') {
            $booking->vendor_note = $value;
        } elseif ($field === 'staff_id') {
            $booking->staff_id = $value;
        } elseif ($field === 'booking_date') {
            $booking->booking_date = $value;
        } elseif ($field === 'booking_time') {
            $booking->booking_time = $value;
        } elseif ($field === 'booking_endtime') {
            $booking->booking_endtime = $value;
        } elseif ($field === 'booking_notes') {
            $booking->booking_notes = $value;
        } elseif ($field === 'customer_message') {
            $existing = trim((string) ($booking->booking_notes ?? ''));
            $channel = trim((string) ($payload['message_channel'] ?? 'manual'));
            $message = '[' . now()->format('Y-m-d H:i') . '][' . ($channel !== '' ? $channel : 'manual') . '] ' . $value;
            $booking->booking_notes = trim($existing . ($existing !== '' ? "\n" : '') . $message);
        } elseif ($field === 'customer_name') {
            $booking->customer_name = $value;
        } elseif (in_array($field, ['customer_email', 'email'], true)) {
            $booking->email = $value;
        } elseif (in_array($field, ['customer_mobile', 'mobile'], true)) {
            $booking->mobile = $value;
        } elseif ($field === 'address') {
            $booking->address = $value;
        } elseif ($field === 'landmark') {
            $booking->landmark = $value;
        } elseif (in_array($field, ['postal_code', 'postalcode'], true)) {
            $booking->postalcode = $value;
        } elseif ($field === 'city') {
            $booking->city = $value;
        } elseif ($field === 'state') {
            $booking->state = $value;
        } elseif ($field === 'country') {
            $booking->country = $value;
        } else {
            return response()->json(['success' => false, 'error' => 'Unsupported Servio booking update.'], 422);
        }

        $booking->save();
        $emailFollowupSent = $this->sendBookingFollowupEmail($vendorId, $booking, $field, $value, (string) ($payload['message_channel'] ?? 'manual'));
        $this->snapshotService->syncFounder($user, 'os_booking_updated');

        return response()->json([
            'success' => true,
            'record_id' => $booking->id,
            'title' => (string) $booking->booking_number,
            'edit_url' => url('/admin/bookings'),
            'email_followup_sent' => $emailFollowupSent,
        ]);
    }

    private function updateOrder(User $user, int $vendorId, array $payload)
    {
        $order = $this->findTargetOrder($vendorId, $payload);
        if (empty($order)) {
            return response()->json(['success' => false, 'error' => 'The requested order was not found in Servio for this founder.'], 404);
        }

        $field = trim((string) ($payload['field'] ?? ''));
        $value = trim((string) ($payload['value'] ?? ''));
        if ($field === '' || $value === '') {
            return response()->json(['success' => false, 'error' => 'Order update field and value are required.'], 422);
        }

        if ($field === 'status') {
            $statusType = $this->normalizeWorkflowStatus($value);
            $customStatus = CustomStatus::query()
                ->where('vendor_id', $vendorId)
                ->where('status_use', 2)
                ->where('type', $statusType)
                ->where('is_available', 1)
                ->where('is_deleted', 2)
                ->orderBy('id')
                ->first();

            if ($customStatus) {
                $order->status = $customStatus->id;
            }
            $order->status_type = $statusType;
        } elseif ($field === 'payment_status') {
            $order->payment_status = $this->normalizePaymentStatus($value);
        } elseif ($field === 'vendor_note') {
            $order->vendor_note = $value;
        } elseif ($field === 'customer_message') {
            $existing = trim((string) ($order->notes ?? ''));
            $channel = trim((string) ($payload['message_channel'] ?? 'manual'));
            $message = '[' . now()->format('Y-m-d H:i') . '][' . ($channel !== '' ? $channel : 'manual') . '] ' . $value;
            $order->notes = trim($existing . ($existing !== '' ? "\n" : '') . $message);
        } else {
            return response()->json(['success' => false, 'error' => 'Unsupported Servio order update.'], 422);
        }

        $order->save();
        $emailFollowupSent = $this->sendOrderFollowupEmail($vendorId, $order, $field, $value, (string) ($payload['message_channel'] ?? 'manual'));
        $this->snapshotService->syncFounder($user, 'os_order_updated');

        return response()->json([
            'success' => true,
            'record_id' => $order->id,
            'title' => (string) $order->order_number,
            'edit_url' => url('/admin/orders'),
            'email_followup_sent' => $emailFollowupSent,
        ]);
    }

    private function sendBookingFollowupEmail(int $vendorId, Booking $booking, string $field, string $value, string $channel): bool
    {
        if ($field !== 'status' && !($field === 'customer_message' && strtolower($channel) === 'email')) {
            return false;
        }

        if (trim((string) $booking->email) === '') {
            return false;
        }

        $vendor = User::query()->select('id', 'name', 'email')->find($vendorId);
        if (!$vendor) {
            return false;
        }

        $emaildata = helper::emailconfigration($vendorId);
        Config::set('mail', $emaildata);

        $title = $field === 'status'
            ? 'Booking ' . ucfirst(str_replace('_', ' ', $booking->status_type ?: $value))
            : 'Booking update';

        $messageText = $field === 'status'
            ? 'Your booking ' . $booking->booking_number . ' has been updated to ' . ucfirst(str_replace('_', ' ', $booking->status_type ?: $value)) . '.'
            : $value;

        return (bool) helper::booking_status_email(
            (string) $booking->email,
            (string) ($booking->customer_name ?? 'Customer'),
            $title,
            $messageText,
            $vendor
        );
    }

    private function sendOrderFollowupEmail(int $vendorId, Order $order, string $field, string $value, string $channel): bool
    {
        if ($field !== 'status' && !($field === 'customer_message' && strtolower($channel) === 'email')) {
            return false;
        }

        if (trim((string) $order->user_email) === '') {
            return false;
        }

        $vendor = User::query()->select('id', 'name', 'email')->find($vendorId);
        if (!$vendor) {
            return false;
        }

        $emaildata = helper::emailconfigration($vendorId);
        Config::set('mail', $emaildata);

        $title = $field === 'status'
            ? 'Order ' . ucfirst(str_replace('_', ' ', $order->status_type ?: $value))
            : 'Order update';

        $messageText = $field === 'status'
            ? 'Your order ' . $order->order_number . ' has been updated to ' . ucfirst(str_replace('_', ' ', $order->status_type ?: $value)) . '.'
            : $value;

        return (bool) helper::order_status_email(
            (string) $order->user_email,
            (string) ($order->user_name ?? 'Customer'),
            $title,
            $messageText,
            $vendor
        );
    }

    private function findTargetService(int $vendorId, array $payload): ?Service
    {
        $query = Service::where('vendor_id', $vendorId)->where('is_deleted', 2);
        $targetName = trim((string) ($payload['target_name'] ?? ''));

        if ($targetName !== '') {
            return (clone $query)
                ->whereRaw('LOWER(name) = ?', [Str::lower($targetName)])
                ->latest('id')
                ->first();
        }

        return $query->latest('id')->first();
    }

    private function findTargetCategory(int $vendorId, array $payload): ?Category
    {
        $query = Category::where('vendor_id', $vendorId)->where('is_deleted', 2);
        $targetName = trim((string) ($payload['target_name'] ?? ''));

        if ($targetName !== '') {
            return (clone $query)
                ->whereRaw('LOWER(name) = ?', [Str::lower($targetName)])
                ->latest('id')
                ->first();
        }

        return $query->latest('id')->first();
    }

    private function findTargetTax(int $vendorId, array $payload): ?Tax
    {
        $query = Tax::where('vendor_id', $vendorId)->where('is_deleted', 2);
        $targetName = trim((string) ($payload['target_name'] ?? ''));

        if ($targetName !== '') {
            return (clone $query)
                ->whereRaw('LOWER(name) = ?', [Str::lower($targetName)])
                ->latest('id')
                ->first();
        }

        return $query->latest('id')->first();
    }

    private function findTargetStaff(int $vendorId, array $payload): ?User
    {
        $query = User::where('vendor_id', $vendorId)
            ->where('type', 4)
            ->where('role_type', 1)
            ->where('is_deleted', 2);
        $targetName = trim((string) ($payload['target_name'] ?? ''));

        if ($targetName !== '') {
            return (clone $query)
                ->where(function ($builder) use ($targetName) {
                    $builder->whereRaw('LOWER(name) = ?', [Str::lower($targetName)])
                        ->orWhereRaw('LOWER(email) = ?', [Str::lower($targetName)]);
                })
                ->latest('id')
                ->first();
        }

        return $query->latest('id')->first();
    }

    private function findTargetCoupon(int $vendorId, array $payload): ?Promocode
    {
        $query = Promocode::where('vendor_id', $vendorId);
        $targetName = trim((string) ($payload['target_name'] ?? ''));

        if ($targetName !== '') {
            return (clone $query)
                ->where(function ($builder) use ($targetName) {
                    $builder->whereRaw('LOWER(offer_name) = ?', [Str::lower($targetName)])
                        ->orWhereRaw('LOWER(offer_code) = ?', [Str::lower($targetName)]);
                })
                ->latest('id')
                ->first();
        }

        return $query->latest('id')->first();
    }

    private function findTargetBooking(int $vendorId, array $payload): ?Booking
    {
        $query = Booking::where('vendor_id', $vendorId);
        $targetName = trim((string) ($payload['target_name'] ?? ''));

        if ($targetName !== '') {
            return (clone $query)
                ->whereRaw('LOWER(booking_number) = ?', [Str::lower($targetName)])
                ->latest('id')
                ->first();
        }

        return $query->latest('id')->first();
    }

    private function findTargetOrder(int $vendorId, array $payload): ?Order
    {
        $query = Order::where('vendor_id', $vendorId);
        $targetName = trim((string) ($payload['target_name'] ?? ''));

        if ($targetName !== '') {
            return (clone $query)
                ->whereRaw('LOWER(order_number) = ?', [Str::lower($targetName)])
                ->latest('id')
                ->first();
        }

        return $query->latest('id')->first();
    }

    private function findTargetBlog(int $vendorId, array $payload): ?Blog
    {
        $query = Blog::where('vendor_id', $vendorId);
        $targetName = trim((string) ($payload['target_name'] ?? ''));

        if ($targetName !== '') {
            return (clone $query)
                ->whereRaw('LOWER(title) = ?', [Str::lower($targetName)])
                ->latest('id')
                ->first();
        }

        return $query->latest('id')->first();
    }

    private function normalizePageName(string $page): string
    {
        $normalized = Str::of($page)->lower()->replace(['&', '-'], ['and', ' '])->squish()->value();

        return match ($normalized) {
            'about', 'about us', 'aboutus' => 'about',
            'privacy', 'privacy policy', 'privacypolicy' => 'privacy',
            'terms', 'terms and conditions', 'terms conditions', 'terms condition' => 'terms',
            'refund', 'refund policy', 'refundpolicy' => 'refund',
            default => '',
        };
    }

    private function normalizeDiscountType(string $value): int
    {
        $value = Str::lower(trim($value));
        return in_array($value, ['2', 'percent', 'percentage'], true) ? 2 : 1;
    }

    private function normalizeUsageType(string $value, int $usageLimit): int
    {
        $value = Str::lower(trim($value));
        if (in_array($value, ['1', 'limited'], true)) {
            return 1;
        }

        if (in_array($value, ['2', 'unlimited'], true)) {
            return 2;
        }

        return $usageLimit > 0 ? 1 : 2;
    }

    private function normalizeEnabledFlag(mixed $value): int
    {
        $normalized = Str::lower(trim((string) $value));
        return in_array($normalized, ['1', 'true', 'active', 'enabled', 'on', 'yes'], true) ? 1 : 2;
    }

    private function normalizeWorkflowStatus(string $value): int
    {
        return match (Str::lower(trim($value))) {
            'pending', 'new', 'open' => 1,
            'processing', 'accepted', 'confirmed', 'in_progress', 'in progress' => 2,
            'completed', 'complete', 'delivered', 'done' => 3,
            'cancelled', 'canceled' => 4,
            default => 1,
        };
    }

    private function normalizePaymentStatus(string $value): int
    {
        return in_array(Str::lower(trim($value)), ['2', 'paid', 'complete', 'completed'], true) ? 2 : 1;
    }

    private function findUser(array $payload): ?User
    {
        foreach (['username', 'email'] as $field) {
            $value = trim((string) ($payload[$field] ?? ''));
            if ($value === '') {
                continue;
            }

            $query = User::query()->where($field, $value)->whereIn('type', [2, 4])->where('is_deleted', 2);
            $user = $query->first();
            if (!empty($user)) {
                return $user;
            }
        }

        return null;
    }

    private function ensureCategory(int $vendorId, ?string $name = null): int
    {
        $name = trim((string) $name);
        $category = Category::where('vendor_id', $vendorId)
            ->where('is_deleted', 2)
            ->where('is_available', 1)
            ->when($name !== '', fn ($query) => $query->where('name', $name))
            ->orderBy('reorder_id')
            ->first();

        if (!empty($category)) {
            return (int) $category->id;
        }

        $name = $name !== '' ? $name : 'Hatchers Drafts';
        $newCategory = new Category();
        $newCategory->vendor_id = $vendorId;
        $newCategory->name = $name;
        $newCategory->slug = $this->uniqueCategorySlug($name);
        $newCategory->is_available = 1;
        $newCategory->is_deleted = 2;
        $newCategory->save();

        return (int) $newCategory->id;
    }

    private function ensureTaxRules(int $vendorId, string $rawValue): string
    {
        $rules = json_decode($rawValue, true);
        if (!is_array($rules)) {
            return '';
        }

        $taxIds = collect($rules)
            ->filter(fn ($item) => is_array($item) && trim((string) ($item['name'] ?? '')) !== '' && trim((string) ($item['value'] ?? '')) !== '')
            ->map(function (array $rule) use ($vendorId): string {
                $name = trim((string) ($rule['name'] ?? ''));
                $value = (float) trim((string) ($rule['value'] ?? '0'));
                $type = in_array(strtolower(trim((string) ($rule['type'] ?? 'percent'))), ['fixed', 'flat', 'amount'], true) ? 1 : 2;

                $tax = Tax::where('vendor_id', $vendorId)->where('name', $name)->first();
                if (empty($tax)) {
                    $tax = new Tax();
                    $tax->vendor_id = $vendorId;
                    $tax->name = $name;
                    $tax->is_available = 1;
                    $tax->is_deleted = 2;
                }

                $tax->type = $type;
                $tax->tax = $value;
                $tax->save();

                return (string) $tax->id;
            })
            ->filter()
            ->values()
            ->all();

        return implode('|', $taxIds);
    }

    private function syncAdditionalServices(int $serviceId, string $rawValue): void
    {
        $services = json_decode($rawValue, true);
        if (!is_array($services)) {
            return;
        }

        AdditionalService::where('service_id', $serviceId)->delete();

        foreach ($services as $service) {
            if (!is_array($service)) {
                continue;
            }

            $name = trim((string) ($service['name'] ?? ''));
            if ($name === '') {
                continue;
            }

            AdditionalService::create([
                'service_id' => $serviceId,
                'name' => $name,
                'price' => (float) trim((string) ($service['price'] ?? '0')),
                'image' => '',
            ]);
        }
    }

    private function cloneVendorTimings(int $vendorId, int $serviceId): void
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        foreach ($days as $day) {
            $source = Timing::where('vendor_id', $vendorId)->where('day', $day)->whereNull('service_id')->first();
            $timing = new Timing();
            $timing->vendor_id = $vendorId;
            $timing->service_id = $serviceId;
            $timing->day = $day;
            $timing->open_time = $source->open_time ?? '09:00:00';
            $timing->break_start = $source->break_start ?? null;
            $timing->break_end = $source->break_end ?? null;
            $timing->close_time = $source->close_time ?? '17:00:00';
            $timing->is_always_close = $source->is_always_close ?? 2;
            $timing->save();
        }
    }

    private function updateServiceTimings(int $vendorId, int $serviceId, ?array $availabilityDays, ?string $openTime, ?string $closeTime): void
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $allowedDays = collect($availabilityDays ?? [])->map(fn ($day) => trim((string) $day))->filter(fn ($day) => in_array($day, $days, true))->values()->all();
        $normalizedOpen = $this->normalizeTimingValue($openTime);
        $normalizedClose = $this->normalizeTimingValue($closeTime);

        foreach ($days as $day) {
            $timing = Timing::firstOrNew([
                'vendor_id' => $vendorId,
                'service_id' => $serviceId,
                'day' => $day,
            ]);

            if (!$timing->exists) {
                $timing->break_start = null;
                $timing->break_end = null;
                $timing->open_time = $normalizedOpen ?? '09:00:00';
                $timing->close_time = $normalizedClose ?? '17:00:00';
                $timing->is_always_close = 2;
            }

            if ($allowedDays !== []) {
                $timing->is_always_close = in_array($day, $allowedDays, true) ? 2 : 1;
            }

            if ($normalizedOpen !== null) {
                $timing->open_time = $normalizedOpen;
            }

            if ($normalizedClose !== null) {
                $timing->close_time = $normalizedClose;
            }

            $timing->save();
        }
    }

    private function normalizeTimingValue(?string $time): ?string
    {
        $time = trim((string) $time);
        if ($time === '') {
            return null;
        }

        return strlen($time) === 5 ? $time . ':00' : $time;
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title, '-');
        $slug = $base !== '' ? $base : 'service-draft';
        $tries = 1;

        while (
            Service::where('slug', $slug)
                ->when($ignoreId !== null, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = ($base !== '' ? $base : 'service-draft') . '-' . $tries;
            $tries++;
        }

        return $slug;
    }

    private function uniqueBlogSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title, '-');
        $slug = $base !== '' ? $base : 'blog-draft';
        $tries = 1;

        while (
            Blog::where('slug', $slug)
                ->when($ignoreId !== null, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = ($base !== '' ? $base : 'blog-draft') . '-' . $tries;
            $tries++;
        }

        return $slug;
    }

    private function uniqueCategorySlug(string $title): string
    {
        $base = Str::slug($title, '-');
        $slug = $base !== '' ? $base : 'hatchers-drafts';
        $tries = 1;

        while (Category::where('slug', $slug)->exists()) {
            $slug = ($base !== '' ? $base : 'hatchers-drafts') . '-' . $tries;
            $tries++;
        }

        return $slug;
    }
}
