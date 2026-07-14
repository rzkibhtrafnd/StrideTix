<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Organizer;
use App\Enums\UserRole;
use App\Services\OrganizerService;
use App\Http\Requests\OrganizerRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrganizerController extends Controller
{
    public function __construct(
        protected OrganizerService $organizerService
    ) {}

    public function index(): View
    {
        $organizers = $this->organizerService->getAllOrganizers();
        return view('admin.organizers.index', compact('organizers'));
    }

    public function create(): View
    {
        $users = User::where('role', UserRole::ORGANIZER->value)
                    ->whereDoesntHave('organizer')
                    ->get();
        return view('admin.organizers.create', compact('users'));
    }

    public function store(OrganizerRequest $request): RedirectResponse
    {
        $this->organizerService->createOrganizer(
            $request->validated(), 
            $request->file('logo')
        );
        return redirect()->route('admin.organizers.index')->with('success', 'Profil penyelenggara (EO) berhasil didaftarkan.');
    }

    public function show(Organizer $organizer): View
    {
        return view('admin.organizers.show', compact('organizer'));
    }

    public function edit(Organizer $organizer): View
    {
        $users = User::where('role', UserRole::ORGANIZER->value)->get();
        return view('admin.organizers.edit', compact('organizer', 'users'));
    }

    public function update(OrganizerRequest $request, Organizer $organizer): RedirectResponse
    {
        $this->organizerService->updateOrganizer(
            $organizer, 
            $request->validated(), 
            $request->file('logo')
        );
        return redirect()->route('admin.organizers.index')->with('success', 'Data profil penyelenggara berhasil diubah.');
    }

    public function destroy(Organizer $organizer): RedirectResponse
    {
        $this->organizerService->deleteOrganizer($organizer);
        return redirect()->route('admin.organizers.index')->with('success', 'Profil institusi penyelenggara berhasil dihapus.');
    }
}