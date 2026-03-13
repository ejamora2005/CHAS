@extends('layouts.portal')

@section('title', 'Booking')

@section('content')
    @php
        $today = now()->toDateString();
    @endphp

    <section class="hero-banner" style="--hero-image: url('https://images.unsplash.com/photo-1612892483236-52d32a0e0ac1?auto=format&fit=crop&w=1600&q=80');">
        <div class="hero-content">
            <h1 class="hero-title">Booking</h1>
            <p class="hero-sub">Set, reschedule, and cancel appointments. Track each booking using your queue number.</p>
        </div>
    </section>

    @if (session('status'))
        <section class="booking-flash" role="status">
            {{ session('status') }}
        </section>
    @endif

    <section class="booking-layout">
        <article class="booking-panel">
            <div class="section-head">
                <h2>Set Appointment</h2>
                <p>Submit a booking request for the clinic service you need.</p>
            </div>

            <form method="POST" action="{{ route('booking.store') }}" class="booking-form">
                @csrf

                <div class="booking-field">
                    <label for="service">Service</label>
                    <select id="service" name="service" class="@error('service') booking-input-error @enderror" required>
                        <option value="" disabled {{ old('service') ? '' : 'selected' }}>Select a service</option>
                        @foreach ($services as $service)
                            <option value="{{ $service }}" {{ old('service') === $service ? 'selected' : '' }}>{{ $service }}</option>
                        @endforeach
                    </select>
                    @error('service')
                        <p class="booking-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="booking-field-group">
                    <div class="booking-field">
                        <label for="appointment_date">Date</label>
                        <input
                            id="appointment_date"
                            type="date"
                            name="appointment_date"
                            value="{{ old('appointment_date') }}"
                            min="{{ $today }}"
                            class="@error('appointment_date') booking-input-error @enderror"
                            required
                        >
                        @error('appointment_date')
                            <p class="booking-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="booking-field">
                        <label for="appointment_time">Time</label>
                        <input
                            id="appointment_time"
                            type="time"
                            name="appointment_time"
                            value="{{ old('appointment_time') }}"
                            class="@error('appointment_time') booking-input-error @enderror"
                            required
                        >
                        @error('appointment_time')
                            <p class="booking-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="booking-field">
                    <label for="concern">Concern / Notes</label>
                    <textarea
                        id="concern"
                        name="concern"
                        rows="4"
                        placeholder="Tell us the reason for your visit..."
                        class="@error('concern') booking-input-error @enderror"
                    >{{ old('concern') }}</textarea>
                    @error('concern')
                        <p class="booking-error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="booking-submit">Book Appointment</button>
            </form>
        </article>

        <article class="booking-panel">
            <div class="section-head">
                <h2>My Appointments</h2>
                <p>Track queue number, status, and manage your bookings.</p>
            </div>

            <div class="booking-list">
                @forelse ($appointments as $appointment)
                    @php
                        $timeRaw = $appointment->appointment_time;
                        $timeDisplay = \Carbon\Carbon::createFromFormat(strlen($timeRaw) > 5 ? 'H:i:s' : 'H:i', $timeRaw)->format('g:i A');
                    @endphp
                    <article class="booking-item">
                        <div class="booking-item-main">
                            <p class="booking-service">{{ $appointment->service }}</p>
                            <p class="booking-meta">
                                {{ $appointment->appointment_date->format('M d, Y') }} at {{ $timeDisplay }}
                            </p>
                            <div class="booking-tags">
                                <span class="booking-badge booking-status booking-status-{{ $appointment->status }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                                <span class="booking-badge">{{ $appointment->queue_number }}</span>
                            </div>
                            @if ($appointment->concern)
                                <p class="booking-concern">{{ $appointment->concern }}</p>
                            @endif
                        </div>

                        <div class="booking-item-actions">
                            @if ($appointment->status !== 'cancelled')
                                <details class="booking-reschedule">
                                    <summary>Reschedule</summary>
                                    <form method="POST" action="{{ route('booking.reschedule', $appointment) }}" class="reschedule-form">
                                        @csrf
                                        @method('PATCH')
                                        <input type="date" name="appointment_date" min="{{ $today }}" required>
                                        <input type="time" name="appointment_time" required>
                                        <button type="submit">Save</button>
                                    </form>
                                </details>

                                <form method="POST" action="{{ route('booking.cancel', $appointment) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="booking-cancel">Cancel</button>
                                </form>
                            @else
                                <span class="booking-cancelled-note">Cancelled appointment</span>
                            @endif
                        </div>
                    </article>
                @empty
                    <p class="booking-empty">No bookings yet. Use the form to set your first appointment.</p>
                @endforelse
            </div>
        </article>
    </section>
@endsection
