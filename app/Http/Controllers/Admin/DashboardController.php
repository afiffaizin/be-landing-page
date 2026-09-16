<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use App\Models\HomeSection;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard overview.
     */
    public function index(): View
    {
        $totalHome = HomeSection::count();
        $activeHome = HomeSection::where('is_active', true)->count();

        $totalAbout = AboutSection::count();
        $activeAbout = AboutSection::where('is_active', true)->count();

        $aboutSections = AboutSection::all();
        $totalPoints = $aboutSections->reduce(function ($carry, $item) {
            return $carry + (is_array($item->points) ? count($item->points) : 0);
        }, 0);

        $recentHome = HomeSection::latest()->take(3)->get();
        $recentAbout = AboutSection::latest()->take(3)->get();

        return view('admin.dashboard', compact(
            'totalHome',
            'activeHome',
            'totalAbout',
            'activeAbout',
            'totalPoints',
            'recentHome',
            'recentAbout'
        ));
    }
}
