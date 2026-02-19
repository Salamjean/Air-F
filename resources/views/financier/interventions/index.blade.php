@extends('financier.layouts.template')

@section('content')
    <div class="container mx-auto px-6 py-10">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 gap-6">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Fait un paiement</h1>
                <p class="text-lg text-gray-600 mt-2">Liste des interventions en attente de validation de paiement.</p>
            </div>

            <!-- Search Bar -->
            <div class="w-full md:w-auto relative">
                <form action="{{ route('financier.interventions.index') }}" method="GET" class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 group-focus-within:text-red-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="pl-10 pr-4 py-3 w-full md:w-80 bg-white border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300 placeholder-gray-400 text-gray-700"
                        placeholder="Rechercher par référence, code...">
                </form>
            </div>
        </div>

        <!-- Table Container -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr
                            class="bg-gray-50 border-b border-gray-100 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Référence</th>
                            <th class="px-6 py-4">Libellé</th>
                            <th class="px-6 py-4">Technicien</th>
                            <th class="px-6 py-4">Prestataire</th>
                            <th class="px-6 py-4">Montant</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($interventions as $intervention)
                            <tr class="hover:bg-gray-50 transition-colors duration-200 group">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-sm font-bold text-gray-900 group-hover:text-red-600 transition-colors">
                                            {{ $intervention->reference }}
                                        </span>
                                        <span
                                            class="text-xs font-mono text-gray-500 bg-gray-100 px-2 py-0.5 rounded w-fit mt-1">
                                            {{ $intervention->code }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 max-w-xs truncate">
                                    <div class="text-sm font-semibold text-gray-900 truncate"
                                        title="{{ $intervention->libelle }}">
                                        {{ $intervention->libelle }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($intervention->personnels->count() > 0)
                                        <div class="flex flex-col gap-1">
                                            @foreach($intervention->personnels as $personnel)
                                                <div class="flex items-center gap-2">
                                                    <div
                                                        class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0 text-[10px]">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                    <span class="text-xs text-gray-700">
                                                        {{ $personnel->name . ' ' . $personnel->prenom }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Non assigné</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 flex-shrink-0 text-xs">
                                            <i class="fas fa-building"></i>
                                        </div>
                                        <span class="text-sm text-gray-700">
                                            {{ $intervention->prestataire->name . ' ' . $intervention->prestataire->prenom ?? 'N/A' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold text-gray-900">
                                        {{ number_format($intervention->montant, 0, ',', ' ') }} EURO
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700 border border-yellow-100">
                                        <i class="fas fa-clock text-yellow-500"></i> En attente
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('financier.interventions.paiement_detail', $intervention->id) }}"
                                        class="inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl transition-all text-xs font-bold shadow-sm hover:shadow-md">
                                        <i class="fas fa-check-circle mr-2"></i> Valider Paiement
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-money-check text-2xl text-gray-300"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900">Aucun paiement en attente</h3>
                                        <p class="text-gray-500 mt-1 max-w-sm text-sm">Les interventions envoyées par l'admin
                                            apparaîtront ici.</p>
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