<div class="fixed inset-y-0 left-0 w-64 bg-gray-900 text-white transition-transform transform -translate-x-full md:translate-x-0 z-30"
    id="sidebar">
    <div class="flex items-center justify-center h-16 bg-red-700 shadow-md">
        <h1 class="text-2xl font-bold tracking-wider uppercase">{{ Auth::guard('user')->user()->role ?? 'Responsable' }}
        </h1>
    </div>

    <nav class="mt-6">
        <div class="px-4 mb-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Menu Principal
        </div>

        <a href="{{ route('responsable.dashboard') }}"
            class="flex items-center px-6 py-3 {{ request()->routeIs('responsable.dashboard') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <i class="fas fa-tachometer-alt w-6"></i>
            <span class="mx-3 font-medium">Tableau de bord</span>
        </a>

        <a href="{{ route('responsable.interventions.envoyees') }}"
            class="flex items-center justify-between px-6 py-3 {{ request()->routeIs('responsable.interventions.envoyees') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <div class="flex items-center">
                <i class="fas fa-paper-plane w-6 text-sm"></i>
                <span class="mx-3 font-medium">Interventions Envoyées</span>
            </div>
            @if(isset($countEnvoieResponsable) && $countEnvoieResponsable > 0)
                <span class="bg-blue-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                    {{ $countEnvoieResponsable }}
                </span>
            @endif
        </a>

        <a href="{{ route('responsable.interventions.confirmer') }}"
            class="flex items-center justify-between px-6 py-3 {{ request()->routeIs('responsable.interventions.confirmer') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <div class="flex items-center">
                <i class="fas fa-check-double w-6 text-sm"></i>
                <span class="mx-3 font-medium">À Confirmer</span>
            </div>
            @if(isset($countConfirmerResponsable) && $countConfirmerResponsable > 0)
                <span class="bg-green-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                    {{ $countConfirmerResponsable }}
                </span>
            @endif
        </a>

        <a href="{{ route('responsable.interventions.accordees') }}"
            class="flex items-center justify-between px-6 py-3 {{ request()->routeIs('responsable.interventions.accordees') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <div class="flex items-center">
                <i class="fas fa-file-signature w-6 text-sm"></i>
                <span class="mx-3 font-medium">Accordées</span>
            </div>
            @if(isset($countAccordResponsable) && $countAccordResponsable > 0)
                <span class="bg-indigo-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                    {{ $countAccordResponsable }}
                </span>
            @endif
        </a>

        <a href="{{ route('responsable.interventions.historique') }}"
            class="flex items-center justify-between px-6 py-3 {{ request()->routeIs('responsable.interventions.historique') ? 'bg-gray-800 text-gray-100 border-l-4 border-red-500' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }} transition-all">
            <div class="flex items-center">
                <i class="fas fa-history w-6 text-sm"></i>
                <span class="mx-3 font-medium">Historique</span>
            </div>
            @if(isset($countPayerResponsable) && $countPayerResponsable > 0)
                <span class="bg-emerald-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                    {{ $countPayerResponsable }}
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
                    {{ Auth::guard('user')->user()->name . ' ' . Auth::guard('user')->user()->prenom ?? 'Responsable' }}
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