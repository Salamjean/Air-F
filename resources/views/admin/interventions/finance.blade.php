@extends('admin.layouts.template')

@section('content')
    <div class="container mx-auto px-6 py-10">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 gap-6">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Interventions en Finance</h1>
                <p class="text-lg text-gray-600 mt-2">Suivi des interventions envoyées à la finance pour paiement.</p>
            </div>

            <!-- Search Bar -->
            <div class="w-full md:w-auto relative">
                <form action="{{ route('admin.interventions.finance') }}" method="GET" class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 group-focus-within:text-yellow-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="pl-10 pr-4 py-3 w-full md:w-80 bg-white border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-300 placeholder-gray-400 text-gray-700"
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
                            class="bg-yellow-50/50 border-b border-gray-100 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Référence</th>
                            <th class="px-6 py-4">Libellé</th>
                            <th class="px-6 py-4">Financier Assigné</th>
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
                                            class="text-sm font-bold text-gray-900 group-hover:text-yellow-600 transition-colors">
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
                                    <div class="text-xs text-gray-500 truncate mt-0.5" title="{{ $intervention->description }}">
                                        {{ $intervention->description }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($intervention->financier)
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-6 h-6 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 flex-shrink-0 text-xs">
                                                <i class="fas fa-user-tie"></i>
                                            </div>
                                            <span class="text-sm text-gray-700">
                                                {{ $intervention->financier->name . ' ' . $intervention->financier->prenom }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Non assigné</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0 text-xs">
                                            <i class="fas fa-building"></i>
                                        </div>
                                        <span class="text-sm text-gray-700">
                                            {{ $intervention->prestataire->name . ' ' . $intervention->prestataire->prenom ?? 'Non assigné' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold text-gray-900">
                                        {{ number_format($intervention->montant, 0, ',', ' ') }} €
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700 border border-yellow-100">
                                        <i class="fas fa-clock text-yellow-500"></i> En Finance
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.interventions.details', $intervention->id) }}"
                                            class="inline-flex items-center justify-center px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors text-xs font-semibold"
                                            title="Détails">
                                            <i class="fas fa-info-circle mr-1.5"></i> Détails
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-money-check text-2xl text-gray-300"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900">Aucune intervention en finance</h3>
                                        <p class="text-gray-500 mt-1 max-w-sm text-sm">Les interventions envoyées à la finance
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