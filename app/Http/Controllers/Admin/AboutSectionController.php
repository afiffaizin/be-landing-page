<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AboutSectionController extends Controller
{
    /**
     * Display a listing of the about sections.
     */
    public function index(Request $request): View
    {
        $query = AboutSection::query()->latest();

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

        $aboutSections = $query->paginate(10)->withQueryString();

        return view('admin.about-section.index', compact('aboutSections'));
    }

    /**
     * Show the form for creating a new about section.
     */
    public function create(): View
    {
        return view('admin.about-section.create');
    }

    /**
     * Store a newly created about section in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'points' => ['nullable', 'array'],
            'points.*.number' => ['nullable'],
            'points.*.title' => ['nullable', 'string', 'max:255'],
            'points.*.description' => ['nullable', 'string'],
            'is_active' => ['nullable'],
        ]);

        $action = $request->input('action');
        if ($action === 'draft') {
            $isActive = false;
        } elseif ($action === 'publish') {
            $isActive = true;
        } else {
            $isActive = $request->boolean('is_active');
        }

        $validated['is_active'] = $isActive;

        // Hanya 1 about section yang aktif: jika section ini aktif, nonaktifkan (draft-kan) section lainnya
        if ($isActive) {
            AboutSection::where('is_active', true)->update(['is_active' => false]);
        }

        // Filter and format points array
        $points = [];
        if (!empty($validated['points']) && is_array($validated['points'])) {
            $idx = 1;
            foreach ($validated['points'] as $p) {
                if (!empty($p['title']) || !empty($p['description'])) {
                    $points[] = [
                        'number' => !empty($p['number']) ? (int) $p['number'] : $idx,
                        'title' => (string) ($p['title'] ?? ''),
                        'description' => (string) ($p['description'] ?? ''),
                    ];
                    $idx++;
                }
            }
        }
        $validated['points'] = $points;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('about-sections', 'public');
        }

        AboutSection::create($validated);

        $message = $isActive
            ? 'About section berhasil dipublikasikan.'
            : 'About section berhasil disimpan sebagai draft.';

        return redirect()->route('admin.about-sections.index')
            ->with('success', $message);
    }

    /**
     * Show the form for editing the specified about section.
     */
    public function edit(AboutSection $aboutSection): View
    {
        return view('admin.about-section.edit', compact('aboutSection'));
    }

    /**
     * Update the specified about section in storage.
     */
    public function update(Request $request, AboutSection $aboutSection): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'points' => ['nullable', 'array'],
            'points.*.number' => ['nullable'],
            'points.*.title' => ['nullable', 'string', 'max:255'],
            'points.*.description' => ['nullable', 'string'],
            'is_active' => ['nullable'],
            'remove_image' => ['nullable', 'boolean'],
        ]);

        $action = $request->input('action');
        if ($action === 'draft') {
            $isActive = false;
        } elseif ($action === 'publish') {
            $isActive = true;
        } else {
            $isActive = $request->boolean('is_active');
        }

        $validated['is_active'] = $isActive;

        // Hanya 1 about section yang aktif: jika section ini aktif, nonaktifkan section lainnya
        if ($isActive) {
            AboutSection::where('id', '!=', $aboutSection->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        // Filter and format points array
        $points = [];
        if (!empty($validated['points']) && is_array($validated['points'])) {
            $idx = 1;
            foreach ($validated['points'] as $p) {
                if (!empty($p['title']) || !empty($p['description'])) {
                    $points[] = [
                        'number' => !empty($p['number']) ? (int) $p['number'] : $idx,
                        'title' => (string) ($p['title'] ?? ''),
                        'description' => (string) ($p['description'] ?? ''),
                    ];
                    $idx++;
                }
            }
        }
        $validated['points'] = $points;

        if ($request->boolean('remove_image')) {
            if ($aboutSection->image && Storage::disk('public')->exists($aboutSection->image)) {
                Storage::disk('public')->delete($aboutSection->image);
            }
            $validated['image'] = null;
        } elseif ($request->hasFile('image')) {
            if ($aboutSection->image && Storage::disk('public')->exists($aboutSection->image)) {
                Storage::disk('public')->delete($aboutSection->image);
            }
            $validated['image'] = $request->file('image')->store('about-sections', 'public');
        } else {
            unset($validated['image']);
        }

        unset($validated['remove_image']);
        $aboutSection->update($validated);

        $message = $isActive
            ? 'About section berhasil diperbarui.'
            : 'About section berhasil disimpan sebagai draft.';

        return redirect()->route('admin.about-sections.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified about section from storage.
     */
    public function destroy(AboutSection $aboutSection): RedirectResponse
    {
        if ($aboutSection->image && Storage::disk('public')->exists($aboutSection->image)) {
            Storage::disk('public')->delete($aboutSection->image);
        }

        $aboutSection->delete();

        return redirect()->route('admin.about-sections.index')
            ->with('success', 'About section berhasil dihapus.');
    }

    /**
     * Toggle the active status of the specified about section.
     */
    public function toggleStatus(AboutSection $aboutSection): RedirectResponse
    {
        $newStatus = !$aboutSection->is_active;

        // Hanya 1 about section yang aktif: jika diaktifkan, nonaktifkan section lainnya
        if ($newStatus) {
            AboutSection::where('id', '!=', $aboutSection->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $aboutSection->update([
            'is_active' => $newStatus,
        ]);

        $message = $newStatus 
            ? 'About section berhasil diaktifkan.' 
            : 'About section berhasil dinonaktifkan.';

        return back()->with('success', $message);
    }
}
