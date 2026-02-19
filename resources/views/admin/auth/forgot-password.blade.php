<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
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

    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 sm:p-8 relative z-10 mx-4 sm:mx-0">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-key text-4xl text-red-600"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">MOT DE PASSE OUBLIÉ</h2>
            <p class="text-gray-500 mt-2">Entrez votre email pour recevoir un code OTP</p>
        </div>

        <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" id="email" name="email" required
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all"
                        placeholder="exemple@pompier.com">
                </div>
            </div>

            <button type="submit"
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all transform hover:-translate-y-1">
                ENVOYER LE CODE
            </button>

            <div class="text-center mt-4">
                <a href="{{ route('login') }}"
                    class="text-sm font-medium text-gray-600 hover:text-red-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Retour à la connexion
                </a>
            </div>
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
            title: 'Erreur',
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