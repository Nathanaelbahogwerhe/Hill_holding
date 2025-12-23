@extends('layouts.app')

@section('title', 'Administration')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <h1 class="text-5xl font-bold bg-gradient-to-r from-[#D4AF37] via-yellow-500 to-[#D4AF37] bg-clip-text text-transparent animate-gradient">Console d'administration</h1>

    {{-- Notifications --}}
    @if(session('success'))
        <div class="p-3 bg-green-600 text-white rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-3 bg-red-600 text-white rounded">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Créer rôle --}}
        <section class="bg-hh-card p-6 rounded shadow">
            <h2 class="font-semibold mb-3">Créer un rôle</h2>
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block mb-1">Nom du rôle</label>
                    <input name="name" class="w-full px-3 py-2 rounded bg-transparent border border-hh-border" required>
                </div>

                <div class="mb-3">
                    <label class="block mb-1">Autorisations</label>
                    <div class="grid grid-cols-2 gap-2 max-h-40 overflow-auto">
                        @foreach(\Spatie\Permission\Models\Permission::orderBy('name')->get() as $perm)
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="permissions[]" value="{{ $perm->id }}">
                                <span class="text-sm">{{ $perm->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end">
                    <button class="px-4 py-2 bg-hh-gold text-black rounded">Créer le rôle</button>
                </div>
            </form>
        </section>

        {{-- Créer autorisation --}}
        <section class="bg-hh-card p-6 rounded shadow">
            <h2 class="font-semibold mb-3">Créer une autorisation</h2>
            <form action="{{ route('permissions.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block mb-1">Nom de l'autorisation</label>
                    <input name="name" class="w-full px-3 py-2 rounded bg-transparent border border-hh-border" required>
                </div>
                <div class="flex justify-end">
                    <button class="px-4 py-2 bg-hh-gold text-black rounded">Créer</button>
                </div>
            </form>
        </section>

        {{-- Créer filiale --}}
        <section class="bg-hh-card p-6 rounded shadow">
            <h2 class="font-semibold mb-3">Créer une filiale</h2>
            <form action="{{ route('filiales.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block mb-1">Nom de la filiale</label>
                    <input name="name" class="w-full px-3 py-2 rounded bg-transparent border border-hh-border" required>
                </div>
                <div class="flex justify-end">
                    <button class="px-4 py-2 bg-hh-gold text-black rounded">Créer</button>
                </div>
            </form>
        </section>

        {{-- Créer agence --}}
        <section class="bg-hh-card p-6 rounded shadow">
            <h2 class="font-semibold mb-3">Créer une agence</h2>
            <form action="{{ route('agences.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block mb-1">Nom de l'agence</label>
                    <input name="name" class="w-full px-3 py-2 rounded bg-transparent border border-hh-border" required>
                </div>

                <div class="mb-3">
                    <label class="block mb-1">Filiale (optionnelle)</label>
                    <select name="filiale_id" class="w-full px-3 py-2 rounded bg-transparent border border-hh-border">
                        <option value="">-- Aucune --</option>
                        @foreach(\App\Models\Filiale::orderBy('name')->get() as $f)
                            <option value="{{ $f->id }}">{{ $f->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end">
                    <button class="px-4 py-2 bg-hh-gold text-black rounded">Créer</button>
                </div>
            </form>
        </section>

    </div>

    {{-- Attribution rôle / autorisations Àun utilisateur --}}
    <section class="bg-hh-card p-6 rounded shadow">
        <h2 class="font-semibold mb-3">Attribuer rôle et autorisations Àun utilisateur</h2>

        <form id="admin-user-form" method="POST">
            @csrf
            <div class="grid md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block mb-1">Utilisateur</label>
                    <select id="admin-user-select" class="w-full px-3 py-2 rounded bg-transparent border border-hh-border" required>
                        <option value="">-- Sélectionner --</option>
                        @foreach(\App\Models\User::orderBy('name')->get() as $u)
                            <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1">Rôle</label>
                    <select id="admin-user-role" class="w-full px-3 py-2 rounded bg-transparent border border-hh-border">
                        <option value="">-- (aucun) --</option>
                        @foreach(\Spatie\Permission\Models\Role::orderBy('name')->get() as $r)
                            <option value="{{ $r->name }}">{{ $r->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1">Autorisations (cocher)</label>
                    <div class="max-h-40 overflow-auto border rounded p-2 bg-transparent">
                        @foreach(\Spatie\Permission\Models\Permission::orderBy('name')->get() as $p)
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="permissions[]" value="{{ $p->name }}" class="admin-perm-checkbox">
                                <span class="text-sm">{{ $p->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" id="admin-user-submit" class="px-4 py-2 bg-blue-600 text-white rounded">Appliquer</button>
            </div>
        </form>

        <script>
            document.getElementById('admin-user-submit').addEventListener('click', function () {
                const userId = document.getElementById('admin-user-select').value;
                if (!userId) { alert('Veuillez sélectionner un utilisateur.'); return; }

                const role = document.getElementById('admin-user-role').value;
                const permEls = document.querySelectorAll('.admin-perm-checkbox');
                const perms = [];
                permEls.forEach(el => { if (el.checked) perms.push(el.value); });

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/admin/users/' + userId + '/permissions';
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
                const inputToken = document.createElement('input'); inputToken.type = 'hidden'; inputToken.name = '_token'; inputToken.value = token;
                form.appendChild(inputToken);

                perms.forEach(p => {
                    const i = document.createElement('input'); i.type='hidden'; i.name='permissions[]'; i.value = p; form.appendChild(i);
                });

                if (role) {
                    const ir = document.createElement('input'); ir.type='hidden'; ir.name='roles[]'; ir.value = role; form.appendChild(ir);
                }
                document.body.appendChild(form);
                form.submit();
            });
        </script>
    </section>

</div>
@endsection