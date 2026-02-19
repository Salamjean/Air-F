@extends('prestataire.layouts.template')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Interventions à la Finance</h1>
                <p class="text-gray-600 mt-2">Dossiers transmis au service financier pour validation et paiement.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <form action="{{ route('prestataire.interventions.finance') }}" method="GET" class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full md:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                        placeholder="Recherche (Réf, Code...)">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Référence</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Libellé
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Montant
                                Final</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Soumis
                                le</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Évolution du Statut</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($interventions as $intervention)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-bold text-gray-800">{{ $intervention->reference }}</span>
                                    <div class="text-[10px] text-gray-400 font-mono italic">{{ $intervention->code }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $intervention->libelle }}</div>
                                    <div class="text-xs text-gray-500 truncate max-w-xs">
                                        {{ Str::limit($intervention->description, 50) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="font-bold text-gray-900">{{ number_format($intervention->montant, 0, ',', ' ') }}
                                        EURO</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <div class="flex flex-col">
                                        <span
                                            class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($intervention->date_soumission_finance)->format('d/m/Y') }}</span>
                                        <span class="text-[10px] text-gray-400">par l'administration</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <!-- Status Evolution Tracker -->
                                    <div class="flex items-center gap-2">
                                        <div class="flex flex-col items-center">
                                            <div class="w-4 h-4 rounded-full bg-green-500 flex items-center justify-center">
                                                <i class="fas fa-check text-[8px] text-white"></i>
                                            </div>
                                            <span
                                                class="text-[8px] mt-1 font-bold text-gray-400 uppercase tracking-tight">Facturé</span>
                                        </div>
                                        <div class="w-6 h-0.5 bg-green-500"></div>
                                        <div class="flex flex-col items-center">
                                            <div class="w-4 h-4 rounded-full bg-green-500 flex items-center justify-center">
                                                <i class="fas fa-check text-[8px] text-white"></i>
                                            </div>
                                            <span
                                                class="text-[8px] mt-1 font-bold text-gray-400 uppercase tracking-tight">Accord</span>
                                        </div>
                                        <div class="w-6 h-0.5 bg-green-500"></div>
                                        <div class="flex flex-col items-center">
                                            <div
                                                class="w-4 h-4 rounded-full bg-teal-500 border-2 border-teal-200 animate-pulse">
                                            </div>
                                            <span
                                                class="text-[8px] mt-1 font-bold text-teal-600 uppercase tracking-tight">Finance</span>
                                        </div>
                                        <div class="w-6 h-0.5 bg-gray-200"></div>
                                        <div class="flex flex-col items-center opacity-30">
                                            <div class="w-4 h-4 rounded-full bg-gray-300"></div>
                                            <span
                                                class="text-[8px] mt-1 font-bold text-gray-400 uppercase tracking-tight">Payé</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <a href="{{ route('prestataire.interventions.details', $intervention->id) }}"
                                        class="text-teal-600 hover:text-white hover:bg-teal-600 border border-teal-200 px-3 py-1.5 rounded-lg text-xs font-bold transition-all shadow-sm">
                                        <i class="fas fa-eye mr-1"></i> Suivre
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-university text-2xl text-gray-200"></i>
                                        </div>
                                        <p class="font-bold text-lg text-gray-400">Aucun dossier à la finance.</p>
                                        <p class="text-xs text-gray-400 mt-1">Vos factures validées par l'administration
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