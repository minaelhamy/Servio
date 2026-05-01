<?php

namespace App\Http\Controllers\Integration;

use App\Http\Controllers\Controller;
use App\Models\AppSettings;
use App\Models\LandingSettings;
use App\Models\Settings;
use App\Models\SubscriptionSettings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class HatchersLaunchController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $sharedSecret = trim((string) env('WEBSITE_PLATFORM_SHARED_SECRET', env('HATCHERS_SHARED_SECRET', '')));
            if ($sharedSecret === '') {
                abort(500, 'WEBSITE_PLATFORM_SHARED_SECRET is not configured.');
            }

            $payload = $request->validate([
                'username' => ['nullable', 'string'],
                'email' => ['nullable', 'email'],
                'role' => ['required', 'string'],
                'target' => ['required', 'string'],
                'expires' => ['required', 'integer'],
                'signature' => ['required', 'string'],
            ]);

            if ((int) $payload['expires'] < time()) {
                return redirect('/admin')->with('error', 'This Hatchers OS launch link has expired.');
            }

            $expected = hash_hmac('sha256', implode('|', [
                (string) ($payload['username'] ?? ''),
                (string) ($payload['email'] ?? ''),
                (string) ($payload['role'] ?? ''),
                (string) ($payload['target'] ?? ''),
                (string) ($payload['expires'] ?? ''),
            ]), $sharedSecret);

            if (!hash_equals($expected, (string) $payload['signature'])) {
                return redirect('/admin')->with('error', 'Invalid Hatchers OS launch signature.');
            }

            $role = trim((string) $payload['role']);
            $query = User::query();

            if ($role === 'admin') {
                $query->where('type', 1);
            } elseif ($role === 'founder') {
                $query->where('type', 2);
            } else {
                return redirect('/admin')->with('error', 'This Hatchers OS role is not supported in Servio yet.');
            }

            $user = null;
            if (!empty($payload['email'])) {
                $user = (clone $query)->where('email', (string) $payload['email'])->first();
            }
            if (empty($user) && !empty($payload['username'])) {
                $user = (clone $query)->where('username', (string) $payload['username'])->first();
            }

            if (empty($user)) {
                return redirect('/admin')->with('error', 'No matching Servio account was found for this OS user.');
            }

            if ((int) ($user->type ?? 0) === 2) {
                $this->ensureFounderWorkspaceDefaults($user);
            }

            session()->put('admin_login', 1);
            Auth::login($user, true);

            $target = (string) $payload['target'];
            if ($target === '' || str_starts_with($target, 'http')) {
                $target = '/admin/dashboard';
            }

            if ((int) ($user->type ?? 0) === 2 && $target === '/admin/dashboard') {
                $target = '/admin/basic_settings';
            }

            return redirect($target);
        } catch (Throwable $exception) {
            error_log('[HatchersLaunch] ' . $exception->getMessage() . ' in ' . $exception->getFile() . ':' . $exception->getLine());

            return redirect('/admin')->with('error', 'Servio could not finish the Hatchers OS launch yet.');
        }
    }

    private function ensureFounderWorkspaceDefaults(User $user): void
    {
        $vendorId = (int) $user->id;

        $settings = Settings::firstOrNew(['vendor_id' => $vendorId]);
        $settings->vendor_id = $vendorId;
        $settings->theme = $settings->theme ?: 1;
        $settings->web_title = $settings->web_title ?: (($user->name ?: 'Your Business') . ' Services');
        $settings->primary_color = $settings->primary_color ?: '#111827';
        $settings->secondary_color = $settings->secondary_color ?: '#f59e0b';
        $settings->landing_page = $settings->landing_page ?: 1;
        $settings->save();

        $appSettings = AppSettings::firstOrNew(['vendor_id' => $vendorId]);
        $appSettings->vendor_id = $vendorId;
        $appSettings->save();

        $landingSettings = LandingSettings::firstOrNew(['vendor_id' => $vendorId]);
        $landingSettings->vendor_id = $vendorId;
        $landingSettings->primary_color = $landingSettings->primary_color ?: '#111827';
        $landingSettings->secondary_color = $landingSettings->secondary_color ?: '#f59e0b';
        $landingSettings->save();

        $subscription = SubscriptionSettings::firstOrNew(['vendor_id' => $vendorId]);
        $subscription->vendor_id = $vendorId;
        $subscription->save();
    }
}
