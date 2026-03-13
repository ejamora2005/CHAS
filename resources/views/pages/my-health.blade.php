@extends('layouts.portal')

@section('title', 'My Health')

@section('content')
    <section class="hero-banner" style="--hero-image: url('https://images.unsplash.com/photo-1542736667-069246bdbc74?auto=format&fit=crop&w=1600&q=80');">
        <div class="hero-content">
            <h1 class="hero-title">My Health</h1>
            <p class="hero-sub">Review and manage your personal health information in one place.</p>
        </div>
    </section>

    <section class="section-card">
        <div class="section-head">
            <h2>Health Features</h2>
            <p>Personal records and monitoring tools.</p>
        </div>

        <div class="feature-only-grid">
            <div class="feature-only-card">Health Records</div>
            <div class="feature-only-card">Immunization Log</div>
            <div class="feature-only-card">Prescription Archive</div>
            <div class="feature-only-card">Laboratory Results</div>
            <div class="feature-only-card">Vital Tracker</div>
            <div class="feature-only-card">Clearance Status</div>
        </div>

        <div class="photo-strip">
            <div class="photo-tile" style="background-image: url('https://images.unsplash.com/photo-1498837167922-ddd27525d352?auto=format&fit=crop&w=900&q=80');"></div>
            <div class="photo-tile" style="background-image: url('https://images.unsplash.com/photo-1571772996211-2f02c9727629?auto=format&fit=crop&w=900&q=80');"></div>
            <div class="photo-tile" style="background-image: url('https://images.unsplash.com/photo-1599058917212-d750089bc07e?auto=format&fit=crop&w=900&q=80');"></div>
        </div>
    </section>
@endsection
