@extends('prestataire.layouts.template')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Interventions Validées</h1>
                <p class="text-gray-600 mt-2">Liste de vos interventions en cours ou validées.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <form action="{{ route('prestataire.interventions.valider') }}" method="GET" class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full md:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
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
                                (EURO)</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Dates
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Statut
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($interventions as $intervention)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-bold text-gray-800">{{ $intervention->reference }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $intervention->libelle }}</div>
                                    <div class="text-xs text-gray-500 truncate max-w-xs">
                                        {{ Str::limit($intervention->description, 50) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="font-bold text-gray-800">{{ number_format($intervention->montant, 0, ',', ' ') }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <div>Du: <span
                                            class="font-medium">{{ \Carbon\Carbon::parse($intervention->date_debut)->format('d/m/Y') }}</span>
                                    </div>
                                    <div>Au: <span
                                            class="font-medium">{{ \Carbon\Carbon::parse($intervention->date_fin)->format('d/m/Y') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                    <!-- Updated align to left or right as needed, keeping consistent -->
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-blue-100 text-blue-800">
                                        Validée
                                    </span>
                                    <a href="{{ route('prestataire.interventions.details', $intervention->id) }}"
                                        class="text-gray-500 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors inline-block ml-2">
                                        <i class="fas fa-eye mr-1"></i> Détails
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-clipboard-check text-4xl mb-3 text-gray-300"></i>
                                    <p>Aucune intervention validée.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection