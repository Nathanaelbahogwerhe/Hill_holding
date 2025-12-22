@include('layouts.auth', ['slot' => $slot])
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hill Holding – Connexion</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: #000;
            color: #fff;
        }
        .hh-gold {
            color: #d4a053;
        }
        .hh-bg-gold {
            background-color: #d4a053;
        }
        .hh-border-gold {
            border-color: #d4a053;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-md bg-black/40 border border-neutral-800 rounded-xl p-10 shadow-xl">
        <div class="text-center mb-8">
            <img src="{{ asset('images/hill_logo.png') }}" class="mx-auto w-32 mb-4" alt="Hill Holding Logo">
            <h1 class="text-2xl font-bold hh-gold">Hill Holding</h1>
        </div>

        {{ $slot }}
    </div>

</body>
</html>
