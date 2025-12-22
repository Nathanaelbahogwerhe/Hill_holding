<?php

namespace App\Http\Controllers;

use App\Models\Reception;
use App\Models\PurchaseOrder;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class ReceptionController extends Controller
{
    use FileUploadTrait;
    public function index()
    {
        $receptions = Reception::with(['purchaseOrder'])->latest()->paginate(20);
        
        $stats = [
            'total' => Reception::count(),
            'conformes' => Reception::conforme()->count(),
            'avec_reserves' => Reception::avecReserves()->count(),
            'ce_mois' => Reception::whereMonth('date_reception', now()->month)->count(),
        ];

        return view('receptions.index', compact('receptions', 'stats'));
    }

    public function create(Request $request)
    {
        $purchaseOrderId = $request->get('purchase_order_id');
        $purchaseOrder = $purchaseOrderId ? PurchaseOrder::find($purchaseOrderId) : null;
        $orders = PurchaseOrder::whereIn('statut', ['envoyee', 'confirmee', 'en_cours'])->get();

        return view('receptions.create', compact('orders', 'purchaseOrder'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'date_reception' => 'required|date',
            'receptionnaire' => 'required|string',
            'statut' => 'required|in:partielle,complete,avec_reserves',
            'articles_recus' => 'required|string',
            'reserves' => 'nullable|string',
            'conforme' => 'boolean',
            'non_conformites' => 'nullable|string',
        ]);

        $validated['numero'] = 'REC-' . date('Ymd') . '-' . str_pad(Reception::count() + 1, 4, '0', STR_PAD_LEFT);
        $validated['created_by'] = auth()->id();

        // Upload attachments
        if ($request->hasFile('attachments')) {
            $validated['attachments'] = $this->uploadFiles($request->file('attachments'), 'operations/receptions');
        }

        $reception = Reception::create($validated);

        return redirect()->route('receptions.show', $reception)->with('success', 'Réception enregistrée.');
    }

    public function show(Reception $reception)
    {
        $reception->load(['purchaseOrder']);
        return view('receptions.show', compact('reception'));
    }

    public function destroy(Reception $reception)
    {
        $reception->delete();
        return redirect()->route('receptions.index')->with('success', 'Réception supprimée.');
    }

    public function downloadAttachment(Reception $reception, $index)
    {
        if (!isset($reception->attachments[$index])) {
            abort(404);
        }
        return $this->downloadFile($reception->attachments[$index]);
    }

    public function deleteAttachment(Reception $reception, $index)
    {
        if (!isset($reception->attachments[$index])) {
            abort(404);
        }
        $reception->attachments = $this->removeAttachment($reception->attachments, $index);
        $reception->save();
        return back()->with('success', 'Fichier supprimé avec succès.');
    }
}
