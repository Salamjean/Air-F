@extends('prestataire.layouts.template')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Interventions Rejetées</h1>
                <p class="text-gray-600 mt-2">Historique des demandes refusées.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <form action="{{ route('prestataire.interventions.rejeter') }}" method="GET" class="relative">
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
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Dates
                                Proposées</th>
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    @if($intervention->date_debut && $intervention->date_fin)
                                        <div>Du: <span
                                                class="font-medium">{{ \Carbon\Carbon::parse($intervention->date_debut)->format('d/m/Y') }}</span>
                                        </div>
                                        <div>Au: <span
                                                class="font-medium">{{ \Carbon\Carbon::parse($intervention->date_fin)->format('d/m/Y') }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic">Non définies</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800">
                                        Rejetée
                                    </span>
                                    <a href="{{ route('prestataire.interventions.details', $intervention->id) }}"
                                        class="text-gray-500 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors inline-block ml-2">
                                        <i class="fas fa-eye mr-1"></i> Détails
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-ban text-4xl mb-3 text-gray-300"></i>
                                    <p>Aucune intervention rejetée.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection