<?php

namespace App\Http\Controllers;

use App\Models\HealthRecord;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyHealthController extends Controller
{
    /**
     * Display the health records page.
     */
    public function index(): View
    {
        $healthRecords = Auth::user()
            ->healthRecords()
            ->orderByDesc('record_date')
            ->orderByDesc('id')
            ->get();

        return view('pages.my-health', [
            'healthRecords' => $healthRecords,
            'categories' => $this->categoryOptions(),
            'statuses' => $this->statusOptions(),
        ]);
    }

    /**
     * Store a new health record.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => ['required', 'string', 'in:'.implode(',', $this->categoryOptions())],
            'title' => ['required', 'string', 'max:120'],
            'value' => ['nullable', 'string', 'max:120'],
            'record_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        Auth::user()->healthRecords()->create([
            ...$validated,
            'status' => 'active',
        ]);

        return redirect()
            ->route('my-health.index')
            ->with('status', 'Health record added successfully.');
    }

    /**
     * Update the status of a health record.
     */
    public function updateStatus(Request $request, HealthRecord $healthRecord): RedirectResponse
    {
        $this->assertOwnership($healthRecord);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:'.implode(',', $this->statusOptions())],
        ]);

        $healthRecord->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('my-health.index')
            ->with('status', 'Health record status updated.');
    }

    /**
     * Delete a health record.
     */
    public function destroy(HealthRecord $healthRecord): RedirectResponse
    {
        $this->assertOwnership($healthRecord);

        $healthRecord->delete();

        return redirect()
            ->route('my-health.index')
            ->with('status', 'Health record removed.');
    }

    /**
     * Ensure the health record belongs to the authenticated user.
     */
    private function assertOwnership(HealthRecord $healthRecord): void
    {
        abort_unless($healthRecord->user_id === Auth::id(), 403);
    }

    /**
     * Available categories for records.
     *
     * @return array<int, string>
     */
    private function categoryOptions(): array
    {
        return [
            'Health Records',
            'Immunization Log',
            'Prescription Archive',
            'Laboratory Results',
            'Vital Tracker',
            'Clearance Status',
        ];
    }

    /**
     * Available statuses for records.
     *
     * @return array<int, string>
     */
    private function statusOptions(): array
    {
        return [
            'active',
            'resolved',
            'archived',
        ];
    }
}
