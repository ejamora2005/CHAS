@extends('layouts.portal')

@section('title', 'Dashboard')

@section('content')
    <section class="hero-banner" style="--hero-image: url('https://images.unsplash.com/photo-1584982751601-97dcc096659c?auto=format&fit=crop&w=1600&q=80');">
        <div class="hero-content">
            <h1 class="hero-title">Campus Health Dashboard</h1>
            <p class="hero-sub">Select a service area to continue. Each section opens as its own page with complete feature access.</p>
        </div>
    </section>

    <section class="module-grid">
        <a href="{{ route('medical-services.index') }}" class="module-card">
            <div class="module-photo" style="background-image: url('https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1200&q=80');"></div>
            <div class="module-body">
                <h2 class="module-title">Medical Services</h2>
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
                <ul class="module-features">
                    <li>Emergency Contacts</li>
                    <li>Nearest Hospitals</li>
                    <li>First Aid Guide</li>
                    <li>Alert Notifications</li>
                </ul>
            </div>
        </a>
    </section>

    <section class="quick-actions" aria-label="Quick navigation">
        <a href="{{ route('booking.index') }}">Book Now</a>
        <a href="{{ route('my-health.index') }}">My Records</a>
        <a href="{{ route('emergency-info.index') }}">Emergency Help</a>
    </section>
@endsection
