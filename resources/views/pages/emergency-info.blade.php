@extends('layouts.portal')

@section('title', 'Emergency Info')

@section('content')
    <section class="hero-banner" style="--hero-image: url('https://images.unsplash.com/photo-1584515933487-779824d29309?auto=format&fit=crop&w=1600&q=80');">
        <div class="hero-content">
            <h1 class="hero-title">Emergency Info</h1>
            <p class="hero-sub">Maintain accurate emergency contacts and keep quick-response resources ready.</p>
        </div>
    </section>

    @if (session('status'))
        <section class="booking-flash" role="status">
            {{ session('status') }}
        </section>
    @endif

    <section class="section-card">
        <div class="section-head">
            <h2>Quick Emergency Resources</h2>
            <p>Important contact points for urgent incidents.</p>
        </div>
        <div class="feature-only-grid">
            <a class="feature-only-card feature-link-card" href="tel:911">National Emergency Hotline: 911</a>
            <a class="feature-only-card feature-link-card" href="tel:+63123456789">Campus Clinic Hotline: +63 123 456 789</a>
            <a class="feature-only-card feature-link-card" href="{{ route('medical-services.index') }}">Medical Services Request Desk</a>
            <a class="feature-only-card feature-link-card" href="{{ route('booking.index') }}">Open Booking and Queue Tracker</a>
            <a class="feature-only-card feature-link-card" href="{{ route('my-health.index') }}">Open Health Records</a>
            <a class="feature-only-card feature-link-card" href="https://www.redcross.org/" target="_blank" rel="noopener noreferrer">First Aid Guide (Red Cross)</a>
        </div>
    </section>

    <section class="booking-layout">
        <article class="booking-panel">
            <div class="section-head">
                <h2>Add Emergency Contact</h2>
                <p>Save who should be contacted first during emergencies.</p>
            </div>

            <form method="POST" action="{{ route('emergency-info.store-contact') }}" class="booking-form">
                @csrf

                <div class="booking-field">
                    <label for="name">Contact Name</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Full name"
                        class="@error('name') booking-input-error @enderror"
                        required
                    >
                    @error('name')
                        <p class="booking-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="booking-field-group">
                    <div class="booking-field">
                        <label for="relationship">Relationship</label>
                        <select id="relationship" name="relationship" class="@error('relationship') booking-input-error @enderror" required>
                            <option value="" disabled {{ old('relationship') ? '' : 'selected' }}>Select relationship</option>
                            @foreach ($relationships as $relationship)
                                <option value="{{ $relationship }}" {{ old('relationship') === $relationship ? 'selected' : '' }}>
                                    {{ $relationship }}
                                </option>
                            @endforeach
                        </select>
                        @error('relationship')
                            <p class="booking-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="booking-field">
                        <label for="phone">Phone Number</label>
                        <input
                            id="phone"
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="+63..."
                            class="@error('phone') booking-input-error @enderror"
                            required
                        >
                        @error('phone')
                            <p class="booking-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="booking-field-group">
                    <div class="booking-field">
                        <label for="email">Email (Optional)</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="email@example.com"
                            class="@error('email') booking-input-error @enderror"
                        >
                        @error('email')
                            <p class="booking-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="booking-field">
                        <label for="address">Address (Optional)</label>
                        <input
                            id="address"
                            type="text"
                            name="address"
                            value="{{ old('address') }}"
                            placeholder="Address"
                            class="@error('address') booking-input-error @enderror"
                        >
                        @error('address')
                            <p class="booking-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="booking-field">
                    <label for="notes">Notes</label>
                    <textarea
                        id="notes"
                        name="notes"
                        rows="3"
                        placeholder="Optional notes..."
                        class="@error('notes') booking-input-error @enderror"
                    >{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="booking-error">{{ $message }}</p>
                    @enderror
                </div>

                <label class="contact-primary-check">
                    <input type="checkbox" name="is_primary" value="1" {{ old('is_primary') ? 'checked' : '' }}>
                    Set as primary emergency contact
                </label>

                <button type="submit" class="booking-submit">Save Contact</button>
            </form>
        </article>

        <article class="booking-panel">
            <div class="section-head">
                <h2>My Emergency Contacts</h2>
                <p>Keep records updated so responders can reach the right person quickly.</p>
            </div>

            <div class="booking-list">
                @forelse ($contacts as $contact)
                    <article class="booking-item">
                        <div class="booking-item-main">
                            <p class="booking-service">{{ $contact->name }}</p>
                            <p class="booking-meta">{{ $contact->relationship }} - {{ $contact->phone }}</p>
                            <div class="booking-tags">
                                @if ($contact->is_primary)
                                    <span class="booking-badge booking-status booking-status-confirmed">Primary Contact</span>
                                @else
                                    <span class="booking-badge">Secondary Contact</span>
                                @endif
                                @if ($contact->email)
                                    <span class="booking-badge">{{ $contact->email }}</span>
                                @endif
                            </div>
                            @if ($contact->address || $contact->notes)
                                <p class="booking-concern">
                                    {{ $contact->address ? 'Address: '.$contact->address : '' }}
                                    {{ $contact->address && $contact->notes ? ' | ' : '' }}
                                    {{ $contact->notes }}
                                </p>
                            @endif
                        </div>

                        <div class="booking-item-actions">
                            @if (! $contact->is_primary)
                                <form method="POST" action="{{ route('emergency-info.set-primary', $contact) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit">Set Primary</button>
                                </form>
                            @endif

                            <form method="POST" action="{{ route('emergency-info.destroy-contact', $contact) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="booking-cancel">Delete</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <p class="booking-empty">No emergency contacts yet. Add at least one primary contact.</p>
                @endforelse
            </div>
        </article>
    </section>
@endsection
