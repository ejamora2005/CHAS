@extends('layouts.portal')

@section('title', 'Dashboard')

@section('content')
    <section class="hero-banner" style="--hero-image: url('https://images.unsplash.com/photo-1584982751601-97dcc096659c?auto=format&fit=crop&w=1600&q=80');">
        <div class="hero-content">
            <h1 class="hero-title">Campus Health Dashboard</h1>
            <p class="hero-sub">
                Live overview of your appointments, health records, service requests, and emergency contacts.
                @if ($lastLoginAt)
                    Last login: {{ $lastLoginAt->format('M d, Y g:i A') }}.
                @endif
            </p>
        </div>
    </section>

    <section class="stats-grid" aria-label="Dashboard metrics">
        <article class="stat-card">
            <p class="stat-label">Upcoming Appointments</p>
            <p class="stat-value">{{ $metrics['upcoming_appointments'] }}</p>
        </article>
        <article class="stat-card">
            <p class="stat-label">Pending Service Requests</p>
            <p class="stat-value">{{ $metrics['pending_service_requests'] }}</p>
        </article>
        <article class="stat-card">
            <p class="stat-label">Active Health Records</p>
            <p class="stat-value">{{ $metrics['active_health_records'] }}</p>
        </article>
        <article class="stat-card">
            <p class="stat-label">Emergency Contacts</p>
            <p class="stat-value">{{ $metrics['emergency_contacts'] }}</p>
        </article>
    </section>

    <section class="insight-grid">
        <article class="insight-panel">
            <h2 class="insight-title">Today's Appointment Timeline</h2>
            <p class="insight-subtitle">Actual bookings scheduled for today.</p>
            @if ($todayAppointments->isNotEmpty())
                <ul class="timeline-list">
                    @foreach ($todayAppointments as $appointment)
                        @php
                            $timeRaw = $appointment->appointment_time;
                            $timeDisplay = \Carbon\Carbon::createFromFormat(strlen($timeRaw) > 5 ? 'H:i:s' : 'H:i', $timeRaw)->format('g:i A');
                        @endphp
                        <li class="timeline-item">
                            <span class="timeline-time">{{ $timeDisplay }}</span>
                            <p class="timeline-copy">{{ $appointment->service }} - {{ ucfirst($appointment->status) }}</p>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="booking-empty">No appointments scheduled for today.</p>
            @endif
        </article>

        <article class="insight-panel">
            <h2 class="insight-title">Recent Health and Service Updates</h2>
            <p class="insight-subtitle">Latest records pulled from your account data.</p>
            <ul class="checklist">
                @forelse ($recentHealthRecords as $record)
                    <li>{{ $record->title }} ({{ $record->category }}) - {{ ucfirst($record->status) }}</li>
                @empty
                    <li>No health records yet.</li>
                @endforelse
            </ul>

            <ul class="checklist" style="margin-top: 0.7rem;">
                @forelse ($recentServiceRequests as $request)
                    <li>{{ $request->service }} request - {{ ucfirst(str_replace('_', ' ', $request->status)) }}</li>
                @empty
                    <li>No medical service requests yet.</li>
                @endforelse
            </ul>
        </article>
    </section>

    <section class="module-grid">
        <a href="{{ route('medical-services.index') }}" class="module-card">
            <div class="module-photo" style="background-image: url('https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1200&q=80');"></div>
            <div class="module-body">
                <h2 class="module-title">Medical Services</h2>
                <p class="module-subtitle">{{ $moduleCounts['services'] }} request record(s)</p>
                <ul class="module-features">
                    <li>General Consultation</li>
                    <li>Dental Care</li>
                    <li>Laboratory Requests</li>
                    <li>Vaccination Services</li>
                </ul>
            </div>
        </a>

        <a href="{{ route('booking.index') }}" class="module-card">
            <div class="module-photo" style="background-image: url('https://images.unsplash.com/photo-1484480974693-6ca0a78fb36b?auto=format&fit=crop&w=1200&q=80');"></div>
            <div class="module-body">
                <h2 class="module-title">Booking</h2>
                <p class="module-subtitle">{{ $moduleCounts['bookings'] }} active booking(s)</p>
                <ul class="module-features">
                    <li>Set Appointment</li>
                    <li>Reschedule Visit</li>
                    <li>Queue Tracker</li>
                    <li>Booking History</li>
                </ul>
            </div>
        </a>

        <a href="{{ route('my-health.index') }}" class="module-card">
            <div class="module-photo" style="background-image: url('https://images.unsplash.com/photo-1460672985063-6764ac8b9c74?auto=format&fit=crop&w=1200&q=80');"></div>
            <div class="module-body">
                <h2 class="module-title">My Health</h2>
                <p class="module-subtitle">{{ $moduleCounts['health'] }} health record(s)</p>
                <ul class="module-features">
                    <li>Health Records</li>
                    <li>Immunization Log</li>
                    <li>Prescriptions</li>
                    <li>Test Results</li>
                </ul>
            </div>
        </a>

        <a href="{{ route('emergency-info.index') }}" class="module-card">
            <div class="module-photo" style="background-image: url('https://images.unsplash.com/photo-1505751172876-fa1923c5c528?auto=format&fit=crop&w=1200&q=80');"></div>
            <div class="module-body">
                <h2 class="module-title">Emergency Info</h2>
                <p class="module-subtitle">{{ $moduleCounts['emergency'] }} contact record(s)</p>
                <ul class="module-features">
                    <li>Emergency Contacts</li>
                    <li>Nearest Hospitals</li>
                    <li>First Aid Guide</li>
                    <li>Hotline Access</li>
                </ul>
            </div>
        </a>
    </section>

    <section class="quick-actions" aria-label="Quick navigation">
        <a href="{{ route('booking.index') }}">Book Now</a>
        <a href="{{ route('medical-services.index') }}">Request Service</a>
        <a href="{{ route('my-health.index') }}">Add Health Record</a>
        <a href="{{ route('emergency-info.index') }}">Manage Contacts</a>
    </section>
@endsection
