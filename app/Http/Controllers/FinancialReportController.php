<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Expense;
use App\Models\Revenue;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\Filiale;
use App\Models\Agence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinancialReportController extends Controller
{
    /**
     * 📊 Rapport financier global selon le périmètre utilisateur
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Récupérer les filtres
        $filiale_id = $request->input('filiale_id');
        $agence_id = $request->input('agence_id');
        $start_date = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $end_date = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Déterminer le périmètre selon les droits
        if ($user->hasRole('Super Admin')) {
            // Maison Mère: accès à tout
            $budgets = Budget::with(['filiale', 'agence']);
            $expenses = Expense::with(['filiale', 'agence']);
            $revenues = Revenue::with(['filiale', 'agence']);
            $invoices = Invoice::with(['client', 'agence']);
            $transactions = Transaction::query();
            
            $filiales = Filiale::all();
            $agences = Agence::all();
        } elseif ($user->filiale_id && !$user->agence_id) {
            // Filiale: sa filiale et ses agences
            $budgets = Budget::where('filiale_id', $user->filiale_id)->with(['filiale', 'agence']);
            $expenses = Expense::where('filiale_id', $user->filiale_id)->with(['filiale', 'agence']);
            $revenues = Revenue::where('filiale_id', $user->filiale_id)->with(['filiale', 'agence']);
            $invoices = Invoice::whereHas('agence', function($q) use ($user) {
                $q->where('filiale_id', $user->filiale_id);
            })->with(['client', 'agence']);
            $transactions = Transaction::where('user_id', $user->id);
            
            $filiales = Filiale::where('id', $user->filiale_id)->get();
            $agences = Agence::where('filiale_id', $user->filiale_id)->get();
        } elseif ($user->agence_id) {
            // Agence: uniquement son agence
            $budgets = Budget::where('agence_id', $user->agence_id)->with(['filiale', 'agence']);
            $expenses = Expense::where('agence_id', $user->agence_id)->with(['filiale', 'agence']);
            $revenues = Revenue::where('agence_id', $user->agence_id)->with(['filiale', 'agence']);
            $invoices = Invoice::where('agency_id', $user->agence_id)->with(['client', 'agence']);
            $transactions = Transaction::where('user_id', $user->id);
            
            $filiales = collect();
            $agences = Agence::where('id', $user->agence_id)->get();
        } else {
            // Pas d'accès
            return view('finance.reports.index', [
                'totalBudget' => 0,
                'totalExpenses' => 0,
                'totalRevenues' => 0,
                'totalInvoices' => 0,
                'balance' => 0,
                'budgets' => collect(),
                'expenses' => collect(),
                'revenues' => collect(),
                'invoices' => collect(),
                'transactions' => collect(),
                'filiales' => collect(),
                'agences' => collect(),
                'selectedFiliale' => null,
                'selectedAgence' => null,
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]);
        }

        // Appliquer les filtres supplémentaires
        if ($filiale_id) {
            $budgets = $budgets->where('filiale_id', $filiale_id);
            $expenses = $expenses->where('filiale_id', $filiale_id);
            $revenues = $revenues->where('filiale_id', $filiale_id);
        }

        if ($agence_id) {
            $budgets = $budgets->where('agence_id', $agence_id);
            $expenses = $expenses->where('agence_id', $agence_id);
            $revenues = $revenues->where('agence_id', $agence_id);
            $invoices = $invoices->where('agency_id', $agence_id);
        }

        // Filtres de dates
        $budgets = $budgets->whereBetween('start_date', [$start_date, $end_date]);
        $expenses = $expenses->whereBetween('date', [$start_date, $end_date]);
        $revenues = $revenues->whereBetween('date', [$start_date, $end_date]);
        $invoices = $invoices->whereBetween('invoice_date', [$start_date, $end_date]);
        $transactions = $transactions->whereBetween('transaction_date', [$start_date, $end_date]);

        // Récupérer les données
        $budgetsData = $budgets->get();
        $expensesData = $expenses->get();
        $revenuesData = $revenues->get();
        $invoicesData = $invoices->get();
        $transactionsData = $transactions->get();

        // Calculs
        $totalBudget = $budgetsData->sum('amount');
        $totalBudgetUsed = $budgetsData->sum('amount_used');
        $budgetPercentageUsed = $totalBudget > 0 ? ($totalBudgetUsed / $totalBudget * 100) : 0;
        
        $totalExpenses = $expensesData->sum('amount');
        $totalRevenues = $revenuesData->sum('amount');
        $totalInvoices = $invoicesData->where('status', 'paid')->sum('amount');
        $balance = $totalRevenues + $totalInvoices - $totalExpenses;

        // Statistiques des budgets
        $budgetStats = [
            'total' => $totalBudget,
            'used' => $totalBudgetUsed,
            'remaining' => $totalBudget - $totalBudgetUsed,
            'percentage' => $budgetPercentageUsed,
            'status' => $budgetPercentageUsed >= 100 ? 'exceeded' : 
                       ($budgetPercentageUsed >= 80 ? 'warning' : 'normal'),
            'overBudget' => $budgetsData->filter(fn($b) => $b->isOverBudget())->count(),
            'nearLimit' => $budgetsData->filter(fn($b) => $b->isNearLimit())->count(),
        ];

        // Statistiques par filiale
        $statsByFiliale = [];
        if ($user->hasRole('Super Admin')) {
            foreach ($filiales as $filiale) {
                $filialeBudgets = $budgetsData->where('filiale_id', $filiale->id);
                $statsByFiliale[$filiale->id] = [
                    'name' => $filiale->name,
                    'budgets' => $filialeBudgets->sum('amount'),
                    'budgets_used' => $filialeBudgets->sum('amount_used'),
                    'expenses' => $expensesData->where('filiale_id', $filiale->id)->sum('amount'),
                    'revenues' => $revenuesData->where('filiale_id', $filiale->id)->sum('amount'),
                    'balance' => $revenuesData->where('filiale_id', $filiale->id)->sum('amount') - 
                                 $expensesData->where('filiale_id', $filiale->id)->sum('amount'),
                ];
            }
        }

        // Statistiques par agence
        $statsByAgence = [];
        foreach ($agences as $agence) {
            $agenceBudgets = $budgetsData->where('agence_id', $agence->id);
            $statsByAgence[$agence->id] = [
                'name' => $agence->name,
                'filiale' => $agence->filiale->name ?? 'N/A',
                'budgets' => $agenceBudgets->sum('amount'),
                'budgets_used' => $agenceBudgets->sum('amount_used'),
                'expenses' => $expensesData->where('agence_id', $agence->id)->sum('amount'),
                'revenues' => $revenuesData->where('agence_id', $agence->id)->sum('amount'),
                'balance' => $revenuesData->where('agence_id', $agence->id)->sum('amount') - 
                             $expensesData->where('agence_id', $agence->id)->sum('amount'),
            ];
        }

        return view('finance.reports.index', compact(
            'totalBudget',
            'totalBudgetUsed',
            'budgetPercentageUsed',
            'budgetStats',
            'totalExpenses',
            'totalRevenues',
            'totalInvoices',
            'balance',
            'budgetsData',
            'expensesData',
            'revenuesData',
            'invoicesData',
            'transactionsData',
            'filiales',
            'agences',
            'statsByFiliale',
            'statsByAgence',
            'start_date',
            'end_date'
        ));
    }

    /**
     * 📥 Export du rapport en PDF/Excel
     */
    public function export(Request $request)
    {
        // TODO: Implémenter l'export
        return back()->with('info', 'Export en cours de développement');
    }
}
