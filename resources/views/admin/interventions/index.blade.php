@extends('admin.layouts.template')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="mx-auto w-full">
            <!-- Header Section -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-[#111827] tracking-tight">Gestion des Interventions</h1>
                    <p class="text-gray-500 mt-2 text-sm">Consultez et gérez toutes les demandes d'interventions.</p>
                </div>
                <a href="{{ route('admin.interventions.create') }}"
                    class="inline-flex items-center px-6 py-3 bg-[#111827] text-white font-bold rounded-xl shadow-lg shadow-gray-400 hover:bg-red-600 hover:shadow-red-200 hover:-translate-y-0.5 transition-all duration-300 text-sm group">
                    <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform duration-300"></i> Nouvelle
                    Demande
                </a>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Interventions</p>
                        <p class="text-2xl font-bold text-[#111827] mt-1">{{ $total }}</p>
                    </div>
                    <div class="p-3 bg-gray-100 text-gray-600 rounded-xl">
                        <i class="fas fa-list-ul text-xl"></i>
                    </div>
                </div>

                <!-- En Attente -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">En Attente</p>
                        <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $en_attente }}</p>
                    </div>
                    <div class="p-3 bg-yellow-50 text-yellow-600 rounded-xl">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                </div>

                <!-- Validée -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Validées</p>
                        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $valider }}</p>
                    </div>
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                </div>

                <!-- Terminée -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Terminées</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">{{ $terminer }}</p>
                    </div>
                    <div class="p-3 bg-green-50 text-green-600 rounded-xl">
                        <i class="fas fa-flag-checkered text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
                <form action="{{ route('admin.interventions.index') }}" method="GET"
                    class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end">

                    <!-- Search Input -->
                    <div>
                        <label for="search"
                            class="block text-xs font-bold text-gray-500 mb-1 uppercase text-center">Recherche</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Code ou Ref..."
                            class="w-full rounded-lg border-gray-200 text-sm text-center focus:border-[#111827] focus:ring-0 placeholder-gray-400">
                    </div>
                    <!-- Status Filter -->
                    <div>
                        <label for="statut"
                            class="block text-xs font-bold text-gray-500 mb-1 uppercase text-center">Statut</label>
                        <select name="statut" id="statut"
                            class="w-full rounded-lg border-gray-200 text-sm text-center focus:border-[#111827] focus:ring-0">
                            <option value="">Tous les statuts</option>
                            <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente
                            </option>
                            <option value="valider" {{ request('statut') == 'valider' ? 'selected' : '' }}>Validée</option>
                            <option value="traiter" {{ request('statut') == 'traiter' ? 'selected' : '' }}>En cours</option>
                            <option value="terminer" {{ request('statut') == 'terminer' ? 'selected' : '' }}>Terminée</option>
                            <option value="rejeter" {{ request('statut') == 'rejeter' ? 'selected' : '' }}>Rejetée</option>
                        </select>
                    </div>

                    <!-- Prestataire Filter -->
                    <div>
                        <label for="prestataire_id"
                            class="block text-xs font-bold text-gray-500 mb-1 uppercase text-center">Prestataire</label>
                        <select name="prestataire_id" id="prestataire_id"
                            class="w-full rounded-lg border-gray-200 text-sm text-center focus:border-[#111827] focus:ring-0">
                            <option value="">Tous les prestataires</option>
                            @foreach($prestataires as $p)
                                <option value="{{ $p->id }}" {{ request('prestataire_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }} {{ $p->prenom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date Debut Filter -->
                    <div>
                        <label for="date_debut"
                            class="block text-xs font-bold text-gray-500 mb-1 uppercase text-center">Date
                            min</label>
                        <input type="date" name="date_debut" id="date_debut" value="{{ request('date_debut') }}"
                            class="w-full rounded-lg border-gray-200 text-sm text-center focus:border-[#111827] focus:ring-0">
                    </div>

                    <!-- Date Fin Filter -->
                    <div>
                        <label for="date_fin" class="block text-xs font-bold text-gray-500 mb-1 uppercase text-center">Date
                            max</label>
                        <input type="date" name="date_fin" id="date_fin" value="{{ request('date_fin') }}"
                            class="w-full rounded-lg border-gray-200 text-sm text-center focus:border-[#111827] focus:ring-0">
                    </div>

                    <!-- Actions -->
                    <div class="text-center">
                        <button type="submit"
                            class="w-40 px-4 py-2 bg-[#111827] text-center text-white rounded-lg text-sm font-bold hover:bg-gray-900 transition-colors">
                            <i class="fas fa-filter mr-2"></i> Filtrer
                        </button>
                    </div>
                </form>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <!-- Top Decorative Bar -->
                <div class="h-2 bg-gradient-to-r from-[#111827] via-red-600 to-[#111827]"></div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Enregistré par</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Référence / Code</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Libellé</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Prestataire</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Période</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Statut</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($interventions as $intervention)
                                <tr class="hover:bg-gray-50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#111827]">{{ $intervention->admin->name }}
                                                {{ $intervention->admin->prenom }}</span>
                                            <span
                                                class="text-xs text-gray-500 font-mono">{{ $intervention->admin->email }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#111827]">{{ $intervention->reference }}</span>
                                            <span class="text-xs text-gray-500 font-mono">{{ $intervention->code }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="text-sm font-medium text-gray-900">{{ $intervention->libelle }}</div>
                                        <div class="text-xs text-gray-500 truncate max-w-xs">
                                            {{ Str::limit($intervention->description, 50) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center"
                                        style="display: flex; align-items: center; justify-content: center;">
                                        @if($intervention->prestataire)
                                            <div class="flex items-center">
                                                <div
                                                    class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 text-xs font-bold mr-3 uppercase">
                                                    {{ substr($intervention->prestataire->name, 0, 2) }}
                                                </div>
                                                <div class="text-sm text-gray-900 font-medium text-center">
                                                    {{ $intervention->prestataire->name }} {{ $intervention->prestataire->prenom }}
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-xs italic text-gray-400">Non assigné</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex flex-col text-sm text-gray-600"
                                            style="display: flex; align-items: center; justify-content: center;">
                                            <span class="flex items-center"><i
                                                    class="fas fa-calendar-alt text-gray-400 mr-2 w-4"></i>
                                                {{ $intervention->date_debut ? \Carbon\Carbon::parse($intervention->date_debut)->format('d/m/Y') : 'N/A' }}</span>
                                            <span class="flex items-center mt-1"><i
                                                    class="fas fa-flag-checkered text-gray-400 mr-2 w-4"></i>
                                                {{ $intervention->date_fin ? \Carbon\Carbon::parse($intervention->date_fin)->format('d/m/Y') : 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @php
                                            $statusClasses = [
                                                'en_attente' => 'bg-yellow-100 text-yellow-800',
                                                'valider' => 'bg-blue-100 text-blue-800',
                                                'traiter' => 'bg-purple-100 text-purple-800',
                                                'terminer' => 'bg-green-100 text-green-800',
                                                'rejeter' => 'bg-red-100 text-red-800',
                                            ];
                                            $statusLabels = [
                                                'en_attente' => 'En attente',
                                                'valider' => 'Validée',
                                                'traiter' => 'En cours',
                                                'terminer' => 'Terminée',
                                                'rejeter' => 'Rejetée',
                                            ];
                                            $currentClass = $statusClasses[$intervention->statut] ?? 'bg-gray-100 text-gray-800';
                                            $currentLabel = $statusLabels[$intervention->statut] ?? ucfirst(str_replace('_', ' ', $intervention->statut));
                                        @endphp
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $currentClass }}">
                                            {{ $currentLabel }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center space-x-2 transition-opacity">
                                            <a href="{{ route('admin.interventions.details', $intervention->id) }}"
                                                class="text-blue-600 hover:text-blue-900 p-2 hover:bg-blue-50 rounded-lg transition-colors"
                                                title="Détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.interventions.edit', $intervention) }}"
                                                class="text-yellow-600 hover:text-yellow-900 p-2 hover:bg-yellow-50 rounded-lg transition-colors"
                                                title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.interventions.destroy', $intervention) }}"
                                                method="POST" class="inline"
                                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette intervention ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 p-2 hover:bg-red-50 rounded-lg transition-colors"
                                                    title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <div class="bg-gray-50 rounded-full p-4 mb-4">
                                                <i class="fas fa-folder-open text-3xl"></i>
                                            </div>
                                            <p class="text-lg font-medium text-gray-900">Aucune intervention trouvée</p>
                                            <p class="text-sm mt-1">Commencez par créer une nouvelle demande d'intervention.</p>
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