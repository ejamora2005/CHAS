<?php

namespace App\Http\Controllers;

use App\Models\MedicalServiceRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalServiceController extends Controller
{
    /**
     * Display the medical services page.
     */
    public function index(): View
    {
        $serviceRequests = Auth::user()
            ->medicalServiceRequests()
            ->orderByDesc('preferred_date')
            ->orderByDesc('id')
            ->get();

        return view('pages.medical-services', [
            'serviceRequests' => $serviceRequests,
            'services' => $this->serviceOptions(),
            'priorities' => $this->priorityOptions(),
            'statuses' => $this->statusOptions(),
        ]);
    }

    /**
     * Store a new service request.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service' => ['required', 'string', 'in:'.implode(',', $this->serviceOptions())],
            'preferred_date' => ['required', 'date', 'after_or_equal:today'],
            'priority' => ['required', 'string', 'in:'.implode(',', $this->priorityOptions())],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        Auth::user()->medicalServiceRequests()->create([
            ...$validated,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('medical-services.index')
            ->with('status', 'Medical service request submitted.');
    }

    /**
     * Update the status of a service request.
     */
    public function updateStatus(Request $request, MedicalServiceRequest $medicalServiceRequest): RedirectResponse
    {
        $this->assertOwnership($medicalServiceRequest);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:'.implode(',', $this->statusOptions())],
        ]);

        $medicalServiceRequest->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('medical-services.index')
            ->with('status', 'Service request status updated.');
    }

    /**
     * Delete a service request.
     */
    public function destroy(MedicalServiceRequest $medicalServiceRequest): RedirectResponse
    {
        $this->assertOwnership($medicalServiceRequest);

        $medicalServiceRequest->delete();

        return redirect()
            ->route('medical-services.index')
            ->with('status', 'Service request removed.');
    }

    /**
     * Ensure the request belongs to the authenticated user.
     */
    private function assertOwnership(MedicalServiceRequest $medicalServiceRequest): void
    {
        abort_unless($medicalServiceRequest->user_id === Auth::id(), 403);
    }

    /**
     * Available service categories.
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
     * Available priorities.
     *
     * @return array<int, string>
     */
    private function priorityOptions(): array
    {
        return [
            'low',
            'medium',
            'high',
            'urgent',
        ];
    }

    /**
     * Available statuses.
     *
     * @return array<int, string>
     */
    private function statusOptions(): array
    {
        return [
            'pending',
            'in_review',
            'scheduled',
            'completed',
            'cancelled',
        ];
    }
}
