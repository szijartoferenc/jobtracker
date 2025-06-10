<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Models\Application;
use App\Models\ApplicationStatusChange;
use App\Models\ApplicationNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->applications()->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('company', 'like', '%' . $request->search . '%')
                  ->orWhere('position', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('redflag')) {
            $query->where('redflag', $request->redflag == '1');
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('applied_at', [$request->from, $request->to]);
        }

        $applications = $query->paginate(10);
        $statuses = ['pályázott', 'első kapcsolat', 'interjú', 'visszautasítva', 'elfogadva'];

        return view('applications.index', compact('applications', 'statuses'));
    }

    public function create()
    {
        return view('applications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'applied_at' => 'nullable|date',
            'status' => ['required', 'string', Rule::in(Application::$statuses)],
            'notes' => 'nullable|string',
            'redflag' => 'nullable|boolean',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $application = new Application($validated);
        $application->user_id = Auth::id();
        $application->redflag = $request->boolean('redflag', false);

        if ($request->hasFile('cv')) {
            $application->cv_path = $request->file('cv')->store('uploads', 'public');
        }

        if ($request->hasFile('cover_letter')) {
            $application->cover_letter_path = $request->file('cover_letter')->store('uploads', 'public');
        }

        $application->save();

        return redirect()->route('applications.index')->with('success', 'Jelentkezés rögzítve.');
    }

    public function edit(Application $application)
    {
        $this->authorize('update', $application);
        return view('applications.edit', compact('application'));
    }

    public function update(Request $request, Application $application)
    {
        $this->authorize('update', $application);

        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'applied_at' => 'nullable|date',
            'status' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'redflag' => 'nullable|boolean',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $application->fill($validated);
        $application->redflag = $request->boolean('redflag', false);

        if ($request->hasFile('cv')) {
            if ($application->cv_path) {
                Storage::disk('public')->delete($application->cv_path);
            }
            $application->cv_path = $request->file('cv')->store('uploads', 'public');
        }

        if ($request->hasFile('cover_letter')) {
            if ($application->cover_letter_path) {
                Storage::disk('public')->delete($application->cover_letter_path);
            }
            $application->cover_letter_path = $request->file('cover_letter')->store('uploads', 'public');
        }

        $application->save();

        return redirect()->route('applications.index')->with('success', 'Jelentkezés frissítve.');
    }

    public function destroy(Application $application)
    {
        $this->authorize('delete', $application);

        if ($application->cv_path) {
            Storage::disk('public')->delete($application->cv_path);
        }
        if ($application->cover_letter_path) {
            Storage::disk('public')->delete($application->cover_letter_path);
        }

        $application->delete();

        return redirect()->route('applications.index')->with('success', 'Jelentkezés törölve.');
    }

    public function exportCsv(): StreamedResponse
    {
        $filename = 'jelentkezesek.csv';

        $applications = auth()->user()->applications()->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $columns = ['Cég', 'Pozíció', 'Dátum', 'Státusz', 'Redflag', 'Jegyzet'];

        $callback = function () use ($applications, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($applications as $app) {
                fputcsv($file, [
                    $app->company,
                    $app->position,
                    $app->applied_at,
                    $app->status,
                    $app->redflag ? 'Igen' : 'Nem',
                    $app->notes
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf()
    {
        $applications = auth()->user()->applications()->get();

        $pdf = Pdf::loadView('applications.export_pdf', compact('applications'));
        return $pdf->download('jelentkezesek.pdf');
    }

    public function stats()
    {
        $userId = auth()->id();

        $count = Application::where('user_id', $userId)->count();

        $redflagged = Application::where('user_id', $userId)
            ->where('redflag', true)
            ->count();

        $nonRedflagged = Application::where('user_id', $userId)
            ->where('redflag', false)
            ->count();

        $statuses = Application::where('user_id', $userId)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $topCompanies = Application::where('user_id', $userId)
            ->select('company', DB::raw('count(*) as total'))
            ->groupBy('company')
            ->orderByDesc('total')
            ->limit(3)
            ->pluck('total', 'company');

        $monthlyApplications = Application::where('user_id', $userId)
            ->select(DB::raw('DATE_FORMAT(applied_at, "%Y-%m") as month'), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $companyCount = Application::where('user_id', $userId)
            ->distinct('company')
            ->count('company');

        $lastApplicationDate = Application::where('user_id', $userId)
            ->latest('applied_at')
            ->value('applied_at');

        $redflaggedCompanies = Application::where('user_id', $userId)
            ->where('redflag', true)
            ->pluck('company')
            ->unique()
            ->values();

        return view('applications.stats', compact(
            'count',
            'redflagged',
            'nonRedflagged',
            'statuses',
            'topCompanies',
            'monthlyApplications',
            'companyCount',
            'lastApplicationDate',
            'redflaggedCompanies'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $application = auth()->user()->applications()->findOrFail($id);

        $oldStatus = $application->status;
        $newStatus = $request->input('status');

        if ($oldStatus !== $newStatus) {
            $application->status = $newStatus;
            $application->save();

            ApplicationStatusChange::create([
                'application_id' => $application->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'changed_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Státusz frissítve.');
    }

    public function addNote(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string|max:2000',
        ]);

        $application = auth()->user()->applications()->findOrFail($id);

        ApplicationNote::create([
            'application_id' => $application->id,
            'note' => $request->input('note'),
            'noted_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Jegyzet hozzáadva.');
    }

    public function show($id)
    {
        $application = auth()->user()->applications()
            ->with([
                'applicationNotes' => function ($q) {
                    $q->orderBy('noted_at', 'desc');
                },
                'statusChanges' => function ($q) {
                    $q->orderBy('changed_at', 'desc');
                }
            ])
            ->findOrFail($id);

        return view('applications.show', compact('application'));
    }
}
