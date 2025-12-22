<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Filiale;
use App\Models\Agence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Liste des mouvements de stock
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $query = Stock::with(['filiale', 'agence']);

        // Filtrage hiérarchique
        if ($user->hasRole('superadmin')) {
            // Super Admin voit tout
        } elseif ($user->filiale_id && !$user->agence_id) {
            // Filiale voit sa filiale et ses agences
            $query->where('filiale_id', $user->filiale_id);
        } elseif ($user->agence_id) {
            // Agence voit uniquement son agence
            $query->where('agence_id', $user->agence_id);
        }

        // Filtres de recherche
        if ($request->filled('article')) {
            $query->byArticle($request->article);
        }

        if ($request->filled('fournisseur')) {
            $query->byFournisseur($request->fournisseur);
        }

        if ($request->filled('type')) {
            if ($request->type === 'entree') {
                $query->entrees();
            } elseif ($request->type === 'sortie') {
                $query->sorties();
            }
        }

        if ($request->filled('date_debut')) {
            $query->where('date', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->where('date', '<=', $request->date_fin);
        }

        $stocks = $query->latest('date')->paginate(20);

        // Statistiques
        $stats = [
            'total_entrees' => Stock::entrees()->sum('entree'),
            'total_sorties' => Stock::sorties()->sum('sortie'),
            'valeur_stock' => Stock::sum('prix_total'),
        ];

        $filiales = Filiale::all();
        $agences = Agence::all();

        return view('stocks.index', compact('stocks', 'stats', 'filiales', 'agences'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        $user = auth()->user();

        $filiales = Filiale::all();
        
        if ($user->filiale_id) {
            $agences = Agence::where('filiale_id', $user->filiale_id)->get();
        } else {
            $agences = Agence::all();
        }

        return view('stocks.create', compact('filiales', 'agences'));
    }

    /**
     * Enregistrer un nouveau mouvement
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'articles' => 'required|string|max:255',
            'quantite' => 'required|numeric|min:0',
            'prix_unitaire' => 'required|numeric|min:0',
            'entree' => 'nullable|numeric|min:0',
            'sortie' => 'nullable|numeric|min:0',
            'destination' => 'nullable|string|max:255',
            'fournisseur' => 'nullable|string|max:255',
            'filiale_id' => 'nullable|exists:filiales,id',
            'agence_id' => 'nullable|exists:agences,id',
        ]);

        // Calculer le prix total
        $validated['prix_total'] = $validated['quantite'] * $validated['prix_unitaire'];

        // S'assurer qu'une seule des deux valeurs (entrée ou sortie) est renseignée
        if (!empty($validated['entree']) && !empty($validated['sortie'])) {
            return back()->withErrors(['error' => 'Un mouvement ne peut être à la fois une entrée et une sortie.'])->withInput();
        }

        // Définir entrée ou sortie basée sur quantité
        if (empty($validated['entree']) && empty($validated['sortie'])) {
            $validated['entree'] = $validated['quantite'];
        }

        // Calculer le nouveau solde
        $validated['solde'] = Stock::calculateSolde(
            $validated['articles'],
            $validated['filiale_id'] ?? null,
            $validated['agence_id'] ?? null
        );

        // Ajouter le mouvement actuel
        if (!empty($validated['entree'])) {
            $validated['solde'] += $validated['entree'];
        }
        if (!empty($validated['sortie'])) {
            $validated['solde'] -= $validated['sortie'];
        }

        Stock::create($validated);

        return redirect()->route('stocks.index')
            ->with('success', 'Mouvement de stock enregistré avec succès.');
    }

    /**
     * Afficher un mouvement
     */
    public function show(Stock $stock)
    {
        $this->authorizeAccess($stock);
        
        return view('stocks.show', compact('stock'));
    }

    /**
     * Formulaire d'édition
     */
    public function edit(Stock $stock)
    {
        $this->authorizeAccess($stock);

        $user = auth()->user();
        $filiales = Filiale::all();
        
        if ($user->filiale_id) {
            $agences = Agence::where('filiale_id', $user->filiale_id)->get();
        } else {
            $agences = Agence::all();
        }

        return view('stocks.edit', compact('stock', 'filiales', 'agences'));
    }

    /**
     * Mettre à jour un mouvement
     */
    public function update(Request $request, Stock $stock)
    {
        $this->authorizeAccess($stock);

        $validated = $request->validate([
            'date' => 'required|date',
            'articles' => 'required|string|max:255',
            'quantite' => 'required|numeric|min:0',
            'prix_unitaire' => 'required|numeric|min:0',
            'entree' => 'nullable|numeric|min:0',
            'sortie' => 'nullable|numeric|min:0',
            'destination' => 'nullable|string|max:255',
            'fournisseur' => 'nullable|string|max:255',
            'filiale_id' => 'nullable|exists:filiales,id',
            'agence_id' => 'nullable|exists:agences,id',
        ]);

        // Calculer le prix total
        $validated['prix_total'] = $validated['quantite'] * $validated['prix_unitaire'];

        // Recalculer le solde
        $validated['solde'] = Stock::calculateSolde(
            $validated['articles'],
            $validated['filiale_id'] ?? null,
            $validated['agence_id'] ?? null
        );

        if (!empty($validated['entree'])) {
            $validated['solde'] += $validated['entree'];
        }
        if (!empty($validated['sortie'])) {
            $validated['solde'] -= $validated['sortie'];
        }

        $stock->update($validated);

        return redirect()->route('stocks.index')
            ->with('success', 'Mouvement mis à jour avec succès.');
    }

    /**
     * Supprimer un mouvement
     */
    public function destroy(Stock $stock)
    {
        $this->authorizeAccess($stock);

        $stock->delete();

        return redirect()->route('stocks.index')
            ->with('success', 'Mouvement supprimé avec succès.');
    }

    /**
     * Rapport de stock par article
     */
    public function rapport()
    {
        $user = auth()->user();

        $query = Stock::select(
            'articles',
            DB::raw('SUM(entree) as total_entrees'),
            DB::raw('SUM(sortie) as total_sorties'),
            DB::raw('SUM(entree) - SUM(sortie) as stock_actuel'),
            DB::raw('AVG(prix_unitaire) as prix_moyen'),
            DB::raw('MAX(date) as derniere_activite')
        )
        ->groupBy('articles');

        // Filtrage hiérarchique
        if ($user->hasRole('superadmin')) {
            // Voir tout
        } elseif ($user->filiale_id && !$user->agence_id) {
            $query->where('filiale_id', $user->filiale_id);
        } elseif ($user->agence_id) {
            $query->where('agence_id', $user->agence_id);
        }

        $articles = $query->havingRaw('SUM(entree) - SUM(sortie) > 0')->get();

        return view('stocks.rapport', compact('articles'));
    }

    /**
     * Vérifier les permissions d'accès
     */
    protected function authorizeAccess($stock)
    {
        $user = auth()->user();

        if ($user->hasRole('superadmin')) {
            return true;
        }

        if ($user->filiale_id && $stock->filiale_id !== $user->filiale_id) {
            abort(403, 'Accès non autorisé.');
        }

        if ($user->agence_id && $stock->agence_id !== $user->agence_id) {
            abort(403, 'Accès non autorisé.');
        }

        return true;
    }
}




