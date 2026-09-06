<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportCategory;
use App\Models\ReportList;
use App\Models\Blog;
use App\Models\PressRelease;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'categories' => ReportCategory::count(),
            'reports' => ReportList::count(),
            'blogs' => Blog::count(),
            'pressReleases' => PressRelease::count()
        ];

        $sessionsData = DB::table('sessions')
            ->where('user_id', Auth::id())
            ->orderBy('last_activity', 'desc')
            ->get();

        $sessions = $sessionsData->map(function ($session) {
            $agent = $this->parseUserAgent($session->user_agent);
            return (object) [
                'id' => $session->id,
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === request()->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->format('d M Y \a\t H:i'),
                'browser' => $agent['browser'],
                'os' => $agent['os'],
            ];
        });

        return view('admin.dashboard.index', compact('stats', 'sessions'));
    }

    public function updateUsername(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id()
        ]);

        $user = Auth::user();
        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            return redirect()->back()->with('success', 'Profile updated successfully.');
        }

        return redirect()->back()->with('error', 'Unauthorized');
    }

    public function logoutSession(Request $request, $id)
    {
        DB::table('sessions')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return redirect()->back()->with('success', 'Session logged out successfully.');
    }

    public function logoutOtherSessions(Request $request)
    {
        DB::table('sessions')
            ->where('user_id', Auth::id())
            ->where('id', '!=', request()->session()->getId())
            ->delete();

        return redirect()->back()->with('success', 'Other sessions logged out successfully.');
    }

    private function parseUserAgent($userAgent)
    {
        $browser = 'Unknown Browser';
        $os = 'Unknown OS';

        if (!$userAgent) {
            return ['browser' => $browser, 'os' => $os];
        }

        // Detect OS
        if (preg_match('/windows|win32/i', $userAgent)) {
            $os = 'Windows';
        } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
            $os = 'macOS';
        } elseif (preg_match('/linux/i', $userAgent)) {
            $os = 'Linux';
        } elseif (preg_match('/iphone|ipad|ipod/i', $userAgent)) {
            $os = 'iOS';
        } elseif (preg_match('/android/i', $userAgent)) {
            $os = 'Android';
        }

        // Detect Browser
        if (preg_match('/opr|opera/i', $userAgent)) {
            $browser = 'Opera';
        } elseif (preg_match('/edg/i', $userAgent)) {
            $browser = 'Edge';
        } elseif (preg_match('/chrome/i', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/safari/i', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/firefox/i', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/msie|trident/i', $userAgent)) {
            $browser = 'Internet Explorer';
        }

        return ['browser' => $browser, 'os' => $os];
    }
}
