@props(['agences'])

<div class="bg-hh-card p-4 rounded-xl shadow">
    <h4 class="text-lg font-semibold mb-3">Agences</h4>
    @if($agences->isEmpty())
        <p class="text-sm text-hh-muted">Aucune agence trouvée.</p>
    @else
        <ul class="list-disc pl-5 space-y-1">
            @foreach($agences as $a)
                <li>{{ $a->name ?? 'N/A' }} ({{ $a->code ?? '-' }})</li>
            @endforeach
        </ul>
    @endif
</div>




