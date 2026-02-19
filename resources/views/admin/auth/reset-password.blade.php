<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-900 flex items-center justify-center min-h-screen relative overflow-hidden">

    <!-- Background Decoration -->
    <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
        <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-red-600 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-[500px] h-[500px] bg-orange-500 rounded-full blur-[100px]">
        </div>
    </div>

    <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 sm:p-8 relative z-10 mx-4 sm:mx-0">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-lock-open text-4xl text-red-600"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Nouveau mot de passe</h2>
            <p class="text-gray-500 mt-2">Entrez le code reçu par mail et votre nouveau mot de passe pour
                <strong>{{ $email }}</strong></p>
        </div>

        <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">

            <div>
                <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Code OTP de vérification</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-shield-alt text-gray-400"></i>
                    </div>
                    <input type="text" id="code" name="code" required
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all font-mono text-lg tracking-widest text-center"
                        placeholder="XXXX">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" id="password" name="password" required
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all"
                            placeholder="••••••••">
                    </div>
                </div>
                <div>
                    <label for="confirme_password"
                        class="block text-sm font-medium text-gray-700 mb-1">Confirmer</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-check-circle text-gray-400"></i>
                        </div>
                        <input type="password" id="confirme_password" name="confirme_password" required
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all"
                            placeholder="••••••••">
                    </div>
                </div>
            </div>

            <button type="submit"
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all transform hover:-translate-y-1">
                RÉINITIALISER LE MOT DE PASSE
            </button>
        </form>
    </div>

</body>

<script>
    // SweetAlert notifications
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Succès',
            text: {!! json_encode(session('success')) !!},
            confirmButtonText: 'OK',
            background: 'white',
        });
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: {!! json_encode(session('error')) !!},
            confirmButtonText: 'OK',
            background: 'white',
        });
    @endif

    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Erreur de validation',
            html: `
                    <ul class="text-center">
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                `,
            confirmButtonText: 'OK',
            background: 'white',
        });
    @endif
</script>

</html>