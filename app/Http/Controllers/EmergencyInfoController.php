<?php

namespace App\Http\Controllers;

use App\Models\EmergencyContact;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmergencyInfoController extends Controller
{
    /**
     * Display emergency resources and contacts.
     */
    public function index(): View
    {
        $contacts = Auth::user()
            ->emergencyContacts()
            ->orderByDesc('is_primary')
            ->orderBy('name')
            ->get();

        return view('pages.emergency-info', [
            'contacts' => $contacts,
            'relationships' => $this->relationshipOptions(),
        ]);
    }

    /**
     * Store a new emergency contact.
     */
    public function storeContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'relationship' => ['required', 'string', 'in:'.implode(',', $this->relationshipOptions())],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:120'],
            'address' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'is_primary' => ['nullable', 'boolean'],
        ]);

        $user = Auth::user();

        $isPrimary = (bool) ($validated['is_primary'] ?? false);
        if ($isPrimary) {
            $user->emergencyContacts()->update(['is_primary' => false]);
        }

        $user->emergencyContacts()->create([
            ...$validated,
            'is_primary' => $isPrimary,
        ]);

        return redirect()
            ->route('emergency-info.index')
            ->with('status', 'Emergency contact added.');
    }

    /**
     * Mark a contact as primary.
     */
    public function setPrimary(EmergencyContact $emergencyContact): RedirectResponse
    {
        $this->assertOwnership($emergencyContact);

        Auth::user()->emergencyContacts()->update(['is_primary' => false]);
        $emergencyContact->update(['is_primary' => true]);

        return redirect()
            ->route('emergency-info.index')
            ->with('status', 'Primary emergency contact updated.');
    }

    /**
     * Delete an emergency contact.
     */
    public function destroy(EmergencyContact $emergencyContact): RedirectResponse
    {
        $this->assertOwnership($emergencyContact);

        $emergencyContact->delete();

        return redirect()
            ->route('emergency-info.index')
            ->with('status', 'Emergency contact removed.');
    }

    /**
     * Ensure the contact belongs to the authenticated user.
     */
    private function assertOwnership(EmergencyContact $emergencyContact): void
    {
        abort_unless($emergencyContact->user_id === Auth::id(), 403);
    }

    /**
     * Supported relationship options.
     *
     * @return array<int, string>
     */
    private function relationshipOptions(): array
    {
        return [
            'Parent',
            'Sibling',
            'Guardian',
            'Spouse',
            'Friend',
            'Relative',
            'Other',
        ];
    }
}
