@extends('admin.layouts.template')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="mx-auto w-full">
            <!-- Header Section -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-[#111827] tracking-tight">Modifier l'Intervention</h1>
                    <p class="text-gray-500 mt-2 text-sm">Modifiez les informations de l'intervention <span
                            class="font-mono text-[#111827] bg-gray-100 px-2 py-0.5 rounded">{{ $intervention->reference }}</span>
                    </p>
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
                    <form action="{{ route('admin.interventions.update', $intervention) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')

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
                                        <label for="code" class="block text-sm font-bold text-[#111827] mb-2">Code
                                            interne</label>
                                        <div class="relative group">
                                            <input type="text" name="code" id="code"
                                                value="{{ old('code', $intervention->code) }}"
                                                class="w-full pl-4 pr-10 py-3.5 rounded-xl border-gray-300 focus:border-red-600 focus:ring-0 transition-all bg-gray-50 focus:bg-white text-[#111827] font-medium placeholder-gray-400 group-hover:bg-white"
                                                placeholder="Ex: INT-2024-001" required>
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
                                            <input type="text" name="libelle" id="libelle"
                                                value="{{ old('libelle', $intervention->libelle) }}"
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
                                        <label for="site_id" class="block text-sm font-bold text-[#111827] mb-2">Site
                                            concerné</label>
                                        <div class="relative group">
                                            <select name="site_id" id="site_id"
                                                class="w-full pl-4 pr-10 py-3.5 rounded-xl border-gray-300 focus:border-red-600 focus:ring-0 transition-all bg-gray-50 focus:bg-white text-[#111827] font-medium appearance-none cursor-pointer group-hover:bg-white"
                                                required>
                                                <option value="" class="text-gray-500">Sélectionnez un site...</option>
                                                @foreach ($sites as $site)
                                                    <option value="{{ $site->id }}" {{ old('site_id', $intervention->site_id) == $site->id ? 'selected' : '' }}>
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
                                                <option value="{{ $prestataire->id }}" {{ old('prestataire_id', $intervention->prestataire_id) == $prestataire->id ? 'selected' : '' }}>
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
                                                <option value="{{ $forfait->id }}" data-price="{{ $forfait->price }}" {{ old('forfait_id', $intervention->forfait_id) == $forfait->id ? 'selected' : '' }}>
                                                    {{ $forfait->name }} : {{ $forfait->label }} ({{ number_format($forfait->price, 0, ',', ' ') }} €)
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-red-500">
                                            <i class="fas fa-tag text-xs"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Montant -->
                                <div class="mt-6">
                                    <label for="montant" class="block text-sm font-bold text-[#111827] mb-2">Montant H.T par agent (€)</label>
                                    <div class="relative group">
                                        <input type="number" step="0.01" name="montant" id="montant" value="{{ old('montant', number_format($intervention->montant, 0, ',', ' ')) }}"
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

                                <!-- Date Fields -->
                                <div class="grid grid-cols-2 gap-4 mt-6">
                                    <div>
                                        <label for="date_debut" class="block text-sm font-bold text-[#111827] mb-2">Date de début</label>
                                        <div class="relative group">
                                            <input type="date" name="date_debut" id="date_debut"
                                                value="{{ old('date_debut', $intervention->date_debut) }}"
                                                class="w-full pl-4 pr-4 py-3.5 rounded-xl border-gray-300 focus:border-red-600 focus:ring-0 transition-all bg-gray-50 focus:bg-white text-[#111827] font-medium placeholder-gray-400 group-hover:bg-white">
                                        </div>
                                        @error('date_debut')
                                            <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="date_fin" class="block text-sm font-bold text-[#111827] mb-2">Date de fin</label>
                                        <div class="relative group">
                                            <input type="date" name="date_fin" id="date_fin"
                                                value="{{ old('date_fin', $intervention->date_fin) }}"
                                                class="w-full pl-4 pr-4 py-3.5 rounded-xl border-gray-300 focus:border-red-600 focus:ring-0 transition-all bg-gray-50 focus:bg-white text-[#111827] font-medium placeholder-gray-400 group-hover:bg-white">
                                        </div>
                                        @error('date_fin')
                                            <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
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
                            placeholder="Décrivez les détails de l'intervention, les contraintes, le lieu, etc...">{{ old('description', $intervention->description) }}</textarea>
                        @error('description')
                            <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                        <div id="documents-container" class="space-y-6">
                            <!-- Legacy Documents (Old columns) -->
                            @if($intervention->document_1 || $intervention->document_2)
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                    <h4 class="text-xs font-bold text-gray-500 uppercase mb-3 px-1">Documents Hérités</h4>
                                    <div class="space-y-2">
                                        @if($intervention->document_1)
                                            <div class="flex items-center justify-between bg-white p-2 rounded-lg border border-gray-100">
                                                <span class="text-sm text-gray-700 truncate mr-4"><i class="fas fa-file-alt mr-2 text-gray-400"></i>Document 1</span>
                                                <a href="{{ asset('storage/' . $intervention->document_1) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-xs font-bold whitespace-nowrap">
                                                    <i class="fas fa-download mr-1"></i> Ouvrir
                                                </a>
                                            </div>
                                        @endif
                                        @if($intervention->document_2)
                                            <div class="flex items-center justify-between bg-white p-2 rounded-lg border border-gray-100">
                                                <span class="text-sm text-gray-700 truncate mr-4"><i class="fas fa-file-alt mr-2 text-gray-400"></i>Document 2</span>
                                                <a href="{{ asset('storage/' . $intervention->document_2) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-xs font-bold whitespace-nowrap">
                                                    <i class="fas fa-download mr-1"></i> Ouvrir
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- New Documents (Multiple) -->
                            @if($intervention->documents->count() > 0)
                                <div class="bg-indigo-50/50 p-4 rounded-xl border border-indigo-100">
                                    <h4 class="text-xs font-bold text-indigo-500 uppercase mb-3 px-1">Documents Enregistrés</h4>
                                    <div class="space-y-2">
                                        @foreach($intervention->documents as $doc)
                                            <div class="flex items-center justify-between bg-white p-2 rounded-lg border border-indigo-50">
                                                <span class="text-sm text-gray-700 truncate mr-4" title="{{ $doc->original_name }}">
                                                    <i class="fas fa-file-{{ in_array($doc->file_type, ['jpg', 'jpeg', 'png']) ? 'image' : (in_array($doc->file_type, ['xls', 'xlsx']) ? 'excel' : 'pdf') }} mr-2 text-indigo-400"></i>
                                                    {{ $doc->original_name }}
                                                </span>
                                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 text-xs font-bold whitespace-nowrap">
                                                    <i class="fas fa-download mr-1"></i> Ouvrir
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Add New Documents -->
                            <div class="document-row">
                                <label class="block text-sm font-bold text-[#111827] mb-2 flex items-center justify-between">
                                    <span>Nouveaux documents à joindre</span>
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
                        <p class="text-[10px] text-gray-400 italic mt-6 text-center md:text-left">Max 10Mo par fichier. Formats : JPG, PNG, PDF, Excel.</p>
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
                        <i class="fas fa-save mr-2"></i> Mettre à jour
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
        document.addEventListener('DOMContentLoaded', function () {
            const forfaits = @json($forfaits);
            const selectedTaskIds = @json($intervention->forfaitTasks->pluck('id'));
            const forfaitSelect = document.getElementById('forfait_id');
            const tasksList = document.getElementById('forfait-tasks-hidden-container');
            const montantInput = document.getElementById('montant');

            function updateTasks() {
                const selectedId = forfaitSelect.value;
                const selectedForfait = forfaits.find(f => f.id == selectedId);

                if (selectedForfait) {
                    // Build hidden tasks inputs
                    let tasksHtml = '';
                    selectedForfait.tasks.forEach(task => {
                        let checkedStr = 'checked';
                        if (selectedId == "{{ $intervention->forfait_id }}") {
                            checkedStr = selectedTaskIds.includes(task.id) ? 'checked' : '';
                        }
                        
                        if (checkedStr === 'checked') {
                            tasksHtml += `<input type="hidden" name="forfait_task_ids[]" value="${task.id}">`;
                        }
                    });
                    tasksList.innerHTML = tasksHtml;
                } else {
                    tasksList.innerHTML = '';
                }
            }

            forfaitSelect.addEventListener('change', function () {
                const selectedId = forfaitSelect.value;
                const selectedForfait = forfaits.find(f => f.id == selectedId);
                if (selectedForfait) {
                    montantInput.value = selectedForfait.price;
                }
                updateTasks();
            });

            // Initialize
            updateTasks();
        });

        function addDocumentRow() {
            const container = document.getElementById('documents-container');
            const newRow = document.createElement('div');
            newRow.className = 'document-row mt-4 pt-4 border-t border-gray-100';
            newRow.innerHTML = `
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-bold text-[#111827]">Nouveau document</span>
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