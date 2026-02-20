@extends('personnel.layouts.template')

@section('content')
    <div class="container mx-auto px-6 py-10">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 gap-6">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Interventions à Traiter</h1>
                <p class="text-lg text-gray-600 mt-2">Liste des interventions qui vous sont assignées.</p>
            </div>

            <!-- Search Bar -->
            <div class="w-full md:w-auto relative">
                <form action="{{ route('personnel.interventions.index') }}" method="GET" class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 group-focus-within:text-red-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="pl-10 pr-4 py-3 w-full md:w-80 bg-white border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300 placeholder-gray-400 text-gray-700"
                        placeholder="Rechercher par référence...">
                </form>
            </div>
        </div>

        <!-- Cards Grid -->
        <!-- Table Container -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Référence</th>
                            <th class="px-6 py-4">Libellé</th>
                            <th class="px-6 py-4">Lieu</th>
                            <th class="px-6 py-4">Période</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($interventions as $intervention)
                            <tr class="hover:bg-gray-50 transition-colors duration-200 group">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-gray-900 group-hover:text-red-600 transition-colors">
                                            {{ $intervention->reference }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="max-w-xs">
                                        <div class="text-sm font-semibold text-gray-900 truncate" title="{{ $intervention->libelle }}">
                                            {{ $intervention->libelle }}
                                        </div>
                                        <div class="text-xs text-gray-500 truncate mt-0.5" title="{{ $intervention->description }}">
                                            {{ $intervention->description }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                         <span class="text-sm text-gray-700 font-bold">{{ $intervention->site->name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col text-xs text-gray-600">
                                        <span class="flex items-center gap-1.5">
                                            <i class="far fa-calendar-alt text-gray-400 w-3"></i>
                                            {{ \Carbon\Carbon::parse($intervention->date_debut)->format('d/m/Y') }}
                                        </span>
                                        <span class="flex items-center gap-1.5 mt-1">
                                            <i class="far fa-arrow-alt-circle-right text-gray-300 w-3"></i>
                                            {{ \Carbon\Carbon::parse($intervention->date_fin)->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($intervention->statut == 'traiter_incorrect')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                            <i class="fas fa-exclamation-circle"></i> Correction
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                            <i class="fas fa-tools"></i> À faire
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        <a href="{{ route('personnel.interventions.show', $intervention) }}"
                                           class="inline-flex items-center justify-center w-10 h-10 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-800 transition-colors shadow-sm"
                                           title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @php
                                            $userAssignment = $intervention->personnels->firstWhere('id', auth('user')->id());
                                            $isResponsible = $userAssignment ? $userAssignment->pivot->is_responsible : false;
                                        @endphp
                                        
                                        @if($isResponsible)
                                            <a href="{{ route('personnel.interventions.edit', $intervention->id) }}"
                                               class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-red-600 hover:border-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all shadow-sm">
                                                @if($intervention->statut == 'traiter_incorrect')
                                                    <i class="fas fa-edit mr-2"></i> Corriger
                                                @else
                                                    <i class="fas fa-hammer mr-2"></i> Traiter
                                                @endif
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-clipboard-check text-2xl text-gray-300"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900">Aucune intervention</h3>
                                        <p class="text-gray-500 mt-1 max-w-sm text-sm">Vous n'avez aucune intervention assignée en attente de traitement pour le moment.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination (if applicable) -->
            @if(method_exists($interventions, 'links'))
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $interventions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection