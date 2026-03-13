@extends('layouts.portal')

@section('title', 'My Health')

@section('content')
    @php
        $today = now()->toDateString();
    @endphp

    <section class="hero-banner" style="--hero-image: url('https://images.unsplash.com/photo-1542736667-069246bdbc74?auto=format&fit=crop&w=1600&q=80');">
        <div class="hero-content">
            <h1 class="hero-title">My Health</h1>
            <p class="hero-sub">Add health entries, track statuses, and maintain your personal wellness history in one place.</p>
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
                <h2>Add Health Record</h2>
                <p>Save a new health note, lab result, or status update.</p>
            </div>

            <form method="POST" action="{{ route('my-health.store') }}" class="booking-form">
                @csrf

                <div class="booking-field">
                    <label for="category">Category</label>
                    <select id="category" name="category" class="@error('category') booking-input-error @enderror" required>
                        <option value="" disabled {{ old('category') ? '' : 'selected' }}>Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" {{ old('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="booking-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="booking-field">
                    <label for="title">Title</label>
                    <input
                        id="title"
                        type="text"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="Example: Blood Pressure Check"
                        class="@error('title') booking-input-error @enderror"
                        required
                    >
                    @error('title')
                        <p class="booking-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="booking-field-group">
                    <div class="booking-field">
                        <label for="value">Value / Result</label>
                        <input
                            id="value"
                            type="text"
                            name="value"
                            value="{{ old('value') }}"
                            placeholder="e.g. 120/80 mmHg"
                            class="@error('value') booking-input-error @enderror"
                        >
                        @error('value')
                            <p class="booking-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="booking-field">
                        <label for="record_date">Record Date</label>
                        <input
                            id="record_date"
                            type="date"
                            name="record_date"
                            value="{{ old('record_date', $today) }}"
                            class="@error('record_date') booking-input-error @enderror"
                            required
                        >
                        @error('record_date')
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
                        placeholder="Optional details..."
                        class="@error('notes') booking-input-error @enderror"
                    >{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="booking-error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="booking-submit">Save Record</button>
            </form>
        </article>

        <article class="booking-panel">
            <div class="section-head">
                <h2>My Health Records</h2>
                <p>Update status or remove outdated entries.</p>
            </div>

            <div class="booking-list">
                @forelse ($healthRecords as $record)
                    <article class="booking-item">
                        <div class="booking-item-main">
                            <p class="booking-service">{{ $record->title }}</p>
                            <p class="booking-meta">{{ $record->category }} - {{ $record->record_date->format('M d, Y') }}</p>
                            <div class="booking-tags">
                                <span class="booking-badge booking-status booking-status-{{ $record->status }}">
                                    {{ ucfirst($record->status) }}
                                </span>
                                @if ($record->value)
                                    <span class="booking-badge">{{ $record->value }}</span>
                                @endif
                            </div>
                            @if ($record->notes)
                                <p class="booking-concern">{{ $record->notes }}</p>
                            @endif
                        </div>

                        <div class="booking-item-actions">
                            <form method="POST" action="{{ route('my-health.update-status', $record) }}" class="health-status-form">
                                @csrf
                                @method('PATCH')
                                <select name="status" required>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}" {{ $record->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                                <button type="submit">Update</button>
                            </form>

                            <form method="POST" action="{{ route('my-health.destroy', $record) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="booking-cancel">Delete</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <p class="booking-empty">No health records yet. Add your first entry using the form.</p>
                @endforelse
            </div>
        </article>
    </section>
@endsection
