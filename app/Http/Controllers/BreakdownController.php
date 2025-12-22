<?php

namespace App\Http\Controllers;

use App\Models\Breakdown;
use App\Models\Equipment;
use App\Models\User;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class BreakdownController extends Controller
{
    use FileUploadTrait;
    public function index(Request $request)
    {
        $query = Breakdown::with(['equipment', 'declarant', 'technicien']);

        if ($request->filled('severite')) {
            $query->where('severite', $request->severite);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $breakdowns = $query->latest('date_panne')->paginate(20);
        
        $stats = [
            'total' => Breakdown::count(),
            'non_resolues' => Breakdown::nonResolue()->count(),
            'critiques' => Breakdown::critique()->count(),
            'ce_mois' => Breakdown::whereMonth('date_panne', now()->month)->count(),
        ];

        return view('breakdowns.index', compact('breakdowns', 'stats'));
    }

    public function create(Request $request)
    {
        $equipmentId = $request->get('equipment_id');
        $equipment = $equipmentId ? Equipment::find($equipmentId) : null;
        $allEquipment = Equipment::all();

        return view('breakdowns.create', compact('allEquipment', 'equipment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'titre' => 'required|string',
            'description' => 'required|string',
            'severite' => 'required|in:mineure,moderee,majeure,critique',
            'impacte_production' => 'boolean',
            'symptomes' => 'nullable|string',
        ]);

        $validated['numero'] = 'PANNE-' . date('Ymd') . '-' . str_pad(Breakdown::count() + 1, 4, '0', STR_PAD_LEFT);
        $validated['date_panne'] = now();
        $validated['statut'] = 'declaree';
        $validated['declarant_id'] = auth()->id();

        // Upload attachments
        if ($request->hasFile('attachments')) {
            $validated['attachments'] = $this->uploadFiles($request->file('attachments'), 'operations/breakdowns');
        }

        $breakdown = Breakdown::create($validated);

        return redirect()->route('breakdowns.show', $breakdown)->with('success', 'Panne déclarée.');
    }

    public function show(Breakdown $breakdown)
    {
        $breakdown->load(['equipment', 'declarant', 'technicien']);
        $techniciens = User::all();
        return view('breakdowns.show', compact('breakdown', 'techniciens'));
    }

    public function destroy(Breakdown $breakdown)
    {
        $breakdown->delete();
        return redirect()->route('breakdowns.index')->with('success', 'Panne supprimée.');
    }

    public function downloadAttachment(Breakdown $breakdown, $index)
    {
        if (!isset($breakdown->attachments[$index])) {
            abort(404);
        }
        return $this->downloadFile($breakdown->attachments[$index]);
    }

    public function deleteAttachment(Breakdown $breakdown, $index)
    {
        if (!isset($breakdown->attachments[$index])) {
            abort(404);
        }
        $breakdown->attachments = $this->removeAttachment($breakdown->attachments, $index);
        $breakdown->save();
        return back()->with('success', 'Fichier supprimé avec succès.');
    }
}
