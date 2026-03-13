<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display an enhanced data-driven dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();
        $today = Carbon::today();

        $upcomingAppointments = $user->appointments()
            ->whereDate('appointment_date', '>=', $today)
            ->where('status', '!=', 'cancelled')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        $todayAppointments = $upcomingAppointments
            ->filter(fn ($appointment) => $appointment->appointment_date->isSameDay($today))
            ->values();

        $healthRecords = $user->healthRecords()
            ->orderByDesc('record_date')
            ->orderByDesc('id')
            ->get();

        $activeHealthRecords = $healthRecords
            ->where('status', 'active')
            ->values();

        $serviceRequests = $user->medicalServiceRequests()
            ->orderByDesc('preferred_date')
            ->orderByDesc('id')
            ->get();

        $pendingServiceRequests = $serviceRequests
            ->whereIn('status', ['pending', 'in_review', 'scheduled'])
            ->values();

        $emergencyContacts = $user->emergencyContacts()
            ->orderByDesc('is_primary')
            ->orderBy('name')
            ->get();

        return view('dashboard', [
            'metrics' => [
                'upcoming_appointments' => $upcomingAppointments->count(),
                'pending_service_requests' => $pendingServiceRequests->count(),
                'active_health_records' => $activeHealthRecords->count(),
                'emergency_contacts' => $emergencyContacts->count(),
            ],
            'todayAppointments' => $todayAppointments->take(5),
            'recentHealthRecords' => $healthRecords->take(4),
            'recentServiceRequests' => $serviceRequests->take(4),
            'lastLoginAt' => $user->last_login_at,
            'moduleCounts' => [
                'services' => $serviceRequests->count(),
                'bookings' => $upcomingAppointments->count(),
                'health' => $healthRecords->count(),
                'emergency' => $emergencyContacts->count(),
            ],
        ]);
    }
}
