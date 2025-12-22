@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">Demande d'Achat {{ $purchaseRequest->numero }}</h1>
            <p class="text-gray-600">Créée le {{ $purchaseRequest->created_at->format('d/m/Y à H:i') }}</p>
        </div>
        <div class="flex gap-2">
            @if($purchaseRequest->statut === 'soumise')
                <button onclick="document.getElementById('approveModal').classList.remove('hidden')" class="btn-primary bg-green-600 hover:bg-green-700">
                    <i class="fas fa-check mr-2"></i>Approuver
                </button>
                <button onclick="document.getElementById('rejectModal').classList.remove('hidden')" class="btn-secondary bg-red-600 text-white hover:bg-red-700">
                    <i class="fas fa-times mr-2"></i>Rejeter
                </button>
            @endif
            <a href="{{ route('purchase_requests.index') }}" class="btn-secondary">Retour</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Colonne principale --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Informations générales --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Informations Générales</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Filiale</p>
                        <p class="font-medium">{{ $purchaseRequest->filiale->nom }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Service</p>
                        <p class="font-medium">{{ $purchaseRequest->service->nom }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Demandeur</p>
                        <p class="font-medium">{{ $purchaseRequest->demandeur->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Date de Nécessité</p>
                        <p class="font-medium">{{ $purchaseRequest->date_necessite->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Priorité</p>
                        <span class="px-2 py-1 text-xs rounded {{ $purchaseRequest->priorite_color }}">
                            {{ ucfirst($purchaseRequest->priorite) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Montant Estimé</p>
                        <p class="font-bold text-lg">{{ number_format($purchaseRequest->montant_estime, 0, ',', ' ') }} FCFA</p>
                    </div>
                    @if($purchaseRequest->categorie)
                    <div>
                        <p class="text-sm text-gray-600">Catégorie</p>
                        <p class="font-medium">{{ $purchaseRequest->categorie }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Détails --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Détails de la Demande</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Objet</p>
                        <p class="mt-1">{{ $purchaseRequest->objet }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Description</p>
                        <p class="mt-1 whitespace-pre-line">{{ $purchaseRequest->description }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Justification</p>
                        <p class="mt-1 whitespace-pre-line">{{ $purchaseRequest->justification }}</p>
                    </div>
                    @if($purchaseRequest->remarques)
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Remarques</p>
                        <p class="mt-1 whitespace-pre-line">{{ $purchaseRequest->remarques }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Pièces jointes --}}
            @if($purchaseRequest->attachments && count($purchaseRequest->attachments) > 0)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Pièces Jointes</h2>
                <ul class="space-y-2">
                    @foreach($purchaseRequest->attachments as $attachment)
                    <li>
                        <a href="{{ Storage::url($attachment) }}" target="_blank" class="text-blue-600 hover:underline flex items-center">
                            <i class="fas fa-file mr-2"></i>
                            {{ basename($attachment) }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>

        {{-- Colonne latérale --}}
        <div class="space-y-6">
            {{-- Statut --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Statut</h2>
                <div class="text-center">
                    <span class="inline-block px-4 py-2 text-sm font-semibold rounded 
                        @if($purchaseRequest->statut === 'brouillon') bg-gray-100 text-gray-800
                        @elseif($purchaseRequest->statut === 'soumise') bg-blue-100 text-blue-800
                        @elseif($purchaseRequest->statut === 'approuvee') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ strtoupper($purchaseRequest->statut) }}
                    </span>
                </div>

                @if($purchaseRequest->statut === 'approuvee')
                <div class="mt-4 pt-4 border-t">
                    <p class="text-sm text-gray-600">Approuvée par</p>
                    <p class="font-medium">{{ $purchaseRequest->approbateur->name }}</p>
                    <p class="text-xs text-gray-500">{{ $purchaseRequest->date_approbation->format('d/m/Y à H:i') }}</p>
                    @if($purchaseRequest->commentaire_approbation)
                    <p class="text-sm mt-2">{{ $purchaseRequest->commentaire_approbation }}</p>
                    @endif
                </div>
                @elseif($purchaseRequest->statut === 'rejetee')
                <div class="mt-4 pt-4 border-t">
                    <p class="text-sm text-gray-600">Rejetée par</p>
                    <p class="font-medium">{{ $purchaseRequest->approbateur->name }}</p>
                    <p class="text-xs text-gray-500">{{ $purchaseRequest->date_approbation->format('d/m/Y à H:i') }}</p>
                    @if($purchaseRequest->commentaire_approbation)
                    <p class="text-sm mt-2 text-red-600">{{ $purchaseRequest->commentaire_approbation }}</p>
                    @endif
                </div>
                @endif
            </div>

            {{-- Actions rapides --}}
            @if($purchaseRequest->statut === 'approuvee')
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Actions</h2>
                <a href="{{ route('purchase_orders.create', ['request_id' => $purchaseRequest->id]) }}" class="btn-primary w-full text-center">
                    <i class="fas fa-file-invoice mr-2"></i>Créer Bon de Commande
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal Approbation --}}
<div id="approveModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <h3 class="text-lg font-bold mb-4">Approuver la Demande</h3>
        <form action="{{ route('purchase_requests.approve', $purchaseRequest) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Commentaire</label>
                <textarea name="commentaire" rows="3" class="form-input w-full" placeholder="Commentaire facultatif..."></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('approveModal').classList.add('hidden')" class="btn-secondary">Annuler</button>
                <button type="submit" class="btn-primary bg-green-600 hover:bg-green-700">Approuver</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Rejet --}}
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <h3 class="text-lg font-bold mb-4">Rejeter la Demande</h3>
        <form action="{{ route('purchase_requests.reject', $purchaseRequest) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Motif du Rejet <span class="text-red-500">*</span></label>
                <textarea name="commentaire" rows="3" class="form-input w-full" required placeholder="Précisez le motif du rejet..."></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" class="btn-secondary">Annuler</button>
                <button type="submit" class="btn-secondary bg-red-600 text-white hover:bg-red-700">Rejeter</button>
            </div>
        </form>
    </div>
</div>
@endsection
