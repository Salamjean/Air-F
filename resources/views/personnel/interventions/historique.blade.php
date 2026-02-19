@extends('personnel.layouts.template')

@section('content')
    <div class="container mx-auto px-6 py-10">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 gap-6">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Historique des Interventions</h1>
                <p class="text-lg text-gray-600 mt-2">Liste de vos interventions traitées et finalisées.</p>
            </div>

            <!-- Search Bar -->
            <div class="w-full md:w-auto relative">
                <form action="{{ route('personnel.interventions.historique') }}" method="GET" class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 group-focus-within:text-green-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="pl-10 pr-4 py-3 w-full md:w-80 bg-white border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300 placeholder-gray-400 text-gray-700"
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
                        <tr
                            class="bg-green-50/50 border-b border-gray-100 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Référence</th>
                            <th class="px-6 py-4">Libellé</th>
                            <th class="px-6 py-4">Dates Réelles</th>
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
                                            class="text-sm font-bold text-gray-900 group-hover:text-green-600 transition-colors">
                                            {{ $intervention->reference }}
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
                                    <div class="flex flex-col text-xs text-gray-600">
                                        <span class="flex items-center gap-1.5">
                                            <i class="far fa-play-circle text-green-500 w-3"></i>
                                            {{ \Carbon\Carbon::parse($intervention->date_debut_reelle)->format('d/m/Y H:i') }}
                                        </span>
                                        <span class="flex items-center gap-1.5 mt-1">
                                            <i class="far fa-stop-circle text-red-400 w-3"></i>
                                            {{ \Carbon\Carbon::parse($intervention->date_fin_reelle)->format('d/m/Y H:i') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                                        <i class="fas fa-check-circle text-green-500"></i> Traitée
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('personnel.interventions.show', $intervention) }}"
                                            class="inline-flex items-center justify-center w-8 h-8 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 hover:text-green-700 transition-colors"
                                            title="Consulter les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($intervention->rapport_path)
                                            <a href="{{ asset('storage/' . $intervention->rapport_path) }}" target="_blank"
                                                class="inline-flex items-center justify-center w-8 h-8 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-800 transition-colors"
                                                title="Voir le fichier joint">
                                                <i class="fas fa-file-alt"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-clipboard-list text-2xl text-gray-300"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900">Aucune intervention dans l'historique</h3>
                                        <p class="text-gray-500 mt-1 max-w-sm text-sm">Vos interventions traitées apparaîtront
                                            ici.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openReportDetails(comment, start, end) {
            Swal.fire({
                title: 'Détails du Rapport',
                html: `
                                    <div class="text-left space-y-4">
                                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                                            <h4 class="text-xs font-bold text-gray-500 uppercase mb-1">Dates Réelles</h4>
                                            <p class="text-sm text-gray-800">Du <strong>${start}</strong> au <strong>${end}</strong></p>
                                        </div>

                                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                                            <h4 class="text-xs font-bold text-gray-500 uppercase mb-1">Commentaire</h4>
                                            <p class="text-sm text-gray-700 whitespace-pre-wrap">${comment}</p>
                                        </div>
                                    </div>
                                `,
                showConfirmButton: true,
                confirmButtonColor: '#10B981',
                confirmButtonText: 'Fermer',
                width: '500px'
            });
        }
    </script>
@endsection