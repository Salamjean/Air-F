<div class="fixed inset-y-0 left-0 w-64 bg-gray-900 text-white transition-transform transform -translate-x-full md:translate-x-0 z-30"
    id="sidebar">
    <div class="flex items-center justify-center h-16 bg-red-700 shadow-md">
        <h1 class="text-2xl font-bold tracking-wider uppercase">{{ Auth::guard('user')->user()->role ?? 'Prestataire' }}
        </h1>
    </div>

    <nav class="mt-6">
        <div class="px-4 mb-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Menu Principal
        </div>

        <a href="{{ route('prestataire.dashboard') }}"
            class="flex items-center px-6 py-3 {{ request()->routeIs('prestataire.dashboard') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <i class="fas fa-tachometer-alt w-6"></i>
            <span class="mx-3 font-medium">Tableau de bord</span>
        </a>

        <div class="px-4 mt-6 mb-2 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">
            Interventions
        </div>

        <a href="{{ route('prestataire.interventions.en_attente') }}"
            class="flex items-center justify-between px-6 py-3 {{ request()->routeIs('prestataire.interventions.en_attente') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <div class="flex items-center">
                <i class="fas fa-clock w-6 text-sm"></i>
                <span class="mx-3 font-medium">En attente</span>
            </div>
            @if($countEnAttentePrestataire > 0)
                <span class="bg-gray-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                    {{ $countEnAttentePrestataire }}
                </span>
            @endif
        </a>

        <a href="{{ route('prestataire.interventions.valider') }}"
            class="flex items-center justify-between px-6 py-3 {{ request()->routeIs('prestataire.interventions.valider') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <div class="flex items-center">
                <i class="fas fa-check-circle w-6 text-sm"></i>
                <span class="mx-3 font-medium">À Valider</span>
            </div>
            @if($countValiderPrestataire > 0)
                <span class="bg-blue-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                    {{ $countValiderPrestataire }}
                </span>
            @endif
        </a>

        <a href="{{ route('prestataire.interventions.facturees') }}"
            class="flex items-center justify-between px-6 py-3 {{ request()->routeIs('prestataire.interventions.facturees') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <div class="flex items-center">
                <i class="fas fa-file-invoice w-6 text-sm"></i>
                <span class="mx-3 font-medium">Factures</span>
            </div>
            @if($countFacturePrestataire > 0)
                <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                    {{ $countFacturePrestataire }}
                </span>
            @endif
        </a>

        <a href="{{ route('prestataire.interventions.accordees') }}"
            class="flex items-center justify-between px-6 py-3 {{ request()->routeIs('prestataire.interventions.accordees') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <div class="flex items-center">
                <i class="fas fa-file-signature w-6 text-sm"></i>
                <span class="mx-3 font-medium">Accordées</span>
            </div>
            @if($countAccordPrestataire > 0)
                <span class="bg-indigo-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                    {{ $countAccordPrestataire }}
                </span>
            @endif
        </a>

        <a href="{{ route('prestataire.interventions.finance') }}"
            class="flex items-center justify-between px-6 py-3 {{ request()->routeIs('prestataire.interventions.finance') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <div class="flex items-center">
                <i class="fas fa-university w-6 text-sm"></i>
                <span class="mx-3 font-medium">En Finance</span>
            </div>
            @if($countFinancePrestataire > 0)
                <span class="bg-teal-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                    {{ $countFinancePrestataire }}
                </span>
            @endif
        </a>

        <a href="{{ route('prestataire.interventions.rejeter') }}"
            class="flex items-center justify-between px-6 py-3 {{ request()->routeIs('prestataire.interventions.rejeter') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <div class="flex items-center">
                <i class="fas fa-times-circle w-6 text-sm"></i>
                <span class="mx-3 font-medium">Rejetées</span>
            </div>
            @if($countRejeterPrestataire > 0)
                <span class="bg-orange-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                    {{ $countRejeterPrestataire }}
                </span>
            @endif
        </a>

        <div class="px-4 mt-6 mb-2 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">
            Devis & Personnel
        </div>

        <a href="{{ route('prestataire.interventions.devis.attente') }}"
            class="flex items-center justify-between px-6 py-3 {{ request()->routeIs('prestataire.interventions.devis.attente') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <div class="flex items-center">
                <i class="fas fa-file-invoice-dollar w-6 text-sm"></i>
                <span class="mx-3 font-medium">Devis en attente</span>
            </div>
            @if($countDevisAttentePrestataire > 0)
                <span class="bg-purple-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                    {{ $countDevisAttentePrestataire }}
                </span>
            @endif
        </a>

        <a href="{{ route('prestataire.interventions.devis.historique') }}"
            class="flex items-center justify-between px-6 py-3 {{ request()->routeIs('prestataire.interventions.devis.historique') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <div class="flex items-center">
                <i class="fas fa-history w-6 text-sm"></i>
                <span class="mx-3 font-medium">Hist. Devis</span>
            </div>
            @if($countDevisHistoriquePrestataire > 0)
                <span class="bg-pink-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                    {{ $countDevisHistoriquePrestataire }}
                </span>
            @endif
        </a>

        <!-- Personnel Dropdown -->
        <div class="relative">
            <button onclick="toggleSubmenu('personnel-submenu', 'personnel-chevron')"
                class="w-full flex items-center justify-between px-6 py-3 {{ request()->is('prestataire/personnel*') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all border-l-4 border-transparent focus:outline-none group">
                <div class="flex items-center">
                    <i class="fas fa-users w-6"></i>
                    <span class="mx-3 font-medium">Personnel</span>
                </div>
                <i class="fas fa-chevron-down text-xs transition-transform transform {{ request()->is('prestataire/personnel*') ? 'rotate-180' : '' }}"
                    id="personnel-chevron"></i>
            </button>
            <div id="personnel-submenu"
                class="{{ request()->is('prestataire/personnel*') ? '' : 'hidden' }} bg-gray-800 overflow-hidden transition-all duration-300">
                <a href="{{ route('prestataire.personnel.index') }}"
                    class="flex items-center pl-16 py-2 text-sm {{ request()->routeIs('prestataire.personnel.index') ? 'text-white font-bold' : 'text-gray-400 hover:text-white' }} hover:bg-gray-700 transition-colors">
                    <i class="fas fa-list w-4 text-xs mr-2"></i> Liste
                </a>
                <a href="{{ route('prestataire.personnel.create') }}"
                    class="flex items-center pl-16 py-2 text-sm {{ request()->routeIs('prestataire.personnel.create') ? 'text-white font-bold' : 'text-gray-400 hover:text-white' }} hover:bg-gray-700 transition-colors">
                    <i class="fas fa-plus w-4 text-xs mr-2"></i> Ajouter
                </a>
            </div>
        </div>

        <a href="{{ route('prestataire.interventions.historique') }}"
            class="flex items-center justify-between px-6 py-3 {{ request()->routeIs('prestataire.interventions.historique') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all border-l-4 border-transparent">
            <div class="flex items-center">
                <i class="fas fa-check-double w-6"></i>
                <span class="mx-3 font-medium">Historique Payée</span>
            </div>
            @if($countPayerPrestataire > 0)
                <span class="bg-green-500 text-white text-xs font-bold px-2 py-0.5 rounded-full shadow-sm">
                    {{ $countPayerPrestataire }}
                </span>
            @endif
        </a>

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
                    {{ Auth::guard('user')->user()->name . ' ' . Auth::guard('user')->user()->prenom ?? 'Prestataire' }}
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