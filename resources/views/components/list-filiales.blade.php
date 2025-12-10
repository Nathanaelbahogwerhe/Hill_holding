@props(['filiales'])

<div class="bg-hh-card p-4 rounded-lg shadow">
    <h4 class="text-lg font-semibold mb-3">Filiales et Agences</h4>
    @if($filiales->isEmpty())
        <p class="text-sm text-hh-muted">Aucune filiale trouvÃ©e.</p>
    @else
        <ul class="list-disc pl-5 space-y-1">
            @foreach($filiales as $f)
                <li class="font-medium">{{ $f->name ?? 'N/A' }} ({{ $f->code ?? '-' }})</li>
                <ul class="list-circle pl-5 space-y-1">
                    @foreach($f->agences ?? collect() as $a)
                        <li>{{ $a->name ?? 'N/A' }} ({{ $a->code ?? '-' }})</li>
                    @endforeach
                </ul>
            @endforeach
        </ul>
    @endif
</div>







