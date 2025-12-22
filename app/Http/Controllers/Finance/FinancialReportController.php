<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\FinancialReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinancialReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = FinancialReport::query()->with('filiale', 'project');

        if ($user->hasRole('superadmin')) {
            $reports = $query->get();
        } elseif ($user->filiale_id) {
            $reports = $query->where('filiale_id', $user->filiale_id)->get();
        } else {
            $reports = collect();
        }

        return view('financial_reports.index', compact('reports'));
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'filiale_id' => 'nullable|exists:filiales,id',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        $query = FinancialReport::query();

        if ($request->filiale_id) {
            $query->where('filiale_id', $request->filiale_id);
        }
        if ($request->project_id) {
            $query->where('project_id', $request->project_id);
        }

        $query->whereBetween('date', [$request->start_date, $request->end_date]);

        $reportData = $query->get();

        return view('financial_reports.generate', compact('reportData'));
    }

    public function show(FinancialReport $financialReport)
    {
        return view('financial_reports.show', compact('financialReport'));
    }

    public function exportPDF(FinancialReport $financialReport)
    {
        $pdf = \PDF::loadView('financial_reports.pdf', compact('financialReport'));
        return $pdf->download('financial_report_'.$financialReport->id.'.pdf');
    }
}




