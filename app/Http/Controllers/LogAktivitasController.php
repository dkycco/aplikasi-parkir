<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LogAktivitasController extends Controller
{
    private const ONLINE_THRESHOLD_MINUTES = 5;

    public function halaman_log()
    {
        $thresholdTimestamp = now()->subMinutes(self::ONLINE_THRESHOLD_MINUTES)->timestamp;
        $timezone = config('app.timezone');

        $latestActivities = DB::table('sessions')
            ->select('user_id', DB::raw('MAX(last_activity) as last_activity'))
            ->whereNotNull('user_id')
            ->groupBy('user_id')
            ->pluck('last_activity', 'user_id');

        $users = User::select('id', 'nama_lengkap', 'username')
            ->orderBy('nama_lengkap')
            ->get()
            ->map(function ($user) use ($latestActivities, $thresholdTimestamp, $timezone) {
                $lastActivity = $latestActivities[$user->id] ?? null;
                $isOnline = $lastActivity && $lastActivity >= $thresholdTimestamp;
                $lastActiveAt = $lastActivity
                    ? Carbon::createFromTimestamp($lastActivity)->timezone($timezone)
                    : null;

                return [
                    'id' => $user->id,
                    'nama_lengkap' => $user->nama_lengkap,
                    'username' => $user->username,
                    'is_online' => $isOnline,
                    'last_activity_at' => $lastActiveAt?->format('Y-m-d H:i:s'),
                    'last_seen_human' => $lastActiveAt?->diffForHumans() ?? 'Belum pernah aktif',
                ];
            });

        return view('halaman-log', [
            'users' => $users,
            'onlineCount' => $users->where('is_online', true)->count(),
            'thresholdMinutes' => self::ONLINE_THRESHOLD_MINUTES,
        ]);
    }

    public function show(int $userId)
    {
        $user = User::findOrFail($userId);
        $thresholdTimestamp = now()->subMinutes(self::ONLINE_THRESHOLD_MINUTES)->timestamp;
        $timezone = config('app.timezone');

        $sessions = DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderByDesc('last_activity')
            ->get();

        $latestSession = $sessions->first();
        $isOnline = $latestSession && $latestSession->last_activity >= $thresholdTimestamp;

        $lastOnlineAt = $latestSession
            ? Carbon::createFromTimestamp($latestSession->last_activity)->timezone($timezone)
            : null;

        $activityLogs = $sessions->map(function ($session) use ($thresholdTimestamp, $timezone) {
            $activeAt = Carbon::createFromTimestamp($session->last_activity)->timezone($timezone);

            return [
                'session_id'       => $session->id,
                'is_active_now'    => $session->last_activity >= $thresholdTimestamp,
                'ip_address'       => $session->ip_address ?? '-',
                'user_agent'       => $session->user_agent ?? '-',
                'last_activity_at' => $activeAt->format('Y-m-d H:i:s'),
                'last_seen_human'  => $activeAt->diffForHumans(),
            ];
        });

        return view('users.activity.show', [
            'user'             => $user,
            'isOnline'         => $isOnline,
            'lastOnlineAt'     => $lastOnlineAt?->format('Y-m-d H:i:s'),
            'lastSeenHuman'    => $lastOnlineAt?->diffForHumans() ?? 'Belum pernah aktif',
            'activityLogs'     => $activityLogs,
            'thresholdMinutes' => self::ONLINE_THRESHOLD_MINUTES,
        ]);
    }
}