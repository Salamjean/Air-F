<header class="flex items-center justify-between px-6 py-4 bg-white shadow-sm border-b border-gray-100">
    <div class="flex items-center">
        <button class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none" id="sidebarToggle">
            <i class="fas fa-bars text-xl"></i>
        </button>

        <div class="hidden md:block ml-4">
            <h2 class="text-xl font-semibold text-gray-800">
                @yield('header_title', 'Tableau de bord')
            </h2>
            <p class="text-sm text-gray-500">Bienvenue dans votre espace Financier</p>
        </div>
    </div>

    <div class="flex items-center space-x-4">
        <!-- Notifications -->
        <div class="relative group">
            <button class="relative text-gray-400 hover:text-gray-600 transition-colors focus:outline-none p-2">
                <i class="fas fa-bell"></i>
                @php
                    $unreadCount = Auth::guard('user')->user()->unreadNotifications->count();
                @endphp
                @if($unreadCount > 0)
                    <span
                        class="absolute top-1.5 right-1.5 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full border-2 border-white flex items-center justify-center">
                        {{ $unreadCount }}
                    </span>
                @endif
            </button>

            <!-- Notifications Dropdown -->
            <div
                class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl py-4 invisible opacity-0 translate-y-2 group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-200 z-50 transform origin-top-right border border-gray-100">
                <div class="px-4 mb-3 flex items-center justify-between border-b border-gray-50 pb-2">
                    <h3 class="text-sm font-bold text-gray-900">Notifications</h3>
                    <span
                        class="text-[10px] font-medium text-red-500 bg-red-50 px-2 py-0.5 rounded-full">{{ $unreadCount }}
                        nouvelles</span>
                </div>

                <div class="max-h-64 overflow-y-auto">
                    @forelse(Auth::guard('user')->user()->notifications->take(5) as $notification)
                        <div
                            class="px-4 py-3 hover:bg-gray-50 transition-colors cursor-pointer border-b border-gray-50 last:border-0 {{ $notification->unread() ? 'bg-red-50/30' : '' }}">
                            <div class="flex gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-900 leading-tight">
                                        {{ $notification->data['reference'] ?? 'Rappel Paiement' }}
                                    </p>
                                    <p class="text-[10px] text-gray-500 mt-1 line-clamp-2">
                                        {{ $notification->data['message'] ?? 'Délai de paiement approchant.' }}
                                    </p>
                                    <span class="text-[9px] text-gray-400 mt-1 block">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-4 py-8 text-center">
                            <i class="fas fa-bell-slash text-2xl text-gray-200 mb-2"></i>
                            <p class="text-xs text-gray-500 text-center">Aucune notification pour le moment.</p>
                        </div>
                    @endforelse
                </div>

                <div class="px-4 mt-3 pt-2 border-t border-gray-50">
                    <a href="#"
                        class="block text-center text-xs font-bold text-red-600 hover:text-red-700 transition-colors">
                        Voir tout l'historique
                    </a>
                </div>
            </div>
        </div>

        <div class="h-8 w-px bg-gray-200 mx-2"></div>

        <div class="relative group">
            <button class="flex items-center space-x-2 focus:outline-none">
                <img src="https://ui-avatars.com/api/?name={{ Auth::guard('user')->user()->name . ' ' . Auth::guard('user')->user()->prenom ?? 'Financier' }}&background=EBF4FF&color=EF4444"
                    class="w-10 h-10 rounded-full border-2 border-white shadow-sm" alt="Financier">
                <div class="hidden md:block text-left">
                    <span
                        class="block text-sm font-medium text-gray-700">{{ Auth::guard('user')->user()->name . ' ' . Auth::guard('user')->user()->prenom ?? 'Financier' }}</span>
                    <span class="block text-xs text-gray-500">Financier</span>
                </div>
                <i class="fas fa-chevron-down text-xs text-gray-400 group-hover:text-gray-600 transition-colors"></i>
            </button>

            <!-- Dropdown -->
            <div
                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 invisible opacity-0 translate-y-2 group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-200 z-50 transform origin-top-right border border-gray-100">
                <a href="{{ route('financier.profile.edit') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                    <i class="fas fa-user-circle mr-2 text-gray-400"></i> Mon Profil
                </a>
                <div class="border-t border-gray-100 my-1"></div>
                <form action="{{ route('financier.logout') }}" method="POST">
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