@extends('layouts.portal')

@section('title', 'Emergency Info')

@section('content')
    <section class="hero-banner" style="--hero-image: url('https://images.unsplash.com/photo-1584515933487-779824d29309?auto=format&fit=crop&w=1600&q=80');">
        <div class="hero-content">
            <h1 class="hero-title">Emergency Info</h1>
            <p class="hero-sub">Fast access to critical support resources and emergency contacts.</p>
        </div>
    </section>

    <section class="section-card">
        <div class="section-head">
            <h2>Emergency Features</h2>
            <p>Preparedness and rapid response tools.</p>
        </div>

        <div class="feature-only-grid">
            <div class="feature-only-card">Emergency Contacts</div>
            <div class="feature-only-card">24/7 Hotline</div>
            <div class="feature-only-card">Nearest Hospitals</div>
            <div class="feature-only-card">First Aid Guide</div>
            <div class="feature-only-card">Emergency Alerts</div>
            <div class="feature-only-card">Incident Report</div>
        </div>

        <div class="photo-strip">
            <div class="photo-tile" style="background-image: url('https://images.unsplash.com/photo-1516574187841-cb9cc2ca948b?auto=format&fit=crop&w=900&q=80');"></div>
            <div class="photo-tile" style="background-image: url('https://images.unsplash.com/photo-1530026186672-2cd00ffc50fe?auto=format&fit=crop&w=900&q=80');"></div>
            <div class="photo-tile" style="background-image: url('https://images.unsplash.com/photo-1526256262350-7da7584cf5eb?auto=format&fit=crop&w=900&q=80');"></div>
        </div>
    </section>
@endsection
