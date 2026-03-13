@extends('layouts.portal')

@section('title', 'Medical Services')

@section('content')
    <section class="hero-banner" style="--hero-image: url('https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=1600&q=80');">
        <div class="hero-content">
            <h1 class="hero-title">Medical Services</h1>
            <p class="hero-sub">Core campus clinic services available for students and staff.</p>
        </div>
    </section>

    <section class="section-card">
        <div class="section-head">
            <h2>Service Features</h2>
            <p>Pick a service feature below.</p>
        </div>

        <div class="feature-only-grid">
            <div class="feature-only-card">General Consultation</div>
            <div class="feature-only-card">Dental Care</div>
            <div class="feature-only-card">Laboratory Requests</div>
            <div class="feature-only-card">Vaccination Services</div>
            <div class="feature-only-card">Mental Health Support</div>
            <div class="feature-only-card">Medical Certificate</div>
        </div>

        <div class="photo-strip">
            <div class="photo-tile" style="background-image: url('https://images.unsplash.com/photo-1666214280557-f1b5022eb634?auto=format&fit=crop&w=900&q=80');"></div>
            <div class="photo-tile" style="background-image: url('https://images.unsplash.com/photo-1581595219315-a187dd40c322?auto=format&fit=crop&w=900&q=80');"></div>
            <div class="photo-tile" style="background-image: url('https://images.unsplash.com/photo-1512678080530-7760d81faba6?auto=format&fit=crop&w=900&q=80');"></div>
        </div>
    </section>
@endsection
