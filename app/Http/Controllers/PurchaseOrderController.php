<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use App\Models\Supplier;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    use FileUploadTrait;
    public function index(Request $request)
    {
        $query = PurchaseOrder::with(['supplier', 'purchaseRequest']);

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $orders = $query->latest()->paginate(20);
        
        $stats = [
            'total' => PurchaseOrder::count(),
            'envoyees' => PurchaseOrder::envoyee()->count(),
            'livrees' => PurchaseOrder::livree()->count(),
            'en_cours' => PurchaseOrder::whereIn('statut', ['confirmee', 'en_cours'])->count(),
        ];

        return view('purchase_orders.index', compact('orders', 'stats'));
    }

    public function create(Request $request)
    {
        $purchaseRequestId = $request->get('purchase_request_id');
        $purchaseRequest = $purchaseRequestId ? PurchaseRequest::find($purchaseRequestId) : null;
        $suppliers = Supplier::all();

        return view('purchase_orders.create', compact('suppliers', 'purchaseRequest'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'purchase_request_id' => 'nullable|exists:purchase_requests,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'date_commande' => 'required|date',
            'date_livraison_prevue' => 'nullable|date',
            'montant_ht' => 'required|numeric',
            'tva' => 'nullable|numeric',
            'mode_paiement' => 'required|in:comptant,virement,cheque,traite,autre',
            'conditions_livraison' => 'nullable|string',
        ]);

        $validated['numero'] = 'BC-' . date('Ymd') . '-' . str_pad(PurchaseOrder::count() + 1, 4, '0', STR_PAD_LEFT);
        $validated['montant_ttc'] = $validated['montant_ht'] + ($validated['tva'] ?? 0);
        $validated['created_by'] = auth()->id();
        $validated['statut'] = 'brouillon';

        // Upload attachments
        if ($request->hasFile('attachments')) {
            $validated['attachments'] = $this->uploadFiles($request->file('attachments'), 'operations/purchase-orders');
        }

        $order = PurchaseOrder::create($validated);

        return redirect()->route('purchase_orders.show', $order)->with('success', 'Bon de commande créé.');
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load(['receptions', 'supplier']);
        return view('purchase_orders.show', compact('purchaseOrder'));
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->delete();
        return redirect()->route('purchase_orders.index')->with('success', 'Bon de commande supprimé.');
    }

    public function downloadAttachment(PurchaseOrder $purchaseOrder, $index)
    {
        if (!isset($purchaseOrder->attachments[$index])) {
            abort(404);
        }
        return $this->downloadFile($purchaseOrder->attachments[$index]);
    }

    public function deleteAttachment(PurchaseOrder $purchaseOrder, $index)
    {
        if (!isset($purchaseOrder->attachments[$index])) {
            abort(404);
        }
        $purchaseOrder->attachments = $this->removeAttachment($purchaseOrder->attachments, $index);
        $purchaseOrder->save();
        return back()->with('success', 'Fichier supprimé avec succès.');
    }
}
