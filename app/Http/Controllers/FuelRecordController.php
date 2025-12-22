<?php

namespace App\Http\Controllers;

use App\Models\FuelRecord;
use App\Models\Vehicle;
use App\Models\Mission;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class FuelRecordController extends Controller
{
    use FileUploadTrait;
    public function index(Request $request)
    {
        $query = FuelRecord::with(['vehicle', 'mission', 'effectuePar']);

        if ($request->filled('vehicle_id')) {
            $query->where('vehicle_id', $request->vehicle_id);
        }

        $records = $query->latest('date_heure')->paginate(20);
        
        $stats = [
            'total' => FuelRecord::count(),
            'ce_mois' => FuelRecord::thisMonth()->count(),
            'valides' => FuelRecord::valide()->count(),
            'total_litres' => FuelRecord::thisMonth()->sum('quantite_litres'),
        ];

        $vehicles = Vehicle::all();

        return view('fuel_records.index', compact('records', 'stats', 'vehicles'));
    }

    public function create(Request $request)
    {
        $vehicles = Vehicle::all();
        $missions = Mission::enCours()->get();
        $vehicleId = $request->get('vehicle_id');

        return view('fuel_records.create', compact('vehicles', 'missions', 'vehicleId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'mission_id' => 'nullable|exists:missions,id',
            'date_heure' => 'required|date',
            'type_carburant' => 'required|in:essence,diesel,gaz,electrique,hybride',
            'quantite_litres' => 'required|numeric|min:0',
            'prix_unitaire' => 'required|numeric|min:0',
            'kilometrage' => 'required|integer|min:0',
            'station_service' => 'nullable|string',
            'mode_paiement' => 'required|in:carte_entreprise,especes,bon_carburant,autre',
        ]);

        $validated['montant_total'] = $validated['quantite_litres'] * $validated['prix_unitaire'];
        $validated['effectue_par'] = auth()->id();
        $validated['valide'] = false;

        // Upload attachments
        if ($request->hasFile('attachments')) {
            $validated['attachments'] = $this->uploadFiles($request->file('attachments'), 'operations/fuel-records');
        }

        $record = FuelRecord::create($validated);

        return redirect()->route('fuel_records.show', $record)->with('success', 'Plein enregistré.');
    }

    public function show(FuelRecord $fuelRecord)
    {
        $fuelRecord->load(['vehicle', 'mission']);
        return view('fuel_records.show', compact('fuelRecord'));
    }

    public function destroy(FuelRecord $fuelRecord)
    {
        $fuelRecord->delete();
        return redirect()->route('fuel_records.index')->with('success', 'Enregistrement supprimé.');
    }

    public function downloadAttachment(FuelRecord $fuelRecord, $index)
    {
        if (!isset($fuelRecord->attachments[$index])) {
            abort(404);
        }
        return $this->downloadFile($fuelRecord->attachments[$index]);
    }

    public function deleteAttachment(FuelRecord $fuelRecord, $index)
    {
        if (!isset($fuelRecord->attachments[$index])) {
            abort(404);
        }
        $fuelRecord->attachments = $this->removeAttachment($fuelRecord->attachments, $index);
        $fuelRecord->save();
        return back()->with('success', 'Fichier supprimé avec succès.');
    }
}
