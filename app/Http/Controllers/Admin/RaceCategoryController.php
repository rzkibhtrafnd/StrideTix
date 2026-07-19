<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RaceCategory;
use App\Models\Event;
use App\Services\RaceCategoryService;
use App\Http\Requests\RaceCategoryRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Enums\EventStatus;

class RaceCategoryController extends Controller
{
    public function __construct(
        protected RaceCategoryService $categoryService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'event_id']);
        
        $categories = $this->categoryService->getAllCategories($filters);
        
        $events = Event::latest()->get();

        return view('admin.race_categories.index', compact('categories', 'events', 'filters'));
    }

    public function create(): View
    {
        $events = Event::where('status', EventStatus::PUBLISHED->value)
                    ->orWhere('status', EventStatus::DRAFT->value)
                    ->latest()->get();
        return view('admin.race_categories.create', compact('events'));
    }

    public function store(RaceCategoryRequest $request): RedirectResponse
    {
        $this->categoryService->createCategory($request->validated());
        return redirect()->route('admin.race-categories.index')->with('success', 'Kategori kompetisi lari berhasil ditambahkan.');
    }

    public function edit(RaceCategory $raceCategory): View
    {
        $events = Event::latest()->get();
        return view('admin.race_categories.edit', compact('raceCategory', 'events'));
    }

    public function update(RaceCategoryRequest $request, RaceCategory $raceCategory): RedirectResponse
    {
        $this->categoryService->updateCategory($raceCategory, $request->validated());
        return redirect()->route('admin.race-categories.index')->with('success', 'Data spesifikasi kategori berhasil diperbarui.');
    }

    public function destroy(RaceCategory $raceCategory): RedirectResponse
    {
        $this->categoryService->deleteCategory($raceCategory);
        return redirect()->route('admin.race-categories.index')->with('success', 'Kategori pendaftaran berhasil dihapus.');
    }
}