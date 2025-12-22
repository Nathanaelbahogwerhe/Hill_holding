<x-guest-layout>
    <h2 class="text-xl font-bold mb-4">Nouveau mot de passe</h2>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-4">
            <label class="block mb-1 hh-gold">Email</label>
            <input type="email" name="email"
                   class="w-full bg-black border hh-border-gold text-white p-3 rounded-lg"
                   required autofocus>
        </div>

        <div class="mb-4">
            <label class="block mb-1 hh-gold">Nouveau mot de passe</label>
            <input type="password" name="password"
                   class="w-full bg-black border hh-border-gold text-white p-3 rounded-lg"
                   required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 hh-gold">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation"
                   class="w-full bg-black border hh-border-gold text-white p-3 rounded-lg"
                   required>
        </div>

        <button class="w-full py-3 hh-bg-gold text-black font-bold rounded-lg hover:bg-[#c79549] transition">
            Réinitialiser
        </button>
    </form>
</x-guest-layout>
