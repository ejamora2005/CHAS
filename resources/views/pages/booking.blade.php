@extends('layouts.portal')

@section('title', 'Booking')

@section('content')
    <section class="hero-banner" style="--hero-image: url('https://images.unsplash.com/photo-1612892483236-52d32a0e0ac1?auto=format&fit=crop&w=1600&q=80');">
        <div class="hero-content">
            <h1 class="hero-title">Booking</h1>
            <p class="hero-sub">Manage appointments quickly with the booking feature set.</p>
        </div>
    </section>

    <section class="section-card">
        <div class="section-head">
            <h2>Booking Features</h2>
            <p>Everything needed to manage your clinic schedule.</p>
        </div>

        <div class="feature-only-grid">
            <div class="feature-only-card">Set Appointment</div>
            <div class="feature-only-card">Reschedule Appointment</div>
            <div class="feature-only-card">Cancel Booking</div>
            <div class="feature-only-card">Queue Tracker</div>
            <div class="feature-only-card">Appointment History</div>
            <div class="feature-only-card">Upcoming Reminders</div>
        </div>

        <div class="photo-strip">
            <div class="photo-tile" style="background-image: url('https://images.unsplash.com/photo-1606326608690-4e0281b1e588?auto=format&fit=crop&w=900&q=80');"></div>
            <div class="photo-tile" style="background-image: url('https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=900&q=80');"></div>
            <div class="photo-tile" style="background-image: url('https://images.unsplash.com/photo-1556740749-887f6717d7e4?auto=format&fit=crop&w=900&q=80');"></div>
        </div>
    </section>
@endsection
