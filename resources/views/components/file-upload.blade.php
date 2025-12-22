{{-- Component: File Upload Section --}}
@props([
    'model' => null,
    'route' => null,
    'label' => 'Pièces jointes',
])

<div class="mb-6">
    {{-- Upload Input --}}
    <label class="block text-sm font-medium text-hh-muted mb-2">{{ $label }}</label>
    <input 
        type="file" 
        name="attachments[]" 
        multiple 
        class="w-full px-4 py-3 bg-hh-dark border border-hh-border rounded-lg text-hh-light focus:border-hh-accent focus:ring-2 focus:ring-hh-accent/20 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-hh-accent file:text-white file:cursor-pointer hover:file:bg-hh-accent/90"
        accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.zip"
    >
    <p class="mt-2 text-xs text-hh-muted">Formats acceptés: PDF, Word, Excel, Images, ZIP (Max: 10MB par fichier)</p>
</div>

{{-- Existing Files Display (edit mode only) --}}
@if($model && $model->attachments && count($model->attachments) > 0)
<div class="mb-6">
    <h4 class="text-sm font-medium text-hh-muted mb-3">Fichiers existants</h4>
    <div class="space-y-2">
        @foreach($model->attachments as $index => $file)
        <div class="flex items-center justify-between p-3 bg-hh-dark/30 border border-hh-border rounded-lg hover:bg-hh-dark/50 transition-colors">
            <div class="flex items-center gap-3 flex-1">
                {{-- File Icon --}}
                <div class="flex-shrink-0">
                    @php
                        $ext = pathinfo($file['original_name'], PATHINFO_EXTENSION);
                        $iconClass = match(strtolower($ext)) {
                            'pdf' => 'text-red-500',
                            'doc', 'docx' => 'text-blue-500',
                            'xls', 'xlsx' => 'text-green-500',
                            'jpg', 'jpeg', 'png', 'gif' => 'text-purple-500',
                            'zip', 'rar' => 'text-yellow-500',
                            default => 'text-gray-500'
                        };
                    @endphp
                    <svg class="w-6 h-6 {{ $iconClass }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                
                {{-- File Info --}}
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-hh-light truncate">{{ $file['original_name'] }}</p>
                    <p class="text-xs text-hh-muted">
                        {{ number_format($file['size'] / 1024, 2) }} KB
                        · Ajouté le {{ \Carbon\Carbon::parse($file['uploaded_at'])->format('d/m/Y') }}
                    </p>
                </div>
            </div>
            
            {{-- Actions --}}
            <div class="flex items-center gap-2 flex-shrink-0">
                {{-- Download Button --}}
                <a href="{{ route($route . '.attachments.download', [$model->id, $index]) }}" 
                   class="px-3 py-1.5 text-xs font-medium text-blue-400 hover:text-blue-300 hover:bg-blue-500/10 rounded-lg transition-colors"
                   title="Télécharger">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                </a>
                
                {{-- Delete Button --}}
                <form method="POST" action="{{ route($route . '.attachments.delete', [$model->id, $index]) }}" 
                      onsubmit="return confirm('Supprimer ce fichier ?')" 
                      class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-3 py-1.5 text-xs font-medium text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-lg transition-colors"
                            title="Supprimer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
