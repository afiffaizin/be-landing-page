<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HomeSectionController extends Controller
{
    /**
     * Display a listing of the home sections.
     */
    public function index(Request $request): View
    {
        $query = HomeSection::query()->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $homeSections = $query->paginate(10)->withQueryString();

        return view('admin.home-section.index', compact('homeSections'));
    }

    /**
     * Show the form for creating a new home section.
     */
    public function create(): View
    {
        return view('admin.home-section.create');
    }

    /**
     * Store a newly created home section in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'button_one_text' => ['nullable', 'string', 'max:255'],
            'button_one_link' => ['nullable', 'string', 'max:255'],
            'button_two_text' => ['nullable', 'string', 'max:255'],
            'button_two_link' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('home-sections', 'public');
        }

        HomeSection::create($validated);

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'Banner Beranda (Home Section) berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified home section.
     */
    public function edit(HomeSection $homeSection): View
    {
        return view('admin.home-section.edit', compact('homeSection'));
    }

    /**
     * Update the specified home section in storage.
     */
    public function update(Request $request, HomeSection $homeSection): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'button_one_text' => ['nullable', 'string', 'max:255'],
            'button_one_link' => ['nullable', 'string', 'max:255'],
            'button_two_text' => ['nullable', 'string', 'max:255'],
            'button_two_link' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable'],
            'remove_image' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->boolean('remove_image')) {
            if ($homeSection->image && Storage::disk('public')->exists($homeSection->image)) {
                Storage::disk('public')->delete($homeSection->image);
            }
            $validated['image'] = null;
        } elseif ($request->hasFile('image')) {
            if ($homeSection->image && Storage::disk('public')->exists($homeSection->image)) {
                Storage::disk('public')->delete($homeSection->image);
            }
            $validated['image'] = $request->file('image')->store('home-sections', 'public');
        } else {
            unset($validated['image']);
        }

        unset($validated['remove_image']);
        $homeSection->update($validated);

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'Banner Beranda (Home Section) berhasil diperbarui!');
    }

    /**
     * Remove the specified home section from storage.
     */
    public function destroy(HomeSection $homeSection): RedirectResponse
    {
        if ($homeSection->image && Storage::disk('public')->exists($homeSection->image)) {
            Storage::disk('public')->delete($homeSection->image);
        }

        $homeSection->delete();

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'Banner Beranda berhasil dihapus!');
    }

    /**
     * Toggle the active status of the specified home section.
     */
    public function toggleStatus(HomeSection $homeSection): RedirectResponse
    {
        $homeSection->update([
            'is_active' => !$homeSection->is_active,
        ]);

        $statusText = $homeSection->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Status banner berhasil {$statusText}.");
    }
}
