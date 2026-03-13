@extends('layouts.portal')

@section('title', 'Medical Services')

@section('content')
    @php
        $today = now()->toDateString();
    @endphp

    <section class="hero-banner" style="--hero-image: url('https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=1600&q=80');">
        <div class="hero-content">
            <h1 class="hero-title">Medical Services</h1>
            <p class="hero-sub">Request campus clinic services and monitor request status in real time.</p>
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
                <h2>Request a Medical Service</h2>
                <p>Submit a request and choose preferred schedule and priority.</p>
            </div>

            <form method="POST" action="{{ route('medical-services.store') }}" class="booking-form">
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
                        <label for="preferred_date">Preferred Date</label>
                        <input
                            id="preferred_date"
                            type="date"
                            name="preferred_date"
                            value="{{ old('preferred_date', $today) }}"
                            min="{{ $today }}"
                            class="@error('preferred_date') booking-input-error @enderror"
                            required
                        >
                        @error('preferred_date')
                            <p class="booking-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="booking-field">
                        <label for="priority">Priority</label>
                        <select id="priority" name="priority" class="@error('priority') booking-input-error @enderror" required>
                            @foreach ($priorities as $priority)
                                <option value="{{ $priority }}" {{ old('priority', 'medium') === $priority ? 'selected' : '' }}>
                                    {{ ucfirst($priority) }}
                                </option>
                            @endforeach
                        </select>
                        @error('priority')
                            <p class="booking-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="booking-field">
                    <label for="notes">Notes</label>
                    <textarea
                        id="notes"
                        name="notes"
                        rows="4"
                        placeholder="Optional details for clinic staff..."
                        class="@error('notes') booking-input-error @enderror"
                    >{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="booking-error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="booking-submit">Submit Request</button>
            </form>
        </article>

        <article class="booking-panel">
            <div class="section-head">
                <h2>My Service Requests</h2>
                <p>Keep requests accurate by updating status and removing outdated entries.</p>
            </div>

            <div class="booking-list">
                @forelse ($serviceRequests as $serviceRequest)
                    <article class="booking-item">
                        <div class="booking-item-main">
                            <p class="booking-service">{{ $serviceRequest->service }}</p>
                            <p class="booking-meta">
                                Preferred date: {{ $serviceRequest->preferred_date->format('M d, Y') }}
                            </p>
                            <div class="booking-tags">
                                <span class="booking-badge booking-status booking-status-{{ $serviceRequest->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $serviceRequest->status)) }}
                                </span>
                                <span class="booking-badge service-priority service-priority-{{ $serviceRequest->priority }}">
                                    {{ ucfirst($serviceRequest->priority) }} Priority
                                </span>
                            </div>
                            @if ($serviceRequest->notes)
                                <p class="booking-concern">{{ $serviceRequest->notes }}</p>
                            @endif
                        </div>

                        <div class="booking-item-actions">
                            <form method="POST" action="{{ route('medical-services.update-status', $serviceRequest) }}" class="health-status-form">
                                @csrf
                                @method('PATCH')
                                <select name="status" required>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}" {{ $serviceRequest->status === $status ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit">Update</button>
                            </form>

                            <form method="POST" action="{{ route('medical-services.destroy', $serviceRequest) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="booking-cancel">Delete</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <p class="booking-empty">No service requests yet. Submit your first request using the form.</p>
                @endforelse
            </div>
        </article>
    </section>
@endsection
