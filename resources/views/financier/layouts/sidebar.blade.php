<div class="fixed inset-y-0 left-0 w-64 bg-gray-900 text-white transition-transform transform -translate-x-full md:translate-x-0 z-30"
    id="sidebar">
    <div class="flex items-center justify-center h-16 bg-red-700 shadow-md">
        <h1 class="text-2xl font-bold tracking-wider uppercase">{{ Auth::guard('user')->user()->role ?? 'Financier' }}
        </h1>
    </div>

    <nav class="mt-6">
        <div class="px-4 mb-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Menu Principal
        </div>

        <a href="{{ route('financier.dashboard') }}"
            class="flex items-center px-6 py-3 {{ request()->routeIs('financier.dashboard') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100 hover:border-l-4 hover:border-red-500 border-l-4 border-transparent' }} transition-colors">
            <i class="fas fa-tachometer-alt w-6"></i>
            <span class="mx-3 font-medium">Tableau de bord</span>
        </a>

        <a href="{{ route('financier.interventions.index') }}"
            class="flex items-center justify-between px-6 py-3 {{ request()->routeIs('financier.interventions.index') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100 hover:border-l-4 hover:border-red-500 border-l-4 border-transparent' }} transition-colors group">
            <div class="flex items-center">
                <i class="fas fa-file-invoice-dollar w-6"></i>
                <span class="mx-3 font-medium">Réception</span>
            </div>
            @php
                $countReception = \App\Models\Intervention::where('statut', 'finance')->count();
            @endphp
            @if($countReception > 0)
                <span
                    class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full shadow-sm group-hover:bg-red-600 transition-colors">
                    {{ $countReception }}
                </span>
            @endif
        </a>

        <a href="{{ route('financier.interventions.attente_delai') }}"
            class="flex items-center justify-between px-6 py-3 {{ request()->routeIs('financier.interventions.attente_delai') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100 hover:border-l-4 hover:border-red-500 border-l-4 border-transparent' }} transition-colors group">
            <div class="flex items-center">
                <i class="fas fa-hourglass-start w-6"></i>
                <span class="mx-3 font-medium">Fixer le délai</span>
            </div>
            @php
                $countDelai = \App\Models\Intervention::where('statut', 'receptionne')->count();
            @endphp
            @if($countDelai > 0)
                <span
                    class="bg-orange-500 text-white text-xs font-bold px-2 py-0.5 rounded-full shadow-sm group-hover:bg-orange-600 transition-colors">
                    {{ $countDelai }}
                </span>
            @endif
        </a>

        <a href="{{ route('financier.interventions.attente_reglement') }}"
            class="flex items-center justify-between px-6 py-3 {{ request()->routeIs('financier.interventions.attente_reglement') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100 hover:border-l-4 hover:border-red-500 border-l-4 border-transparent' }} transition-colors group">
            <div class="flex items-center">
                <i class="fas fa-money-check-alt w-6"></i>
                <span class="mx-3 font-medium">Attente Règlement</span>
            </div>
            @php
                $countReglement = \App\Models\Intervention::where('statut', 'attente_paiement')->count();
            @endphp
            @if($countReglement > 0)
                <span
                    class="bg-blue-500 text-white text-xs font-bold px-2 py-0.5 rounded-full shadow-sm group-hover:bg-blue-600 transition-colors">
                    {{ $countReglement }}
                </span>
            @endif
        </a>

        <a href="{{ route('financier.interventions.historique') }}"
            class="flex items-center justify-between px-6 py-3 {{ request()->routeIs('financier.interventions.historique') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100 hover:border-l-4 hover:border-red-500 border-l-4 border-transparent' }} transition-colors group">
            <div class="flex items-center">
                <i class="fas fa-check-double w-6"></i>
                <span class="mx-3 font-medium">Historique</span>
            </div>
        </a>

        <!-- Utilisateurs Dropdown -->
        <div class="relative">
            <button onclick="toggleSubmenu('users-submenu', 'users-chevron')"
                class="w-full flex items-center justify-between px-6 py-3 {{ request()->routeIs('financier.users.*') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100 hover:border-l-4 hover:border-red-500' }} transition-all border-l-4 border-transparent focus:outline-none group">
                <div class="flex items-center">
                    <i class="fas fa-users w-6"></i>
                    <span class="mx-3 font-medium">Agent</span>
                </div>
                <i class="fas fa-chevron-down text-xs transition-transform transform {{ request()->routeIs('financier.users.*') ? 'rotate-180' : '' }} group-hover:text-white"
                    id="users-chevron"></i>
            </button>
            <div id="users-submenu"
                class="{{ request()->routeIs('financier.users.*') ? '' : 'hidden' }} bg-gray-800 overflow-hidden transition-all duration-300">
                <a href="{{ route('financier.users.create') }}"
                    class="flex items-center pl-16 py-2 text-sm {{ request()->routeIs('financier.users.create') ? 'text-white bg-gray-700' : 'text-gray-400 hover:text-white hover:bg-gray-700' }} transition-colors">
                    <i class="fas fa-plus-circle w-4 text-xs mr-2"></i> Ajouter
                </a>
                <a href="{{ route('financier.users.index') }}"
                    class="flex items-center pl-16 py-2 text-sm {{ request()->routeIs('financier.users.index') ? 'text-white bg-gray-700' : 'text-gray-400 hover:text-white hover:bg-gray-700' }} transition-colors">
                    <i class="fas fa-list w-4 text-xs mr-2"></i> Liste
                </a>
            </div>
        </div>

        <a href="#"
            class="flex items-center px-6 py-3 text-gray-400 hover:bg-gray-800 hover:text-gray-100 hover:border-l-4 hover:border-red-500 transition-all border-l-4 border-transparent">
            <i class="fas fa-cogs w-6"></i>
            <span class="mx-3 font-medium">Paramètres</span>
        </a>
    </nav>

    <div class="absolute bottom-0 w-full p-4 border-t border-gray-800">
        <a href="#" class="flex items-center text-gray-400 hover:text-white transition-colors">
            <div class="w-8 h-8 rounded-full bg-red-600 flex items-center justify-center mr-3">
                <i class="fas fa-user-shield text-xs"></i>
            </div>
            <div>
                <p class="text-sm font-medium">
                    {{ Auth::guard('user')->user()->name . ' ' . Auth::guard('user')->user()->prenom ?? 'Financier' }}
                </p>
                <p class="text-xs text-green-400">En ligne</p>
            </div>
        </a>
    </div>
</div>

<!-- Mobile Sidebar Overlay -->
<div class="fixed inset-0 bg-black opacity-50 z-20 hidden md:hidden" id="sidebarOverlay"></div>

<script>
    function toggleSubmenu(menuId, chevronId) {
        const menu = document.getElementById(menuId);
        const chevron = document.getElementById(chevronId);

        menu.classList.toggle('hidden');

        if (menu.classList.contains('hidden')) {
            chevron.classList.remove('rotate-180');
        } else {
            chevron.classList.add('rotate-180');
        }
    }
</script>