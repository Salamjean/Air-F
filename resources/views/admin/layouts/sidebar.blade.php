<div class="fixed inset-y-0 left-0 w-64 bg-gray-900 text-white transition-transform transform -translate-x-full md:translate-x-0 z-30 flex flex-col"
    id="sidebar">
    <div class="flex items-center justify-center h-16 bg-red-700 shadow-md">
        <h1 class="text-2xl font-bold tracking-wider uppercase">{{ Auth::guard('user')->user()->role ?? 'Admin' }}</h1>
    </div>

    <nav class="flex-1 overflow-y-auto py-4 custom-scrollbar">
        <div class="px-4 mb-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Menu Principal
        </div>

        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center px-6 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <i class="fas fa-tachometer-alt w-6"></i>
            <span class="mx-3 font-medium">Tableau de bord</span>
        </a>

        <div class="px-4 mt-6 mb-2 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">
            Interventions
        </div>

        <a href="{{ route('admin.interventions.create') }}"
            class="flex items-center px-6 py-3 {{ request()->routeIs('admin.interventions.create') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <i class="fas fa-plus-circle w-6 text-sm"></i>
            <span class="mx-3 font-medium">Demander</span>
        </a>

        <a href="{{ route('admin.interventions.index') }}"
            class="flex items-center px-6 py-3 {{ request()->routeIs('admin.interventions.index') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <i class="fas fa-list-ul w-6 text-sm"></i>
            <span class="mx-3 font-medium">Toutes les interventions</span>
        </a>

        <a href="{{ route('admin.interventions.envoie') }}"
            class="flex items-center justify-between px-6 py-3 {{ request()->routeIs('admin.interventions.envoie') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <div class="flex items-center">
                <i class="fas fa-paper-plane w-6 text-sm"></i>
                <span class="mx-3 font-medium">Envoyées</span>
            </div>
            @if($countEnvoie > 0)
                <span
                    class="bg-blue-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $countEnvoie }}</span>
            @endif
        </a>

        <a href="{{ route('admin.interventions.confirmer') }}"
            class="flex items-center justify-between px-6 py-3 {{ request()->routeIs('admin.interventions.confirmer') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <div class="flex items-center">
                <i class="fas fa-check-double w-6 text-sm"></i>
                <span class="mx-3 font-medium">Confirmées</span>
            </div>
            @if($countConfirmer > 0)
                <span
                    class="bg-green-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $countConfirmer }}</span>
            @endif
        </a>

        <a href="{{ route('admin.interventions.traitees') }}"
            class="flex items-center justify-between px-6 py-3 {{ request()->routeIs('admin.interventions.traitees') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <div class="flex items-center">
                <i class="fas fa-tasks w-6 text-sm"></i>
                <span class="mx-3 font-medium">Traitées</span>
            </div>
            @if($countTraiter > 0)
                <span
                    class="bg-purple-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $countTraiter }}</span>
            @endif
        </a>

        <a href="{{ route('admin.interventions.devis') }}"
            class="flex items-center justify-between px-6 py-3 {{ request()->routeIs('admin.interventions.devis') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <div class="flex items-center">
                <i class="fas fa-file-invoice-dollar w-6 text-sm"></i>
                <span class="mx-3 font-medium">Devis reçus</span>
            </div>
            @if($countDevis > 0)
                <span
                    class="bg-yellow-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $countDevis }}</span>
            @endif
        </a>

        <a href="{{ route('admin.interventions.accordees') }}"
            class="flex items-center justify-between px-6 py-3 {{ request()->routeIs('admin.interventions.accordees') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <div class="flex items-center">
                <i class="fas fa-thumbs-up w-6 text-sm"></i>
                <span class="mx-3 font-medium">Accordées</span>
            </div>
            @if($countAccord > 0)
                <span
                    class="bg-indigo-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $countAccord }}</span>
            @endif
        </a>

        <a href="{{ route('admin.interventions.finance') }}"
            class="flex items-center justify-between px-6 py-3 {{ request()->routeIs('admin.interventions.finance') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <div class="flex items-center">
                <i class="fas fa-money-bill-wave w-6 text-sm"></i>
                <span class="mx-3 font-medium">En Finance</span>
            </div>
            @if($countFinance > 0)
                <span
                    class="bg-orange-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $countFinance }}</span>
            @endif
        </a>

        <a href="{{ route('admin.interventions.payees') }}"
            class="flex items-center justify-between px-6 py-3 {{ request()->routeIs('admin.interventions.payees') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <div class="flex items-center">
                <i class="fas fa-history w-6 text-sm"></i>
                <span class="mx-3 font-medium">Payées (Historique)</span>
            </div>
            @if($countPayerTotal > 0)
                <span
                    class="bg-emerald-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $countPayerTotal }}</span>
            @endif
        </a>

        <!-- <a href="{{ route('admin.interventions.archives') }}"
            class="flex items-center px-6 py-3 {{ request()->routeIs('admin.interventions.archives') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <i class="fas fa-archive w-6 text-sm"></i>
            <span class="mx-3 font-medium">Archives</span>
        </a> -->

        @if (Auth::guard('user')->user()->role === 'admin')
            <div class="px-4 mt-6 mb-2 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">
                Configuration
            </div>

            <div class="relative">
                <button onclick="toggleSubmenu('equipements-submenu', 'equipements-chevron')"
                    class="w-full flex items-center justify-between px-6 py-3 {{ request()->is('admin/equipements*') || request()->is('admin/categories*') || request()->is('admin/sites*') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all border-l-4 border-transparent focus:outline-none group">
                    <div class="flex items-center">
                        <i class="fas fa-tools w-6"></i>
                        <span class="mx-3 font-medium">Consommables & Sites</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs transition-transform transform {{ request()->is('admin/equipements*') || request()->is('admin/categories*') || request()->is('admin/sites*') ? 'rotate-180' : '' }}"
                        id="equipements-chevron"></i>
                </button>
                <div id="equipements-submenu"
                    class="{{ request()->is('admin/equipements*') || request()->is('admin/categories*') || request()->is('admin/sites*') ? '' : 'hidden' }} bg-gray-800 overflow-hidden transition-all duration-300">
                    <a href="{{ route('admin.equipements.index') }}"
                        class="flex items-center pl-16 py-2 text-sm {{ request()->routeIs('admin.equipements.index') ? 'text-white font-bold' : 'text-gray-400 hover:text-white' }} hover:bg-gray-700 transition-colors">
                        <i class="fas fa-list w-4 text-xs mr-2"></i> Gestion de Stock
                    </a>
                    <a href="{{ route('admin.categories.index') }}"
                        class="flex items-center pl-16 py-2 text-sm {{ request()->routeIs('admin.categories.index') ? 'text-white font-bold' : 'text-gray-400 hover:text-white' }} hover:bg-gray-700 transition-colors">
                        <i class="fas fa-tags w-4 text-xs mr-2"></i> Catégories
                    </a>
                    <a href="{{ route('admin.equipements.history') }}"
                        class="flex items-center pl-16 py-2 text-sm {{ request()->routeIs('admin.equipements.history') ? 'text-white font-bold' : 'text-gray-400 hover:text-white' }} hover:bg-gray-700 transition-colors">
                        <i class="fas fa-history w-4 text-xs mr-2"></i> Historique
                    </a>
                    <a href="{{ route('admin.sites.index') }}"
                        class="flex items-center pl-16 py-2 text-sm {{ request()->routeIs('admin.sites.index') ? 'text-white font-bold' : 'text-gray-400 hover:text-white' }} hover:bg-gray-700 transition-colors">
                        <i class="fas fa-map-marked-alt w-4 text-xs mr-2"></i> Sites
                    </a>
                </div>
            </div>

            <!-- Utilisateurs Dropdown -->
            <div class="relative">
                <button onclick="toggleSubmenu('users-submenu', 'users-chevron')"
                    class="w-full flex items-center justify-between px-6 py-3 {{ request()->is('admin/users*') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all border-l-4 border-transparent focus:outline-none group">
                    <div class="flex items-center">
                        <i class="fas fa-users w-6"></i>
                        <span class="mx-3 font-medium">Utilisateurs</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs transition-transform transform {{ request()->is('admin/users*') ? 'rotate-180' : '' }}"
                        id="users-chevron"></i>
                </button>
                <div id="users-submenu"
                    class="{{ request()->is('admin/users*') ? '' : 'hidden' }} bg-gray-800 overflow-hidden transition-all duration-300">
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center pl-16 py-2 text-sm {{ request()->routeIs('admin.users.index') ? 'text-white font-bold' : 'text-gray-400 hover:text-white' }} hover:bg-gray-700 transition-colors">
                        <i class="fas fa-list w-4 text-xs mr-2"></i> Liste
                    </a>
                    <a href="{{ route('admin.users.create') }}"
                        class="flex items-center pl-16 py-2 text-sm {{ request()->routeIs('admin.users.create') ? 'text-white font-bold' : 'text-gray-400 hover:text-white' }} hover:bg-gray-700 transition-colors">
                        <i class="fas fa-plus-circle w-4 text-xs mr-2"></i> Ajouter
                    </a>
                    <a href="{{ route('admin.users.archives') }}"
                        class="flex items-center pl-16 py-2 text-sm {{ request()->routeIs('admin.users.archives') ? 'text-white font-bold' : 'text-gray-400 hover:text-white' }} hover:bg-gray-700 transition-colors">
                        <i class="fas fa-archive w-4 text-xs mr-2"></i> Archives
                    </a>
                </div>
            </div>

            <a href="{{ route('admin.forfaits.index') }}"
                class="flex items-center px-6 py-3 {{ request()->routeIs('admin.forfaits.index') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
                <i class="fas fa-certificate w-6"></i>
                <span class="mx-3 font-medium">Gestion des Forfaits</span>
            </a>
        @endif

        <!-- <a href="#"
            class="flex items-center px-6 py-3 text-gray-400 hover:bg-gray-800 hover:text-gray-100 hover:border-l-4 hover:border-red-500 transition-all border-l-4 border-transparent">
            <i class="fas fa-cogs w-6"></i>
            <span class="mx-3 font-medium">Paramètres</span>
        </a> -->
    </nav>

    <div class="w-full p-4 border-t border-gray-800 bg-gray-900">
        <a href="#" class="flex items-center text-gray-400 hover:text-white transition-colors">
            <div class="w-8 h-8 rounded-full bg-red-600 flex items-center justify-center mr-3">
                <i class="fas fa-user-shield text-xs"></i>
            </div>
            <div>
                <p class="text-sm font-medium">
                    {{ Auth::guard('user')->user()->name . ' ' . Auth::guard('user')->user()->prenom ?? 'Admin' }}
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