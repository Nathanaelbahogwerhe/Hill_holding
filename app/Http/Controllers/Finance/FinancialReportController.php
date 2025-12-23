<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Expense;
use App\Models\Revenue;
use App\Models\Filiale;
use App\Models\Agence;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinancialReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Report::query()
            ->where('type', 'financier')
            ->with(['filiale', 'project']);

        if ($user->hasRole('superadmin')) {
            $reports = $query->latest()->get();
            $filiales = Filiale::orderBy('name')->get();
            $agences = Agence::orderBy('name')->get();
        } elseif ($user->filiale_id) {
            $reports = $query->where('filiale_id', $user->filiale_id)->latest()->get();
            $filiales = Filiale::where('id', $user->filiale_id)->get();
            $agences = Agence::where('filiale_id', $user->filiale_id)->get();
        } else {
            $reports = collect();
            $filiales = collect();
            $agences = collect();
        }

        $projects = Project::orderBy('name')->get();
        
        // Dates par défaut (mois en cours)
        $start_date = request('start_date', now()->startOfMonth()->format('Y-m-d'));
        $end_date = request('end_date', now()->endOfMonth()->format('Y-m-d'));

        return view('finance.reports.index', compact('reports', 'filiales', 'agences', 'projects', 'start_date', 'end_date'));
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'filiale_id' => 'nullable|exists:filiales,id',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        $user = Auth::user();

        // Récupérer les dépenses et recettes pour la période
        $expensesQuery = Expense::whereBetween('date', [$request->start_date, $request->end_date]);
        $revenuesQuery = Revenue::whereBetween('date', [$request->start_date, $request->end_date]);

        if ($request->filiale_id) {
            $expensesQuery->where('filiale_id', $request->filiale_id);
            $revenuesQuery->where('filiale_id', $request->filiale_id);
        }
        if ($request->project_id) {
            $expensesQuery->where('project_id', $request->project_id);
            $revenuesQuery->where('project_id', $request->project_id);
        }

        $expenses = $expensesQuery->get();
        $revenues = $revenuesQuery->get();

        $totalExpenses = $expenses->sum('montant');
        $totalRevenues = $revenues->sum('montant');
        $balance = $totalRevenues - $totalExpenses;

        return view('finance.reports.index', compact(
            'expenses',
            'revenues',
            'totalExpenses',
            'totalRevenues',
            'balance'
        ));
    }

    public function show(Report $report)
    {
        return view('finance.reports.show', compact('report'));
    }
}




