<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display the booking page with the current user's appointments.
     */
    public function index(): View
    {
        $appointments = Auth::user()
            ->appointments()
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        return view('pages.booking', [
            'appointments' => $appointments,
            'services' => $this->serviceOptions(),
        ]);
    }

    /**
     * Store a newly created appointment.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service' => ['required', 'string', 'in:'.implode(',', $this->serviceOptions())],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'concern' => ['nullable', 'string', 'max:1000'],
        ]);

        $hasConflict = Auth::user()
            ->appointments()
            ->whereDate('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($hasConflict) {
            return back()
                ->withErrors(['appointment_time' => 'You already have an appointment at this date and time.'])
                ->withInput();
        }

        Auth::user()->appointments()->create([
            ...$validated,
            'queue_number' => $this->generateQueueNumber(),
            'status' => 'pending',
        ]);

        return redirect()
            ->route('booking.index')
            ->with('status', 'Appointment booked successfully.');
    }

    /**
     * Reschedule an existing appointment.
     */
    public function reschedule(Request $request, Appointment $appointment): RedirectResponse
    {
        $this->assertOwnership($appointment);

        $validated = $request->validate([
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required', 'date_format:H:i'],
        ]);

        if ($appointment->status === 'cancelled') {
            return redirect()
                ->route('booking.index')
                ->with('status', 'Cancelled appointments cannot be rescheduled.');
        }

        $hasConflict = Auth::user()
            ->appointments()
            ->whereKeyNot($appointment->id)
            ->whereDate('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($hasConflict) {
            return back()
                ->withErrors(['appointment_time' => 'You already have another appointment at this date and time.'])
                ->withInput();
        }

        $appointment->update([
            ...$validated,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('booking.index')
            ->with('status', 'Appointment rescheduled successfully.');
    }

    /**
     * Cancel an existing appointment.
     */
    public function cancel(Appointment $appointment): RedirectResponse
    {
        $this->assertOwnership($appointment);

        if ($appointment->status !== 'cancelled') {
            $appointment->update(['status' => 'cancelled']);
        }

        return redirect()
            ->route('booking.index')
            ->with('status', 'Appointment cancelled.');
    }

    /**
     * Ensure the appointment belongs to the authenticated user.
     */
    private function assertOwnership(Appointment $appointment): void
    {
        abort_unless($appointment->user_id === Auth::id(), 403);
    }

    /**
     * Available booking services.
     *
     * @return array<int, string>
     */
    private function serviceOptions(): array
    {
        return [
            'General Consultation',
            'Dental Care',
            'Laboratory Requests',
            'Vaccination Services',
            'Mental Health Support',
            'Medical Certificate',
        ];
    }

    /**
     * Create a unique queue number for appointment tracking.
     */
    private function generateQueueNumber(): string
    {
        do {
            $queueNumber = 'CHAS-'.now()->format('ymd').'-'.str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (Appointment::where('queue_number', $queueNumber)->exists());

        return $queueNumber;
    }
}
