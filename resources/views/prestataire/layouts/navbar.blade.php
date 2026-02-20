<header class="flex items-center justify-between px-6 py-4 bg-white shadow-sm border-b border-gray-100">
    <div class="flex items-center">
        <button class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none" id="sidebarToggle">
            <i class="fas fa-bars text-xl"></i>
        </button>

        <div class="hidden md:block ml-4">
            <h2 class="text-xl font-semibold text-gray-800">
                @yield('header_title', 'Tableau de bord')
            </h2>
            <p class="text-sm text-gray-500">Bienvenue dans votre espace Prestataire</p>
        </div>
    </div>

    <div class="flex items-center space-x-4">
        <!-- Notifications (Future) -->
        <button class="relative text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fas fa-bell"></i>
            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
        </button>

        <div class="h-8 w-px bg-gray-200 mx-2"></div>

        <div class="relative group">
            <button class="flex items-center space-x-2 focus:outline-none">
                <img src="https://ui-avatars.com/api/?name={{ Auth::guard('user')->user()->name . ' ' . Auth::guard('user')->user()->prenom ?? 'Prestataire' }}&background=EBF4FF&color=EF4444"
                    class="w-10 h-10 rounded-full border-2 border-white shadow-sm" alt="Prestataire">
                <div class="hidden md:block text-left">
                    <span
                        class="block text-sm font-medium text-gray-700">{{ Auth::guard('user')->user()->name . ' ' . Auth::guard('user')->user()->prenom ?? 'Prestataire' }}</span>
                    <span class="block text-xs text-gray-500">Prestataire</span>
                </div>
                <i class="fas fa-chevron-down text-xs text-gray-400 group-hover:text-gray-600 transition-colors"></i>
            </button>

            <!-- Dropdown -->
            <div
                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 invisible opacity-0 translate-y-2 group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-200 z-50 transform origin-top-right border border-gray-100">
                <a href="{{ route('prestataire.profile.edit') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                    <i class="fas fa-user-circle mr-2 text-gray-400"></i> Mon Profil
                </a>
                <div class="border-t border-gray-100 my-1"></div>
                <form action="{{ route('prestataire.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors font-medium">
                        <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>