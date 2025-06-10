<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index()
    {
        $applicationsCount = Application::count();

        // Redflag cégek (cégnév lista, egyedi cégek)
        $redflaggedCompanies = Application::where('redflag', true)
            ->distinct('company')
            ->pluck('company');

        // Legfrissebb jelentkezések (pl. 10 legfrissebb)
        $latestApplications = Application::orderBy('applied_at', 'desc')
            ->take(10)
            ->get();

        return view('dashboard', [
            'totalApplications' => $applicationsCount,
            'redflaggedCompanies' => $redflaggedCompanies,
            'latestApplications' => $latestApplications,
        ]);
    }
}
