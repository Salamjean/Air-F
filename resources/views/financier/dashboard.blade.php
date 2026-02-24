@extends('financier.layouts.template')

@section('title', 'Tableau de bord Financier')

@section('content')
    <div class="container mx-auto px-6 py-10">
        <!-- Header -->
        <div class="mb-10">
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Tableau de Bord</h1>
            <p class="text-lg text-gray-600 mt-2">Bienvenue, <span
                    class="text-red-600 font-bold">{{ Auth::guard('user')->user()->prenom }}
                    {{ Auth::guard('user')->user()->name }}</span>. Voici un aperçu de la situation financière.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <!-- Carte À Payer -->
            <div
                class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-red-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110">
                </div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-6">
                        <div
                            class="w-14 h-14 bg-red-100 rounded-2xl flex items-center justify-center text-red-600 shadow-inner">
                            <i class="fas fa-file-invoice-dollar text-2xl"></i>
                        </div>
                        <span
                            class="bg-red-50 text-red-700 text-[10px] font-extrabold px-3 py-1 rounded-full uppercase tracking-widest border border-red-100">À
                            Payer</span>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-4xl font-black text-gray-900 mb-1">{{ $interventionsToPay }}</h3>
                        <span class="text-gray-400 text-sm font-semibold uppercase">Dossiers</span>
                    </div>
                    <p class="text-sm text-gray-500 font-medium">En attente de règlement</p>
                </div>
                <div class="mt-6 pt-6 border-t border-gray-50 flex justify-between items-center">
                    <a href="{{ route('financier.interventions.index') }}"
                        class="text-sm font-bold text-red-600 hover:text-red-700 flex items-center group/link">
                        Gérer les paiements <i
                            class="fas fa-chevron-right ml-2 text-[10px] transition-transform group-hover/link:translate-x-1"></i>
                    </a>
                </div>
            </div>

            <!-- Carte Payées -->
            <div
                class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-green-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110">
                </div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-6">
                        <div
                            class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center text-green-600 shadow-inner">
                            <i class="fas fa-check-double text-2xl"></i>
                        </div>
                        <span
                            class="bg-green-50 text-green-700 text-[10px] font-extrabold px-3 py-1 rounded-full uppercase tracking-widest border border-green-100">Réglés</span>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-4xl font-black text-gray-900 mb-1">{{ $interventionsPaid }}</h3>
                        <span class="text-gray-400 text-sm font-semibold uppercase">Validés</span>
                    </div>
                    <p class="text-sm text-gray-500 font-medium">Total factures réglées</p>
                </div>
                <div class="mt-6 pt-6 border-t border-gray-50">
                    <a href="{{ route('financier.interventions.historique') }}"
                        class="text-sm font-bold text-green-600 hover:text-green-700 flex items-center group/link">
                        Voir l'historique <i
                            class="fas fa-chevron-right ml-2 text-[10px] transition-transform group-hover/link:translate-x-1"></i>
                    </a>
                </div>
            </div>

            <!-- Carte Montant Total -->
            <div
                class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110">
                </div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-6">
                        <div
                            class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 shadow-inner">
                            <i class="fas fa-wallet text-2xl"></i>
                        </div>
                        <span
                            class="bg-blue-50 text-blue-700 text-[10px] font-extrabold px-3 py-1 rounded-full uppercase tracking-widest border border-blue-100">Trésorerie</span>
                    </div>
                    <h3 class="text-4xl font-black text-gray-900 mb-1">{{ number_format($totalPaidAmount, 0, ',', ' ') }}
                        <span class="text-lg text-gray-400 font-bold uppercase ml-1">EURO</span></h3>
                    <p class="text-sm text-gray-500 font-medium">Cumul total décaissé</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Dernières demandes de paiement -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <div>
                        <h3 class="text-xl font-black text-gray-900 tracking-tight">Flux Entrant</h3>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mt-1">Dernières demandes à
                            traiter</p>
                    </div>
                    <a href="{{ route('financier.interventions.index') }}"
                        class="text-xs font-bold text-red-600 hover:bg-red-600 hover:text-white border border-red-100 bg-red-50/50 px-4 py-2 rounded-xl transition-all duration-300">Tout
                        voir</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <tbody class="divide-y divide-gray-50">
                            @forelse($recentToPay as $intervention)
                                <tr class="hover:bg-gray-50/80 transition-all duration-200 group">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center text-orange-600 mr-4 shadow-sm group-hover:scale-110 transition-transform">
                                                <i class="fas fa-file-invoice text-sm"></i>
                                            </div>
                                            <div>
                                                <p
                                                    class="text-sm font-bold text-gray-900 group-hover:text-red-700 transition-colors">
                                                    {{ $intervention->libelle }}</p>
                                                <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">
                                                    {{ $intervention->reference }}</p>
                                                @if($intervention->personnels->count() > 0)
                                                    <div class="flex flex-wrap gap-1 mt-1">
                                                        @foreach($intervention->personnels as $p)
                                                            <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-lg border border-indigo-100">
                                                                {{ $p->prenom }} {{ $p->name }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <span
                                            class="text-sm font-black text-gray-900">{{ number_format($intervention->montant, 0, ',', ' ') }}
                                            <span class="text-[10px]">EURO</span></span>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <a href="{{ route('financier.interventions.paiement_detail', $intervention->id) }}"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-gray-100 text-gray-500 hover:bg-red-600 hover:text-white transition-all duration-300 shadow-sm"
                                            title="Procéder au paiement">
                                            <i class="fas fa-chevron-right text-[10px]"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-8 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-inbox text-3xl text-gray-200 mb-2"></i>
                                            <p class="text-sm font-bold text-gray-400">Aucune demande en attente</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Derniers paiements effectués -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <div>
                        <h3 class="text-xl font-black text-gray-900 tracking-tight">Flux Sortant</h3>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mt-1">Derniers paiements
                            validés</p>
                    </div>
                    <a href="{{ route('financier.interventions.historique') }}"
                        class="text-xs font-bold text-green-600 hover:bg-green-600 hover:text-white border border-green-100 bg-green-50/50 px-4 py-2 rounded-xl transition-all duration-300">Historique</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <tbody class="divide-y divide-gray-50">
                            @forelse($recentPaid as $intervention)
                                <tr class="hover:bg-gray-50/80 transition-all duration-200">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 mr-4 text-xs shadow-sm">
                                                <i class="fas fa-check-double"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-gray-900 truncate max-w-[180px]"
                                                    title="{{ $intervention->libelle }}">
                                                    {{ $intervention->libelle }}
                                                </p>
                                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">
                                                    Le
                                                    {{ \Carbon\Carbon::parse($intervention->date_paiement_effectif)->format('d/m/Y à H:i') }}
                                                </p>
                                                @if($intervention->personnels->count() > 0)
                                                    <div class="flex flex-wrap gap-1 mt-1">
                                                        @foreach($intervention->personnels as $p)
                                                            <span class="text-[9px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full border border-indigo-100">
                                                                {{ $p->prenom }} {{ $p->name }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 text-right flex flex-col items-end">
                                        <span
                                            class="text-sm font-black text-green-700">{{ number_format($intervention->montant, 0, ',', ' ') }}
                                            <span class="text-[10px]">EURO</span></span>
                                        <span
                                            class="text-[9px] font-extrabold text-green-600 bg-green-50 px-2 rounded-full uppercase tracking-tighter mt-1 border border-green-100">Payé</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-8 py-12 text-center text-gray-500 text-sm">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-history text-3xl text-gray-200 mb-2"></i>
                                            <p class="text-sm font-bold text-gray-400">Aucun paiement récent</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection