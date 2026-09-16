<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestimonialSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimonialSectionController extends Controller
{
    public function index(Request $request): View
    {
        $query = TestimonialSection::query()->with(['statistics', 'testimonials'])->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $testimonialSections = $query->paginate(10)->withQueryString();

        return view('admin.testimonial-section.index', compact('testimonialSections'));
    }

    public function create(): View
    {
        return view('admin.testimonial-section.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable'],
            
            'statistics' => ['nullable', 'array'],
            'statistics.*.value' => ['nullable', 'string', 'max:255'],
            'statistics.*.description' => ['nullable', 'string'],
            
            'testimonials' => ['nullable', 'array'],
            'testimonials.*.quote' => ['nullable', 'string'],
            'testimonials.*.name' => ['nullable', 'string', 'max:255'],
            'testimonials.*.subtitle' => ['nullable', 'string', 'max:255'],
        ]);

        $action = $request->input('action');
        if ($action === 'draft') {
            $isActive = false;
        } elseif ($action === 'publish') {
            $isActive = true;
        } else {
            $isActive = $request->boolean('is_active');
        }

        if ($isActive) {
            TestimonialSection::where('is_active', true)->update(['is_active' => false]);
        }

        $section = TestimonialSection::create([
            'title' => $validated['title'],
            'is_active' => $isActive,
        ]);

        if ($request->has('statistics') && is_array($request->input('statistics'))) {
            foreach ($request->input('statistics') as $statData) {
                $val = trim($statData['value'] ?? '');
                $desc = trim($statData['description'] ?? '');

                if ($val !== '' || $desc !== '') {
                    $section->statistics()->create([
                        'value' => $val,
                        'description' => $desc,
                    ]);
                }
            }
        }

        if ($request->has('testimonials') && is_array($request->input('testimonials'))) {
            foreach ($request->input('testimonials') as $itemData) {
                $quote = trim($itemData['quote'] ?? '');
                $name = trim($itemData['name'] ?? '');
                $subtitle = trim($itemData['subtitle'] ?? '');

                if ($quote !== '' || $name !== '') {
                    $section->testimonials()->create([
                        'quote' => $quote,
                        'name' => $name,
                        'subtitle' => $subtitle,
                    ]);
                }
            }
        }

        $message = $isActive ? 'Testimonial Section berhasil dipublikasikan.' : 'Testimonial Section berhasil disimpan sebagai draft.';
        return redirect()->route('admin.testimonial-sections.index')->with('success', $message);
    }

    public function edit(TestimonialSection $testimonialSection): View
    {
        $testimonialSection->load(['statistics', 'testimonials']);
        return view('admin.testimonial-section.edit', compact('testimonialSection'));
    }

    public function update(Request $request, TestimonialSection $testimonialSection): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable'],
            
            'statistics' => ['nullable', 'array'],
            'statistics.*.id' => ['nullable', 'integer'],
            'statistics.*.value' => ['nullable', 'string', 'max:255'],
            'statistics.*.description' => ['nullable', 'string'],
            
            'testimonials' => ['nullable', 'array'],
            'testimonials.*.id' => ['nullable', 'integer'],
            'testimonials.*.quote' => ['nullable', 'string'],
            'testimonials.*.name' => ['nullable', 'string', 'max:255'],
            'testimonials.*.subtitle' => ['nullable', 'string', 'max:255'],
        ]);

        $action = $request->input('action');
        if ($action === 'draft') {
            $isActive = false;
        } elseif ($action === 'publish') {
            $isActive = true;
        } else {
            $isActive = $request->boolean('is_active');
        }

        if ($isActive) {
            TestimonialSection::where('id', '!=', $testimonialSection->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $testimonialSection->update([
            'title' => $validated['title'],
            'is_active' => $isActive,
        ]);

        // Process statistics
        $submittedStats = $request->input('statistics', []);
        $existingStats = $testimonialSection->statistics()->get()->keyBy('id');
        $keptStatIds = [];

        if (is_array($submittedStats)) {
            foreach ($submittedStats as $statData) {
                $statId = !empty($statData['id']) ? (int) $statData['id'] : null;
                $val = trim($statData['value'] ?? '');
                $desc = trim($statData['description'] ?? '');

                if ($statId && $existingStats->has($statId)) {
                    $stat = $existingStats->get($statId);
                    $stat->update([
                        'value' => $val,
                        'description' => $desc,
                    ]);
                    $keptStatIds[] = $statId;
                } elseif ($val !== '' || $desc !== '') {
                    $newStat = $testimonialSection->statistics()->create([
                        'value' => $val,
                        'description' => $desc,
                    ]);
                    $keptStatIds[] = $newStat->id;
                }
            }
        }

        foreach ($existingStats as $existingId => $existingStat) {
            if (!in_array($existingId, $keptStatIds)) {
                $existingStat->delete();
            }
        }

        // Process testimonials
        $submittedItems = $request->input('testimonials', []);
        $existingItems = $testimonialSection->testimonials()->get()->keyBy('id');
        $keptItemIds = [];

        if (is_array($submittedItems)) {
            foreach ($submittedItems as $itemData) {
                $itemId = !empty($itemData['id']) ? (int) $itemData['id'] : null;
                $quote = trim($itemData['quote'] ?? '');
                $name = trim($itemData['name'] ?? '');
                $subtitle = trim($itemData['subtitle'] ?? '');

                if ($itemId && $existingItems->has($itemId)) {
                    $item = $existingItems->get($itemId);
                    $item->update([
                        'quote' => $quote,
                        'name' => $name,
                        'subtitle' => $subtitle,
                    ]);
                    $keptItemIds[] = $itemId;
                } elseif ($quote !== '' || $name !== '') {
                    $newItem = $testimonialSection->testimonials()->create([
                        'quote' => $quote,
                        'name' => $name,
                        'subtitle' => $subtitle,
                    ]);
                    $keptItemIds[] = $newItem->id;
                }
            }
        }

        foreach ($existingItems as $existingId => $existingItem) {
            if (!in_array($existingId, $keptItemIds)) {
                $existingItem->delete();
            }
        }

        $message = $isActive ? 'Testimonial Section berhasil diperbarui.' : 'Testimonial Section berhasil disimpan sebagai draft.';
        return redirect()->route('admin.testimonial-sections.index')->with('success', $message);
    }

    public function destroy(TestimonialSection $testimonialSection): RedirectResponse
    {
        $testimonialSection->delete();
        return redirect()->route('admin.testimonial-sections.index')->with('success', 'Testimonial Section berhasil dihapus.');
    }

    public function toggleStatus(TestimonialSection $testimonialSection): RedirectResponse
    {
        $newStatus = !$testimonialSection->is_active;

        if ($newStatus) {
            TestimonialSection::where('id', '!=', $testimonialSection->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $testimonialSection->update([
            'is_active' => $newStatus,
        ]);

        $message = $newStatus ? 'Testimonial Section berhasil diaktifkan.' : 'Testimonial Section berhasil dinonaktifkan.';
        return back()->with('success', $message);
    }
}
