<x-guest-layout>
    <h2 class="text-xl font-bold mb-4">Réinitialiser le mot de passe</h2>

    <p class="text-sm mb-6 text-neutral-300">
        Entrez votre adresse email pour recevoir un lien de réinitialisation.
    </p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
            <label class="block mb-1 hh-gold">Email</label>
            <input type="email" name="email"
                   class="w-full bg-black border hh-border-gold text-white p-3 rounded-lg"
                   required>
        </div>

        <button class="w-full py-3 hh-bg-gold text-black font-bold rounded-lg hover:bg-[#c79549] transition">
            Envoyer le lien
        </button>
    </form>
</x-guest-layout>
