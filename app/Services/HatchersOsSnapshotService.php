<?php

namespace App\Services;

use App\helper\helper;
use App\Models\Blog;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Order;
use App\Models\Promocode;
use App\Models\Product;
use App\Models\Service;
use App\Models\Settings;
use App\Models\AdditionalService;
use App\Models\Tax;
use App\Models\Timing;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class HatchersOsSnapshotService
{
    public function syncFounder(User $user, ?string $currentPage = null): void
    {
        $sharedSecret = trim((string) env('WEBSITE_PLATFORM_SHARED_SECRET', env('HATCHERS_SHARED_SECRET', '')));
        $baseUrl = rtrim((string) env('HATCHERS_OS_URL', 'https://app.hatchers.ai'), '/');

        if ($sharedSecret === '' || $baseUrl === '') {
            return;
        }

        $founderId = (int) $user->id;
        $settings = Settings::where('vendor_id', $founderId)->first();
        $serviceCount = Service::where('vendor_id', $founderId)->count();
        $bookingCount = Booking::where('vendor_id', $founderId)->count();
        $productCount = Product::where('vendor_id', $founderId)->count();
        $orderCount = Order::where('vendor_id', $founderId)->count();
        $blogCount = Blog::where('vendor_id', $founderId)->count();
        $recentBookings = Booking::where('vendor_id', $founderId)
            ->latest('id')
            ->limit(8)
            ->get([
                'booking_number',
                'customer_name',
                'email',
                'mobile',
                'address',
                'landmark',
                'postalcode',
                'city',
                'state',
                'country',
                'service_name',
                'sub_total',
                'offer_code',
                'offer_amount',
                'grand_total',
                'status_type',
                'payment_status',
                'vendor_note',
                'staff_id',
                'booking_date',
                'booking_time',
                'booking_endtime',
                'booking_notes',
                'additional_service_name',
                'join_url',
                'transaction_type',
                'created_at',
            ])
            ->map(fn (Booking $booking) => [
                'booking_number' => (string) $booking->booking_number,
                'customer_name' => (string) ($booking->customer_name ?? 'Customer'),
                'customer_email' => (string) ($booking->email ?? ''),
                'customer_mobile' => (string) ($booking->mobile ?? ''),
                'address' => (string) ($booking->address ?? ''),
                'landmark' => (string) ($booking->landmark ?? ''),
                'postal_code' => (string) ($booking->postalcode ?? ''),
                'city' => (string) ($booking->city ?? ''),
                'state' => (string) ($booking->state ?? ''),
                'country' => (string) ($booking->country ?? ''),
                'service_name' => (string) ($booking->service_name ?? 'Service'),
                'sub_total' => (float) ($booking->sub_total ?? 0),
                'offer_code' => (string) ($booking->offer_code ?? ''),
                'offer_amount' => (float) ($booking->offer_amount ?? 0),
                'grand_total' => (float) ($booking->grand_total ?? 0),
                'status' => $this->formatWorkflowStatus((int) ($booking->status_type ?? 1)),
                'payment_status' => ((int) ($booking->payment_status ?? 1)) === 2 ? 'paid' : 'unpaid',
                'vendor_note' => (string) ($booking->vendor_note ?? ''),
                'staff_id' => (string) ($booking->staff_id ?? ''),
                'booking_date' => (string) ($booking->booking_date ?? ''),
                'booking_time' => (string) ($booking->booking_time ?? ''),
                'booking_endtime' => (string) ($booking->booking_endtime ?? ''),
                'booking_notes' => (string) ($booking->booking_notes ?? ''),
                'additional_service_name' => (string) ($booking->additional_service_name ?? ''),
                'join_url' => (string) ($booking->join_url ?? ''),
                'payment_type' => (string) ($booking->transaction_type ?? ''),
                'created_at' => optional($booking->created_at)->toIso8601String(),
            ])
            ->values()
            ->all();
        $recentCoupons = Promocode::where('vendor_id', $founderId)
            ->latest('id')
            ->limit(8)
            ->get([
                'offer_name',
                'offer_code',
                'offer_amount',
                'offer_type',
                'min_amount',
                'is_available',
                'exp_date',
            ])
            ->map(fn (Promocode $coupon) => [
                'title' => (string) ($coupon->offer_name ?? ''),
                'code' => (string) ($coupon->offer_code ?? ''),
                'discount_value' => (float) ($coupon->offer_amount ?? 0),
                'discount_type' => ((int) ($coupon->offer_type ?? 1)) === 2 ? 'percent' : 'fixed',
                'min_amount' => (float) ($coupon->min_amount ?? 0),
                'status' => ((int) ($coupon->is_available ?? 2)) === 1 ? 'active' : 'inactive',
                'expires_at' => (string) ($coupon->exp_date ?? ''),
            ])
            ->values()
            ->all();
        $recentServices = Service::where('vendor_id', $founderId)
            ->latest('id')
            ->limit(8)
            ->get([
                'id',
                'name',
                'price',
                'interval_time',
                'interval_type',
                'per_slot_limit',
                'staff_assign',
                'staff_id',
                'is_available',
            ])
            ->map(function (Service $service) use ($founderId) {
                $timings = Timing::where('vendor_id', $founderId)
                    ->where('service_id', $service->id)
                    ->get(['day', 'open_time', 'close_time', 'is_always_close']);

                $openDays = $timings
                    ->filter(fn (Timing $timing) => (int) ($timing->is_always_close ?? 2) !== 1)
                    ->pluck('day')
                    ->values()
                    ->all();

                $primaryTiming = $timings
                    ->first(fn (Timing $timing) => (int) ($timing->is_always_close ?? 2) !== 1);

                return [
                    'id' => (int) ($service->id ?? 0),
                    'title' => (string) ($service->name ?? ''),
                    'price' => (float) ($service->price ?? 0),
                    'duration' => (int) ($service->interval_time ?? 30),
                    'duration_unit' => ((int) ($service->interval_type ?? 2)) === 1 ? 'hours' : 'minutes',
                    'capacity' => (int) ($service->per_slot_limit ?? 1),
                    'staff_mode' => ((int) ($service->staff_assign ?? 2)) === 1 ? 'specific' : 'auto',
                    'staff_id' => (string) ($service->staff_id ?? ''),
                    'staff_ids' => collect(explode('|', (string) ($service->staff_id ?? '')))->map(fn ($item) => trim((string) $item))->filter()->values()->all(),
                    'status' => ((int) ($service->is_available ?? 1)) === 1 ? 'active' : 'inactive',
                    'availability_days' => $openDays,
                    'open_time' => $primaryTiming?->open_time ? substr((string) $primaryTiming->open_time, 0, 5) : '',
                    'close_time' => $primaryTiming?->close_time ? substr((string) $primaryTiming->close_time, 0, 5) : '',
                    'additional_services' => AdditionalService::where('service_id', $service->id)
                        ->limit(12)
                        ->get(['name', 'price'])
                        ->map(fn (AdditionalService $additionalService) => [
                            'name' => (string) ($additionalService->name ?? ''),
                            'price' => (float) ($additionalService->price ?? 0),
                        ])->values()->all(),
                ];
            })
            ->values()
            ->all();
        $recentCategories = Category::where('vendor_id', $founderId)
            ->where('is_deleted', 2)
            ->latest('id')
            ->limit(8)
            ->get(['name', 'is_available'])
            ->map(fn (Category $category) => [
                'title' => (string) ($category->name ?? ''),
                'status' => ((int) ($category->is_available ?? 2)) === 1 ? 'active' : 'inactive',
            ])
            ->values()
            ->all();
        $recentTaxes = Tax::where('vendor_id', $founderId)
            ->where('is_deleted', 2)
            ->latest('id')
            ->limit(8)
            ->get(['name', 'tax', 'type', 'is_available'])
            ->map(fn (Tax $tax) => [
                'title' => (string) ($tax->name ?? ''),
                'value' => (float) ($tax->tax ?? 0),
                'type' => ((int) ($tax->type ?? 2)) === 1 ? 'fixed' : 'percent',
                'status' => ((int) ($tax->is_available ?? 2)) === 1 ? 'active' : 'inactive',
            ])
            ->values()
            ->all();
        $recentAdditionalServices = AdditionalService::whereIn('service_id', Service::where('vendor_id', $founderId)->pluck('id'))
            ->latest('id')
            ->limit(12)
            ->get(['service_id', 'name', 'price'])
            ->map(fn (AdditionalService $service) => [
                'service_id' => (int) ($service->service_id ?? 0),
                'title' => (string) ($service->name ?? ''),
                'price' => (float) ($service->price ?? 0),
            ])
            ->values()
            ->all();
        $recentStaff = User::where('type', 4)
            ->where('vendor_id', $founderId)
            ->where('is_available', 1)
            ->where('role_type', 1)
            ->where('is_deleted', 2)
            ->latest('id')
            ->limit(12)
            ->get(['id', 'name', 'email'])
            ->map(fn (User $staff) => [
                'id' => (int) ($staff->id ?? 0),
                'title' => (string) ($staff->name ?? 'Staff'),
                'email' => (string) ($staff->email ?? ''),
            ])
            ->values()
            ->all();
        $grossRevenue = (float) Booking::where('vendor_id', $founderId)
            ->where('payment_status', 2)
            ->where('status_type', 3)
            ->sum('grand_total');
        $themeTemplate = (string) ($settings->theme ?? $settings->template ?? '');
        $websiteTitle = trim((string) ($settings->web_title ?? ''));
        $themeSelected = $themeTemplate !== '';
        $bookingReady = $themeSelected && $websiteTitle !== '' && $serviceCount > 0;
        $customerCount = Booking::where('vendor_id', $founderId)
            ->whereNotNull('email')
            ->pluck('email')
            ->filter()
            ->merge(
                Order::where('vendor_id', $founderId)
                    ->whereNotNull('user_email')
                    ->pluck('user_email')
                    ->filter()
            )
            ->unique()
            ->count();
        $readinessScore = min(
            100,
            10
            + ($themeSelected ? 20 : 0)
            + ($websiteTitle !== '' ? 15 : 0)
            + ($serviceCount > 0 ? 25 : 0)
            + (($bookingCount + $orderCount) > 0 ? 30 : 0)
        );

        $body = [
            'email' => $user->email,
            'username' => $user->username,
            'updated_at' => now()->toIso8601String(),
            'readiness_score' => $readinessScore,
            'current_page' => $currentPage ?: ($bookingReady ? 'service_dashboard' : 'service_setup'),
            'key_counts' => [
                'service_count' => $serviceCount,
                'booking_count' => $bookingCount,
                'customer_count' => $customerCount,
                'product_count' => $productCount,
                'order_count' => $orderCount,
                'blog_count' => $blogCount,
            ],
            'status_flags' => [
                'site_connected' => true,
                'theme_selected' => $themeSelected,
                'booking_ready' => $bookingReady,
            ],
            'recent_activity' => [
                'Founder workspace synced from Servio.',
                'Services: ' . $serviceCount . ', bookings: ' . $bookingCount . ', customers: ' . $customerCount . '.',
            ],
            'summary' => [
                'website_title' => $websiteTitle !== '' ? $websiteTitle : ($user->name ? $user->name . ' Services' : 'New Servio Site'),
                'theme_template' => $themeTemplate,
                'website_url' => helper::storefront_url($user),
                'gross_revenue' => $grossRevenue,
                'currency' => (string) ($settings->default_currency ?? 'usd'),
            ],
            'recent_bookings' => $recentBookings,
            'recent_services' => $recentServices,
            'recent_coupons' => $recentCoupons,
            'recent_categories' => $recentCategories,
            'recent_taxes' => $recentTaxes,
            'recent_additional_services' => $recentAdditionalServices,
            'recent_staff' => $recentStaff,
        ];

        $json = json_encode($body);
        if ($json === false) {
            return;
        }

        try {
            Http::timeout(10)
                ->withHeaders([
                    'X-Hatchers-Signature' => hash_hmac('sha256', $json, $sharedSecret),
                    'Content-Type' => 'application/json',
                ])
                ->post($baseUrl . '/integrations/snapshots/servio', $body);
        } catch (\Throwable $exception) {
        }
    }

    private function formatWorkflowStatus(int $statusType): string
    {
        return match ($statusType) {
            2 => 'processing',
            3 => 'completed',
            4 => 'cancelled',
            default => 'pending',
        };
    }
}
