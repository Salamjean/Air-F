@extends('admin.layouts.template')

@section('content')
    <div class="container mx-auto px-6 py-10">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 gap-6">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Interventions Accordées</h1>
                <p class="text-lg text-gray-600 mt-2">Liste des interventions ayant reçu un accord de la part d'un
                    responsable.</p>
            </div>

            <!-- Search Bar -->
            <div class="w-full md:w-auto relative">
                <form action="{{ route('admin.interventions.accordees') }}" method="GET" class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 group-focus-within:text-green-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="pl-10 pr-4 py-3 w-full md:w-80 bg-white border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300 placeholder-gray-400 text-gray-700"
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
                            class="bg-green-50/50 border-b border-gray-100 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Référence</th>
                            <th class="px-6 py-4">Libellé</th>
                            <th class="px-6 py-4">Prestataire</th>
                            <th class="px-6 py-4">Période</th>
                            <th class="px-6 py-4">Responsable</th>
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
                                    @if($intervention->responsable)
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-6 h-6 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-xs font-bold">
                                                {{ substr($intervention->responsable->name, 0, 1) }}{{ substr($intervention->responsable->prenom, 0, 1) }}
                                            </div>
                                            <span class="text-sm text-gray-700">
                                                {{ $intervention->responsable->name . ' ' . $intervention->responsable->prenom }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Non renseigné</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                                        <i class="fas fa-check-circle text-green-500"></i> Accordée
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- <button type="button" onclick="openFinanceModal({{ $intervention->id }})"
                                            class="inline-flex items-center justify-center px-3 py-1.5 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-lg transition-colors text-xs font-semibold"
                                            title="Envoyer à la finance">
                                            <i class="fas fa-money-bill-wave mr-1.5"></i> Financer
                                        </button> -->
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
                                            <i class="fas fa-check-double text-2xl text-gray-300"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900">Aucune intervention accordée</h3>
                                        <p class="text-gray-500 mt-1 max-w-sm text-sm">Les interventions ayant reçu un accord
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
    <!-- Finance Modal -->
    <div id="financeModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeFinanceModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="financeForm" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-money-bill-wave text-yellow-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                                    Envoyer à la finance
                                </h3>
                                <div class="mt-4">
                                    <label for="financier_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Sélectionner un financier
                                    </label>
                                    <select name="financier_id" id="financier_id" required
                                        class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all">
                                        <option value="" disabled selected>Choisir un financier...</option>
                                        @foreach($financiers as $financier)
                                            <option value="{{ $financier->id }}">
                                                {{ $financier->name }} {{ $financier->prenom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:w-auto sm:text-sm transition-all">
                            Confirmer l'envoi
                        </button>
                        <button type="button" onclick="closeFinanceModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm transition-all">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openFinanceModal(interventionId) {
            const modal = document.getElementById('financeModal');
            const form = document.getElementById('financeForm');
            form.action = `/admin/interventions/${interventionId}/assign-finance`;
            modal.classList.remove('hidden');
        }

        function closeFinanceModal() {
            const modal = document.getElementById('financeModal');
            modal.classList.add('hidden');
        }
    </script>
@endsection