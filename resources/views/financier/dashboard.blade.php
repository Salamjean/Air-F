@extends('financier.layouts.template')

@section('title', 'Tableau de bord Financier')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Tableau de bord</h1>
            <p class="text-gray-500 mt-2">Bienvenue, <span class="font-semibold text-gray-700">{{ Auth::guard('user')->user()->prenom }} {{ Auth::guard('user')->user()->name }}</span>. Voici un aperçu de votre activité financière.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Carte À Payer -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-all">
                <div class="absolute top-0 right-0 w-24 h-24 bg-red-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center text-red-600">
                            <i class="fas fa-file-invoice-dollar text-xl"></i>
                        </div>
                        <span class="bg-red-50 text-red-600 text-xs font-bold px-2 py-1 rounded-full">À traiter</span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ $interventionsToPay }}</h3>
                    <p class="text-sm text-gray-500 font-medium">Factures en attente de paiement</p>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-50">
                    <a href="{{ route('financier.interventions.index') }}" class="text-sm font-semibold text-red-600 hover:text-red-700 flex items-center">
                        Voir les demandes <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Carte Payées -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-all">
                <div class="absolute top-0 right-0 w-24 h-24 bg-green-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-green-600">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <span class="bg-green-50 text-green-600 text-xs font-bold px-2 py-1 rounded-full">Terminé</span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ $interventionsPaid }}</h3>
                    <p class="text-sm text-gray-500 font-medium">Factures réglées</p>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-50">
                    <a href="{{ route('financier.interventions.historique') }}" class="text-sm font-semibold text-green-600 hover:text-green-700 flex items-center">
                        Voir l'historique <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Carte Montant Total -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-all">
                <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                            <i class="fas fa-coins text-xl"></i>
                        </div>
                        <span class="bg-blue-50 text-blue-600 text-xs font-bold px-2 py-1 rounded-full">Total Décaissé</span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ number_format($totalPaidAmount, 0, ',', ' ') }} <span class="text-lg text-gray-500 font-normal">EURO</span></h3>
                    <p class="text-sm text-gray-500 font-medium">Montant total des paiements</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Dernières demandes de paiement -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800">Dernières demandes</h3>
                    <a href="{{ route('financier.interventions.index') }}" class="text-xs font-semibold text-red-600 hover:text-red-700 bg-red-50 px-3 py-1.5 rounded-lg transition-colors">Tout voir</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Intervention</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Montant</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($recentToPay as $intervention)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center text-orange-500 mr-3">
                                                <i class="fas fa-bolt"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-gray-900">{{ $intervention->libelle }}</p>
                                                <p class="text-xs text-gray-500">{{ $intervention->site->nom ?? 'Site inconnu' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-sm font-bold text-gray-900">{{ number_format($intervention->montant, 0, ',', ' ') }} FCFA</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('financier.interventions.paiement_detail', $intervention->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-50 text-red-600 hover:bg-red-100 transition-colors" title="Procéder au paiement">
                                            <i class="fas fa-arrow-right text-xs"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-gray-500 text-sm">
                                        Aucune demande en attente.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Derniers paiements effectués -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/30">
                    <h3 class="font-bold text-gray-800">Derniers paiements</h3>
                    <a href="{{ route('financier.interventions.historique') }}" class="text-xs font-semibold text-green-600 hover:text-green-700 bg-green-50 px-3 py-1.5 rounded-lg transition-colors">Tout voir</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Intervention</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Montant</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($recentPaid as $intervention)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 mr-3 text-xs">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-700 truncate max-w-[150px]" title="{{ $intervention->libelle }}">
                                                {{ $intervention->libelle }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($intervention->updated_at)->locale('fr')->isoFormat('D MMM YYYY') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-sm font-bold text-green-600">{{ number_format($intervention->montant, 0, ',', ' ') }} FCFA</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-gray-500 text-sm">
                                        Aucun paiement récent.
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
