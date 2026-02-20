@extends('admin.layouts.template')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="mx-auto w-full">
            <!-- Header Section -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-[#111827] tracking-tight">Nouvelle Intervention</h1>
                    <p class="text-gray-500 mt-2 text-sm">Créez une nouvelle demande d'intervention et assignez un
                        prestataire.</p>
                </div>
                <a href="{{ route('admin.interventions.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-[#111827] hover:bg-[#111827] hover:text-white hover:border-[#111827] transition-all shadow-sm group">
                    <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> Retour
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <!-- Top Decorative Bar -->
                <div class="h-2 bg-gradient-to-r from-[#111827] via-red-600 to-[#111827]"></div>

                <div class="p-8 md:p-10">
                    <form action="{{ route('admin.interventions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        <!-- Top Section: Identification & Affectation Side-by-Side -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 border-b border-gray-100 pb-10">

                            <!-- Left Column: Identification -->
                            <div>
                                <h3 class="text-xl font-bold text-[#111827] mb-6 flex items-center">
                                    <span
                                        class="bg-[#111827] text-white w-10 h-10 flex items-center justify-center rounded-lg mr-3 shadow-lg shadow-gray-200">
                                        <i class="fas fa-fingerprint"></i>
                                    </span>
                                    Identification
                                </h3>

                                <div class="space-y-6">
                                    <!-- Code -->
                                    <div>
                                        <label for="code" class="block text-sm font-bold text-[#111827] mb-2">Numéro de ticket JIRA</label>
                                        <div class="relative group">
                                            <input type="text" name="code" id="code" value="EQUINIX-{{ old('code') }}"
                                                class="w-full pl-4 pr-10 py-3.5 rounded-xl border-gray-300 focus:border-red-600 focus:ring-0 transition-all bg-gray-50 focus:bg-white text-[#111827] font-medium placeholder-gray-400 group-hover:bg-white"
                                                placeholder="Ex: EQUINIX-12345" required>
                                            <div
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-red-500">
                                                <i class="fas fa-barcode"></i>
                                            </div>
                                        </div>
                                        @error('code')
                                            <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Libellé -->
                                    <div>
                                        <label for="libelle" class="block text-sm font-bold text-[#111827] mb-2">Libellé /
                                            Titre</label>
                                        <div class="relative group">
                                            <input type="text" name="libelle" id="libelle" value="{{ old('libelle') }}"
                                                class="w-full pl-4 pr-10 py-3.5 rounded-xl border-gray-300 focus:border-red-600 focus:ring-0 transition-all bg-gray-50 focus:bg-white text-[#111827] font-medium placeholder-gray-400 group-hover:bg-white"
                                                placeholder="Titre de l'intervention" required>
                                            <div
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-red-500">
                                                <i class="fas fa-tag"></i>
                                            </div>
                                        </div>
                                        @error('libelle')
                                            <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Site -->
                                    <div>
                                        <label for="site_id" class="block text-sm font-bold text-[#111827] mb-2">Site concerné</label>
                                        <div class="relative group">
                                            <select name="site_id" id="site_id"
                                                class="w-full pl-4 pr-10 py-3.5 rounded-xl border-gray-300 focus:border-red-600 focus:ring-0 transition-all bg-gray-50 focus:bg-white text-[#111827] font-medium appearance-none cursor-pointer group-hover:bg-white"
                                                required>
                                                <option value="" class="text-gray-500">Sélectionnez un site...</option>
                                                @foreach ($sites as $site)
                                                    <option value="{{ $site->id }}" {{ old('site_id') == $site->id ? 'selected' : '' }}>
                                                        {{ $site->name }} ({{ $site->code }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-red-500">
                                                <i class="fas fa-map-marker-alt text-xs"></i>
                                            </div>
                                        </div>
                                        @error('site_id')
                                            <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Affectation -->
                            <div class="lg:border-l lg:border-gray-100 lg:pl-10">
                                <h3 class="text-xl font-bold text-[#111827] mb-6 flex items-center">
                                    <span
                                        class="bg-[#111827] text-white w-10 h-10 flex items-center justify-center rounded-lg mr-3 shadow-lg shadow-gray-200">
                                        <i class="fas fa-users"></i>
                                    </span>
                                    Affectation
                                </h3>

                                <!-- Prestataire -->
                                <div>
                                    <label for="prestataire_id" class="block text-sm font-bold text-[#111827] mb-2">Prestataire assigné</label>
                                    <div class="relative group">
                                        <select name="prestataire_id" id="prestataire_id"
                                            class="w-full pl-4 pr-10 py-3.5 rounded-xl border-gray-300 focus:border-red-600 focus:ring-0 transition-all bg-gray-50 focus:bg-white text-[#111827] font-medium appearance-none cursor-pointer group-hover:bg-white"
                                            required>
                                            <option value="" class="text-gray-500">Sélectionnez un prestataire...</option>
                                            @foreach ($prestataires as $prestataire)
                                                <option value="{{ $prestataire->id }}" {{ old('prestataire_id') == $prestataire->id ? 'selected' : '' }}>
                                                    {{ $prestataire->name }} {{ $prestataire->prenom }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-red-500">
                                            <i class="fas fa-user-tie text-xs"></i>
                                        </div>
                                    </div>
                                    @error('prestataire_id')
                                        <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Forfait Selection -->
                                <div class="mt-6">
                                    <label for="forfait_id" class="block text-sm font-bold text-[#111827] mb-2">Forfait (Optionnel)</label>
                                    <div class="relative group">
                                        <select name="forfait_id" id="forfait_id"
                                            class="w-full pl-4 pr-10 py-3.5 rounded-xl border-gray-300 focus:border-red-600 focus:ring-0 transition-all bg-gray-50 focus:bg-white text-[#111827] font-medium appearance-none cursor-pointer group-hover:bg-white">
                                            <option value="" class="text-gray-500">Aucun forfait (Saisie libre)</option>
                                            @foreach ($forfaits as $forfait)
                                                <option value="{{ $forfait->id }}" data-price="{{ $forfait->price }}" {{ old('forfait_id') == $forfait->id ? 'selected' : '' }}>
                                                    {{ $forfait->name }} : {{ $forfait->label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-red-500">
                                            <i class="fas fa-tag text-xs"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Montant -->
                                @if(Auth::user()->role === 'admin')
                                <div class="mt-6">
                                    <label for="montant" class="block text-sm font-bold text-[#111827] mb-2">Montant H.T par agent (€)</label>
                                    <div class="relative group">
                                        <input type="number" step="0.01" name="montant" id="montant" value="{{ old('montant') }}"
                                            class="w-full pl-4 pr-10 py-3.5 rounded-xl border-gray-300 focus:border-red-600 focus:ring-0 transition-all bg-gray-50 focus:bg-white text-[#111827] font-medium placeholder-gray-400 group-hover:bg-white"
                                            placeholder="Ex: 490.00" readonly>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-red-500">
                                            <i class="fas fa-euro-sign text-xs"></i>
                                        </div>
                                    </div>
                                    @error('montant')
                                        <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p>
                                    @enderror
                                </div>
                                @else
                                <input type="hidden" name="montant" id="montant" value="{{ old('montant') }}">
                                @endif

                                <!-- Date Fields -->
                                <div class="grid grid-cols-2 gap-4 mt-6">
                                    <div>
                                        <label for="date_debut" class="block text-sm font-bold text-[#111827] mb-2">Date de
                                            début</label>
                                        <div class="relative group">
                                            <input type="date" name="date_debut" id="date_debut"
                                                value="{{ old('date_debut') }}"
                                                class="w-full pl-4 pr-4 py-3.5 rounded-xl border-gray-300 focus:border-red-600 focus:ring-0 transition-all bg-gray-50 focus:bg-white text-[#111827] font-medium placeholder-gray-400 group-hover:bg-white">
                                        </div>
                                        @error('date_debut')
                                            <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="date_fin" class="block text-sm font-bold text-[#111827] mb-2">Date de
                                            fin</label>
                                        <div class="relative group">
                                            <input type="date" name="date_fin" id="date_fin" value="{{ old('date_fin') }}"
                                                class="w-full pl-4 pr-4 py-3.5 rounded-xl border-gray-300 focus:border-red-600 focus:ring-0 transition-all bg-gray-50 focus:bg-white text-[#111827] font-medium placeholder-gray-400 group-hover:bg-white">
                                        </div>
                                        @error('date_fin')
                                            <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Forfait Tasks Section (Hidden) -->
                        <div id="forfait-tasks-hidden-container"></div>

                        <!-- Full Width Section: Détails -->
                        <div>
                            <h3 class="text-xl font-bold text-[#111827] mb-6 flex items-center">
                                <span
                                    class="bg-[#111827] text-white w-10 h-10 flex items-center justify-center rounded-lg mr-3 shadow-lg shadow-gray-200">
                                    <i class="fas fa-align-left"></i>
                                </span>
                                Détails de la mission
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                                <div>
                                    <label for="description" class="block text-sm font-bold text-[#111827] mb-2">Description
                                        complète</label>
                                    <textarea name="description" id="description" rows="6"
                                        class="w-full p-4 rounded-xl border-gray-300 focus:border-red-600 focus:ring-0 transition-all bg-gray-50 focus:bg-white text-[#111827] font-medium placeholder-gray-400 resize-y"
                                        placeholder="Décrivez les détails de l'intervention, les contraintes, le lieu, etc...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-6">
                                    <div id="documents-container" class="space-y-4">
                                        <div class="document-row">
                                            <label class="block text-sm font-bold text-[#111827] mb-2 flex items-center justify-between">
                                                <span>Documents joints (Images, PDF, Excel)</span>
                                                <button type="button" onclick="addDocumentRow()" class="text-xs bg-[#111827] text-white px-2 py-1 rounded-lg hover:bg-red-600 transition-colors">
                                                    <i class="fas fa-plus mr-1"></i> Ajouter
                                                </button>
                                            </label>
                                            <div class="relative group">
                                                <input type="file" name="documents[]" class="w-full pl-4 pr-10 py-3 rounded-xl border border-gray-300 focus:border-red-600 focus:ring-0 transition-all bg-gray-50 focus:bg-white text-[#111827] font-medium group-hover:bg-white" accept="image/*,.pdf,.xls,.xlsx">
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-red-500">
                                                    <i class="fas fa-file-upload"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-[10px] text-gray-400 italic mt-2">Max 10Mo par fichier. Formats : JPG, PNG, PDF, Excel.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                            <span class="text-xs text-gray-400 italic hidden sm:block">* Tous les champs marqués sont
                                obligatoires</span>
                            <div class="flex items-center space-x-4 ml-auto sm:ml-0">
                                <a href="{{ route('admin.interventions.index') }}"
                                    class="px-6 py-3 rounded-xl text-[#111827] bg-white border border-gray-200 hover:bg-gray-50 hover:border-gray-300 transition-all font-bold text-sm">
                                    Annuler
                                </a>
                                <button type="submit"
                                    class="px-8 py-3 bg-[#111827] text-white font-bold rounded-xl shadow-lg shadow-gray-400 hover:bg-red-600 hover:shadow-red-200 hover:-translate-y-0.5 transition-all duration-300 flex items-center text-sm">
                                    <i class="fas fa-paper-plane mr-2"></i> Enregistrer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const forfaits = @json($forfaits);
        const forfaitSelect = document.getElementById('forfait_id');
        const tasksList = document.getElementById('forfait-tasks-hidden-container');
        const montantInput = document.getElementById('montant');

        function updateTasks() {
            const selectedId = forfaitSelect.value;
            const selectedForfait = forfaits.find(f => f.id == selectedId);

            if (selectedForfait) {
                // Update montant
                montantInput.value = selectedForfait.price;

                // Build hidden tasks inputs
                let tasksHtml = '';
                selectedForfait.tasks.forEach(task => {
                    tasksHtml += `<input type="hidden" name="forfait_task_ids[]" value="${task.id}">`;
                });
                tasksList.innerHTML = tasksHtml;
            } else {
                tasksList.innerHTML = '';
            }
        }

        forfaitSelect.addEventListener('change', updateTasks);

        // Initialize if old value exists
        if (forfaitSelect.value) {
            updateTasks();
        }
    });

    function addDocumentRow() {
        const container = document.getElementById('documents-container');
        const newRow = document.createElement('div');
        newRow.className = 'document-row mt-4 pt-4 border-t border-gray-50';
        newRow.innerHTML = `
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-bold text-[#111827]">Document supplémentaire</span>
                <button type="button" onclick="this.closest('.document-row').remove()" class="text-[10px] text-red-600 hover:text-red-800 font-bold">
                    <i class="fas fa-times mr-1"></i> Retirer
                </button>
            </div>
            <div class="relative group">
                <input type="file" name="documents[]" class="w-full pl-4 pr-10 py-3 rounded-xl border border-gray-300 focus:border-red-600 focus:ring-0 transition-all bg-gray-50 focus:bg-white text-[#111827] font-medium group-hover:bg-white" accept="image/*,.pdf,.xls,.xlsx">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-red-500">
                    <i class="fas fa-file-upload"></i>
                </div>
            </div>
        `;
        container.appendChild(newRow);
    }
</script>
@endpush