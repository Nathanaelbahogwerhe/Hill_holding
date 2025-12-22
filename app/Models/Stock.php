<?php

namespace App\Models;

use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory, FileUploadTrait;

    protected $fillable = [
        'date',
        'articles',
        'quantite',
        'prix_unitaire',
        'prix_total',
        'entree',
        'sortie',
        'destination',
        'solde',
        'fournisseur',
        'filiale_id',
        'agence_id',
    ];

    protected $casts = [
        'date' => 'date',
        'quantite' => 'decimal:2',
        'prix_unitaire' => 'decimal:2',
        'prix_total' => 'decimal:2',
        'entree' => 'decimal:2',
        'sortie' => 'decimal:2',
        'solde' => 'decimal:2',
    ];

    /**
     * Relation vers la filiale
     */
    public function filiale()
    {
        return $this->belongsTo(Filiale::class);
    }

    /**
     * Relation vers l'agence
     */
    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    /**
     * Calculer le prix total automatiquement
     */
    public function calculatePrixTotal()
    {
        $this->prix_total = $this->quantite * $this->prix_unitaire;
        return $this->prix_total;
    }

    /**
     * Calculer le solde après un mouvement
     */
    public static function calculateSolde($article, $filiale_id = null, $agence_id = null)
    {
        $query = self::where('articles', $article);
        
        if ($filiale_id) {
            $query->where('filiale_id', $filiale_id);
        }
        
        if ($agence_id) {
            $query->where('agence_id', $agence_id);
        }

        $totalEntree = $query->sum('entree');
        $totalSortie = $query->sum('sortie');

        return $totalEntree - $totalSortie;
    }

    /**
     * Scope pour les entrées de stock
     */
    public function scopeEntrees($query)
    {
        return $query->where('entree', '>', 0);
    }

    /**
     * Scope pour les sorties de stock
     */
    public function scopeSorties($query)
    {
        return $query->where('sortie', '>', 0);
    }

    /**
     * Scope pour filtrer par article
     */
    public function scopeByArticle($query, $article)
    {
        return $query->where('articles', 'like', '%' . $article . '%');
    }

    /**
     * Scope pour filtrer par fournisseur
     */
    public function scopeByFournisseur($query, $fournisseur)
    {
        return $query->where('fournisseur', 'like', '%' . $fournisseur . '%');
    }
}
