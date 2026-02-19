<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- Scripts & Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gray-100 flex overflow-hidden h-screen">

    <!-- Sidebar -->
    @include('personnel.layouts.sidebar')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden transition-all duration-300 md:ml-64 w-full"
        id="mainContent">

        <!-- Navbar -->
        @include('personnel.layouts.navbar')

        <!-- Page Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
            @yield('content')
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const sidebarToggle = document.getElementById('sidebarToggle');

        // Mobile Sidebar Toggle
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
                sidebarOverlay.classList.toggle('hidden');
            });
        }

        // Close sidebar when clicking overlay
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            });
        }
    </script>

    <!-- Flash Messages via SweetAlert -->
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: {!! json_encode(session('success')) !!},
                confirmButtonText: 'OK',
                timer: 3000
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: {!! json_encode(session('error')) !!},
                confirmButtonText: 'OK'
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Erreur de validation',
                html: `
                        <ul style="text-align: center; color:red">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    `,
                confirmButtonText: 'OK'
            });
        @endif
    </script>

    @stack('scripts')
</body>

</html>