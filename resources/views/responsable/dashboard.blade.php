@extends('responsable.layouts.template')

@section('title', 'Tableau de bord Responsable')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Header with Welcome Message -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Tableau de Bord</h1>
                <p class="text-gray-500 mt-1">Bienvenue dans votre espace de gestion, <span
                        class="font-bold text-red-600">{{ Auth::guard('user')->user()->prenom }}</span>.</p>
            </div>
            <div class="flex items-center gap-3 bg-white p-2 rounded-2xl border border-gray-100 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center font-bold">
                    {{ date('d') }}
                </div>
                <div class="pr-4">
                    <span
                        class="block text-xs font-bold text-gray-400 uppercase tracking-widest">{{ \Carbon\Carbon::now()->translatedFormat('F') }}</span>
                    <span
                        class="block text-sm font-black text-gray-900">{{ \Carbon\Carbon::now()->translatedFormat('l Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 mb-10">
            <!-- Total Interventions -->
            <div
                class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all group overflow-hidden relative">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-gray-50 rounded-full group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="relative z-10">
                    <div
                        class="w-12 h-12 rounded-2xl bg-gray-900 text-white flex items-center justify-center mb-4 shadow-lg shadow-gray-200">
                        <i class="fas fa-folder-open text-xl"></i>
                    </div>
                    <span class="block text-sm font-bold text-gray-400 uppercase tracking-widest mb-1">Total</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-black text-gray-900">{{ $stats['total'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Envoyées -->
            <div
                class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all group overflow-hidden relative">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="relative z-10">
                    <div
                        class="w-12 h-12 rounded-2xl bg-blue-500 text-white flex items-center justify-center mb-4 shadow-lg shadow-blue-200">
                        <i class="fas fa-paper-plane text-xl"></i>
                    </div>
                    <span class="block text-sm font-bold text-blue-400 uppercase tracking-widest mb-1">Envoyées</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-black text-gray-900">{{ $stats['envoyees'] }}</span>
                    </div>
                </div>
            </div>

            <!-- À Confirmer -->
            <div
                class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all group overflow-hidden relative">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-orange-50 rounded-full group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="relative z-10">
                    <div
                        class="w-12 h-12 rounded-2xl bg-orange-500 text-white flex items-center justify-center mb-4 shadow-lg shadow-orange-200">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <span class="block text-sm font-bold text-orange-400 uppercase tracking-widest mb-1">Factures</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-black text-gray-900">{{ $stats['confirmer'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Rapports Reçus -->
            <div
                class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all group overflow-hidden relative">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-purple-50 rounded-full group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="relative z-10">
                    <div
                        class="w-12 h-12 rounded-2xl bg-purple-500 text-white flex items-center justify-center mb-4 shadow-lg shadow-purple-200">
                        <i class="fas fa-tasks text-xl"></i>
                    </div>
                    <span class="block text-sm font-bold text-purple-400 uppercase tracking-widest mb-1">Rapports</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-black text-gray-900">{{ $stats['traitees'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Devis Reçus -->
            <div
                class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all group overflow-hidden relative">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-yellow-50 rounded-full group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="relative z-10">
                    <div
                        class="w-12 h-12 rounded-2xl bg-yellow-500 text-white flex items-center justify-center mb-4 shadow-lg shadow-yellow-200">
                        <i class="fas fa-file-invoice-dollar text-xl"></i>
                    </div>
                    <span class="block text-sm font-bold text-yellow-400 uppercase tracking-widest mb-1">Devis</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-black text-gray-900">{{ $stats['devis'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Payées -->
            <div
                class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all group overflow-hidden relative">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-green-50 rounded-full group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="relative z-10">
                    <div
                        class="w-12 h-12 rounded-2xl bg-green-500 text-white flex items-center justify-center mb-4 shadow-lg shadow-green-200">
                        <i class="fas fa-check-double text-xl"></i>
                    </div>
                    <span class="block text-sm font-bold text-green-400 uppercase tracking-widest mb-1">Payées</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-black text-gray-900">{{ $stats['payees'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Table -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8 border-b border-gray-50 flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                    <i class="fas fa-list-ul text-red-600"></i>
                    Interventions Récentes
                </h3>
                <a href="{{ route('responsable.interventions.historique') }}"
                    class="text-sm font-bold text-gray-400 hover:text-red-600 transition-colors uppercase tracking-widest flex items-center gap-2">
                    Tout voir <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Référence
                            </th>
                            <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Libellé
                            </th>
                            <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Site</th>
                            <th
                                class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">
                                Statut</th>
                            <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($recentInterventions as $intervention)
                            <tr class="hover:bg-gray-50 transition-colors duration-200 group">
                                <td class="px-8 py-5">
                                    <span
                                        class="text-xs font-mono font-bold text-red-600 bg-red-50 px-2 py-1 rounded-md border border-red-100">
                                        {{ $intervention->code }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <span
                                        class="block text-sm font-bold text-gray-900 max-w-xs truncate">{{ $intervention->libelle }}</span>
                                    <span class="block text-[10px] text-gray-400 font-medium">Créée le
                                        {{ $intervention->created_at->translatedFormat('d F Y') }}</span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                        <span
                                            class="text-sm font-medium text-gray-600">{{ $intervention->site->name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    @php
                                        $statusColors = [
                                            'envoyer' => 'bg-blue-100 text-blue-700 border-blue-200',
                                            'confirmer' => 'bg-orange-100 text-orange-700 border-orange-200',
                                            'accord' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                                            'finance' => 'bg-teal-100 text-teal-700 border-teal-200',
                                            'payer' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                            'valider' => 'bg-green-100 text-green-700 border-green-200',
                                            'rejeter' => 'bg-red-100 text-red-700 border-red-200',
                                            'traiter' => 'bg-purple-100 text-purple-700 border-purple-200',
                                        ];
                                        $colorClass = $statusColors[$intervention->statut] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $colorClass }}">
                                        {{ $intervention->statut }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <a href="{{ route('responsable.interventions.details', $intervention) }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-gray-200 text-gray-400 hover:text-red-600 hover:border-red-600 hover:shadow-md transition-all group-hover:scale-110">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center mb-4">
                                            <i class="fas fa-folder-open text-gray-300 text-2xl"></i>
                                        </div>
                                        <p class="text-gray-400 font-medium italic">Aucune intervention récente trouvée.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection