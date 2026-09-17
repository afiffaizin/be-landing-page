<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HowToOrderSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HowToOrderSectionController extends Controller
{
    public function index(Request $request): View
    {
        $query = HowToOrderSection::query()->with('steps')->latest();

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

        $howToOrderSections = $query->paginate(10)->withQueryString();

        return view('admin.how-to-order.index', compact('howToOrderSections'));
    }

    public function create(): View
    {
        return view('admin.how-to-order.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable'],
            'steps' => ['nullable', 'array'],
            'steps.*.title' => ['nullable', 'string', 'max:255'],
            'steps.*.description' => ['nullable', 'string'],
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

        if ($isActive) {
            HowToOrderSection::where('is_active', true)->update([
                'is_active' => false,
                'updated_at' => now(),
            ]);
        }

        $section = HowToOrderSection::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'button_text' => $validated['button_text'] ?? null,
            'button_link' => $validated['button_link'] ?? null,
            'is_active' => $isActive,
        ]);

        if ($request->has('steps') && is_array($request->input('steps'))) {
            $order = 1;
            foreach ($request->input('steps') as $stepData) {
                $stepTitle = trim($stepData['title'] ?? '');
                $stepDesc = trim($stepData['description'] ?? '');

                if ($stepTitle !== '' || $stepDesc !== '') {
                    $section->steps()->create([
                        'title' => $stepTitle ?: 'Langkah '.$order,
                        'description' => $stepDesc,
                        'step_order' => $order,
                    ]);
                    $order++;
                }
            }
        }

        $message = $isActive ? 'Section Cara Pesan berhasil dipublikasikan.' : 'Section Cara Pesan berhasil disimpan sebagai draft.';

        return redirect()->route('admin.how-to-orders.index')->with('success', $message);
    }

    public function edit(HowToOrderSection $howToOrder): View
    {
        $howToOrder->load('steps');

        return view('admin.how-to-order.edit', compact('howToOrder'));
    }

    public function update(Request $request, HowToOrderSection $howToOrder): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable'],
            'steps' => ['nullable', 'array'],
            'steps.*.id' => ['nullable', 'integer'],
            'steps.*.title' => ['nullable', 'string', 'max:255'],
            'steps.*.description' => ['nullable', 'string'],
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
            HowToOrderSection::where('id', '!=', $howToOrder->id)
                ->where('is_active', true)
                ->update([
                    'is_active' => false,
                    'updated_at' => now(),
                ]);
        }

        $howToOrder->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'button_text' => $validated['button_text'] ?? null,
            'button_link' => $validated['button_link'] ?? null,
            'is_active' => $isActive,
        ]);

        $submittedSteps = $request->input('steps', []);
        $existingSteps = $howToOrder->steps()->get()->keyBy('id');
        $keptStepIds = [];

        if (is_array($submittedSteps)) {
            $order = 1;
            foreach ($submittedSteps as $stepData) {
                $stepId = ! empty($stepData['id']) ? (int) $stepData['id'] : null;
                $stepTitle = trim($stepData['title'] ?? '');
                $stepDesc = trim($stepData['description'] ?? '');

                if ($stepId && $existingSteps->has($stepId)) {
                    $step = $existingSteps->get($stepId);
                    $step->update([
                        'title' => $stepTitle ?: 'Langkah '.$order,
                        'description' => $stepDesc,
                        'step_order' => $order,
                    ]);
                    $keptStepIds[] = $stepId;
                    $order++;
                } elseif ($stepTitle !== '' || $stepDesc !== '') {
                    $newStep = $howToOrder->steps()->create([
                        'title' => $stepTitle ?: 'Langkah '.$order,
                        'description' => $stepDesc,
                        'step_order' => $order,
                    ]);
                    $keptStepIds[] = $newStep->id;
                    $order++;
                }
            }
        }

        foreach ($existingSteps as $existingId => $existingStep) {
            if (! in_array($existingId, $keptStepIds)) {
                $existingStep->delete();
            }
        }

        $howToOrder->touch();

        $message = $isActive ? 'Section Cara Pesan berhasil diperbarui.' : 'Section Cara Pesan berhasil disimpan sebagai draft.';

        return redirect()->route('admin.how-to-orders.index')->with('success', $message);
    }

    public function destroy(HowToOrderSection $howToOrder): RedirectResponse
    {
        $howToOrder->delete();

        return redirect()->route('admin.how-to-orders.index')->with('success', 'Section Cara Pesan berhasil dihapus.');
    }

    public function toggleStatus(HowToOrderSection $howToOrder): RedirectResponse
    {
        $newStatus = ! $howToOrder->is_active;

        if ($newStatus) {
            HowToOrderSection::where('id', '!=', $howToOrder->id)
                ->where('is_active', true)
                ->update([
                    'is_active' => false,
                    'updated_at' => now(),
                ]);
        }

        $howToOrder->update([
            'is_active' => $newStatus,
        ]);
        $howToOrder->touch();

        $message = $newStatus ? 'Section Cara Pesan berhasil diaktifkan.' : 'Section Cara Pesan berhasil dinonaktifkan.';

        return back()->with('success', $message);
    }
}
