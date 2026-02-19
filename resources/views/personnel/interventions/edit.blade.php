@extends('personnel.layouts.template')

@section('content')
    <div class="min-h-screen bg-slate-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="mx-auto" style="width:100%">
            <!-- Breadcrumb / Back Navigation -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <a href="{{ route('personnel.interventions.index') }}"
                    class="group flex items-center text-sm font-medium text-slate-500 hover:text-red-600 transition-colors duration-200">
                    <div
                        class="mr-2 p-1.5 rounded-full bg-slate-200 group-hover:bg-red-100 transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-arrow-left text-xs text-slate-600 group-hover:text-red-600"></i>
                    </div>
                    Retour aux interventions
                </a>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                <!-- Left Column: Mission Information (Sticky) -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="bg-slate-900 px-6 py-4 flex items-center justify-between">
                            <h2 class="text-white font-bold text-lg">Mission</h2>
                            <span
                                class="px-2.5 py-1 rounded-md bg-slate-800 text-slate-300 text-xs font-mono tracking-wider border border-slate-700">
                                {{ $intervention->reference }}
                            </span>
                        </div>

                        <div class="p-6 space-y-6">
                            <!-- Libelle -->
                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1 block">Titre de
                                    la mission</label>
                                <p class="text-lg font-bold text-slate-800 leading-tight">
                                    {{ $intervention->libelle }}
                                </p>
                            </div>

                            <!-- Dates -->
                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 flex flex-col gap-3">
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5 min-w-[1.25rem]">
                                        <i class="far fa-calendar-alt text-red-500"></i>
                                    </div>
                                    <div>
                                        <span class="text-xs text-slate-500 font-medium block">Début prévu</span>
                                        <span class="text-sm font-bold text-slate-800">
                                            {{ \Carbon\Carbon::parse($intervention->date_debut)->translatedFormat('d F Y') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="w-full h-px bg-slate-200"></div>
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5 min-w-[1.25rem]">
                                        <i class="far fa-calendar-check text-red-500"></i>
                                    </div>
                                    <div>
                                        <span class="text-xs text-slate-500 font-medium block">Fin prévue</span>
                                        <span class="text-sm font-bold text-slate-800">
                                            {{ \Carbon\Carbon::parse($intervention->date_fin)->translatedFormat('d F Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label
                                    class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 block">Détails</label>
                                <div
                                    class="text-sm text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-xl border border-slate-100 whitespace-pre-wrap break-words">
                                    {{ $intervention->description }}
                                </div>
                            </div>

                            <!-- Location (if exists) -->
                            @if($intervention->commune)
                                <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                                    <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                                        <i class="fas fa-map-marker-alt text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-slate-700">{{ $intervention->commune }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column: Reporting Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden relative">
                        <!-- Decorative Top Line -->
                        <div
                            class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 via-orange-500 to-yellow-500">
                        </div>

                        <div class="p-8 lg:p-10">
                            <div class="mb-10">
                                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-2">
                                    Compte-rendu</h1>
                                <p class="text-slate-500 text-lg">Veuillez renseigner les détails réels de l'intervention
                                    pour finaliser le traitement.</p>
                            </div>

                            <form action="{{ route('personnel.interventions.update', $intervention->id) }}" method="POST"
                                enctype="multipart/form-data" class="space-y-8">
                                @csrf
                                @method('PUT')

                                <!-- Section: Dates Réelles -->
                                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                                    <h3 class="text-base font-bold text-slate-800 mb-6 flex items-center gap-2">
                                        <i class="fas fa-clock text-red-500"></i> Chronologie Réelle
                                    </h3>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2 group">
                                            <label for="date_debut_reelle"
                                                class="block text-sm font-semibold text-slate-700 group-focus-within:text-red-600 transition-colors">
                                                Début effectif <span class="text-red-500">*</span>
                                            </label>
                                            <input type="datetime-local" name="date_debut_reelle" id="date_debut_reelle"
                                                required
                                                class="block w-full px-4 py-3 rounded-xl border border-slate-300 shadow-sm focus:ring-2 focus:ring-red-500/20 focus:border-red-500 text-slate-900 transition-all duration-200"
                                                value="{{ old('date_debut_reelle', $intervention->date_debut ? \Carbon\Carbon::parse($intervention->date_debut)->format('Y-m-d\T07:30') : '') }}">
                                        </div>

                                        <div class="space-y-2 group">
                                            <label for="date_fin_reelle"
                                                class="block text-sm font-semibold text-slate-700 group-focus-within:text-red-600 transition-colors">
                                                Fin effective <span class="text-red-500">*</span>
                                            </label>
                                            <input type="datetime-local" name="date_fin_reelle" id="date_fin_reelle"
                                                required
                                                class="block w-full px-4 py-3 rounded-xl border border-slate-300 shadow-sm focus:ring-2 focus:ring-red-500/20 focus:border-red-500 text-slate-900 transition-all duration-200"
                                                value="{{ old('date_fin_reelle', $intervention->date_fin ? \Carbon\Carbon::parse($intervention->date_fin)->format('Y-m-d\T17:30') : '') }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Question: Utilisation de consommables -->
                                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                                    <h3 class="text-base font-bold text-slate-800 mb-6 flex items-center gap-2">
                                        <i class="fas fa-question-circle text-blue-500"></i> Avez-vous utilisé des
                                        consommables ?
                                    </h3>
                                    <div class="flex flex-wrap gap-4">
                                        <label
                                            class="flex items-center gap-3 px-4 py-3 rounded-xl border-2 border-slate-200 bg-white cursor-pointer hover:border-red-200 transition-all group flex-1">
                                            <input type="radio" name="used_consommable" id="used_consommable_no" value="no"
                                                checked onclick="toggleConsommables(false)"
                                                class="w-5 h-5 text-red-600 border-slate-300 focus:ring-red-500">
                                            <span class="text-sm font-bold text-slate-700">Non, aucun</span>
                                        </label>
                                        <label
                                            class="flex items-center gap-3 px-4 py-3 rounded-xl border-2 border-slate-200 bg-white cursor-pointer hover:border-green-200 transition-all group flex-1">
                                            <input type="radio" name="used_consommable" id="used_consommable_yes"
                                                value="yes" onclick="toggleConsommables(true)"
                                                class="w-5 h-5 text-green-600 border-slate-300 focus:ring-green-500">
                                            <span class="text-sm font-bold text-slate-700">Oui, j'en ai utilisé</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Section: Equipements Utilisés (Consommables) -->
                                <div id="consommables-section"
                                    class="bg-slate-50 rounded-2xl p-6 border border-slate-100 hidden">
                                    <h3 class="text-base font-bold text-slate-800 mb-6 flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-tools text-red-500"></i> Sélection des Consommables
                                        </div>
                                        <button type="button" onclick="addEquipmentRow()"
                                            class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-1.5 px-3 rounded-lg flex items-center gap-1.5 transition-all shadow-sm">
                                            <i class="fas fa-plus"></i> Ajouter un article
                                        </button>
                                    </h3>

                                    <div id="equipment-container" class="space-y-4">
                                        <div
                                            class="equipment-row grid grid-cols-1 sm:grid-cols-7 gap-4 items-end bg-white p-4 rounded-xl border border-slate-200 shadow-sm relative group">
                                            <div class="sm:col-span-4 space-y-2">
                                                <label
                                                    class="text-xs font-bold text-slate-500 uppercase">Consommable</label>
                                                <select name="equipements[0][id]" id="equipment-select-0"
                                                    class="equipment-select block w-full">
                                                    <option value="">Sélectionner un consommable</option>
                                                    @foreach($equipements as $equip)
                                                        <option value="{{ $equip->id }}">
                                                            {{ $equip->name }} ({{ $equip->longueur }}m)
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="sm:col-span-2 space-y-2">
                                                <label class="text-xs font-bold text-slate-500 uppercase">Quantité
                                                    utilisé</label>
                                                <input type="number" name="equipements[0][quantity]" min="1"
                                                    class="block w-full px-4 py-2.5 h-12 rounded-xl border border-slate-300 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 text-sm transition-all outline-none bg-slate-50"
                                                    placeholder="0">
                                            </div>
                                            <div class="sm:col-span-1 flex justify-center pb-1">
                                                <button type="button"
                                                    onclick="removeEquipmentRow(this, 'equipment-select-0')"
                                                    class="text-slate-400 hover:text-red-600 transition-colors p-2 rounded-full hover:bg-red-50 opacity-100">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-[10px] text-slate-500 mt-4 italic">
                                        Note: Les quantités saisies seront automatiquement déduites du stock lors de la
                                        validation.
                                    </p>
                                </div>

                                <!-- Section: Commentaire -->
                                <div class="space-y-3 group">
                                    <label for="rapport_commentaire"
                                        class="block text-sm font-bold text-slate-800 group-focus-within:text-red-600 transition-colors">
                                        Observations / Rapport d'intervention
                                    </label>
                                    <div class="relative">
                                        <textarea name="rapport_commentaire" id="rapport_commentaire" rows="6"
                                            class="block w-full px-5 py-4 rounded-xl border border-slate-300 shadow-sm focus:ring-2 focus:ring-red-500/20 focus:border-red-500 text-slate-900 transition-all duration-200 resize-none placeholder-slate-400"
                                            placeholder="Détaillez ici les actions effectuées, les problèmes rencontrés, etc...">{{ old('rapport_commentaire') }}</textarea>
                                        <div class="absolute bottom-4 right-4 text-xs text-slate-400 pointer-events-none">
                                            <i class="fas fa-pen"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section: Upload -->
                                <div class="space-y-3">
                                    <label class="block text-sm font-bold text-slate-800">
                                        Document joint (Rapport PDF ou Photo)
                                    </label>

                                    <div class="relative group">
                                        <input type="file" name="rapport_file" id="rapport_file" class="hidden"
                                            accept=".pdf,.jpg,.jpeg,.png" onchange="previewFile(this)">

                                        <label for="rapport_file"
                                            class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-slate-300 rounded-2xl cursor-pointer bg-slate-50 group-hover:bg-red-50/30 group-hover:border-red-400 transition-all duration-300 relative overflow-hidden">

                                            <!-- Default State -->
                                            <div id="upload-placeholder"
                                                class="flex flex-col items-center justify-center pt-5 pb-6 transition-opacity duration-300">
                                                <div
                                                    class="w-16 h-16 mb-4 rounded-full bg-slate-200 flex items-center justify-center group-hover:bg-red-100 group-hover:text-red-600 text-slate-400 transition-colors duration-300 shadow-inner">
                                                    <i class="fas fa-cloud-upload-alt text-2xl"></i>
                                                </div>
                                                <p class="mb-2 text-sm text-slate-700 font-semibold text-center px-4">
                                                    <span class="font-bold underline text-red-600">Cliquez pour
                                                        importer</span> ou glissez-déposez
                                                </p>
                                                <p class="text-xs text-slate-500">PDF, PNG, JPG (Max. 10Mo)</p>
                                            </div>

                                            <!-- Success State -->
                                            <div id="upload-success"
                                                class="absolute inset-0 flex flex-col items-center justify-center bg-green-50/90 opacity-0 transition-opacity duration-300 pointer-events-none">
                                                <div class="w-16 h-16 mb-3 rounded-full bg-green-100 text-green-600 flex items-center justify-center shadow-sm transform scale-90 transition-transform duration-300"
                                                    id="success-icon">
                                                    <i class="fas fa-check text-2xl"></i>
                                                </div>
                                                <p class="text-sm font-bold text-green-800" id="file-name-display"></p>
                                                <p class="text-xs text-green-600 mt-1">Fichier prêt à être envoyé</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Actions Buttons -->
                                <div class="flex items-center justify-end gap-5 pt-8 border-t border-slate-100">
                                    <a href="{{ route('personnel.interventions.index') }}"
                                        class="px-6 py-3.5 rounded-xl text-slate-600 font-bold hover:bg-slate-100 hover:text-slate-900 transition-all duration-200">
                                        Annuler
                                    </a>
                                    <button type="submit"
                                        class="relative overflow-hidden group px-8 py-3.5 bg-gradient-to-br from-red-600 to-red-700 text-white font-bold rounded-xl shadow-lg shadow-red-500/30 hover:shadow-red-500/50 hover:to-red-600 transform hover:-translate-y-0.5 transition-all duration-200">
                                        <span class="relative z-10 flex items-center gap-2">
                                            <span>Soumettre le rapport</span>
                                            <i
                                                class="fas fa-paper-plane group-hover:translate-x-1 transition-transform"></i>
                                        </span>
                                        <div
                                            class="absolute inset-0 bg-white/20 blur opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        </div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
        <style>
            .ts-control {
                border-radius: 0.75rem !important;
                padding: 0.625rem !important;
                border-color: #e5e7eb !important;
                background-color: #f8fafc !important;
            }

            .ts-wrapper.single .ts-control {
                height: 3rem !important;
                display: flex;
                align-items: center;
            }
        </style>

        <script>
            function previewFile(input) {
                const placeholder = document.getElementById('upload-placeholder');
                const success = document.getElementById('upload-success');
                const nameDisplay = document.getElementById('file-name-display');
                const icon = document.getElementById('success-icon');

                if (input.files && input.files[0]) {
                    nameDisplay.textContent = input.files[0].name;
                    placeholder.classList.add('opacity-0');
                    success.classList.remove('opacity-0');
                    icon.classList.remove('scale-90');
                    icon.classList.add('scale-100');
                } else {
                    placeholder.classList.remove('opacity-0');
                    success.classList.add('opacity-0');
                    icon.classList.add('scale-90');
                    icon.classList.remove('scale-100');
                }
            }

            const dropZone = document.querySelector('label[for="rapport_file"]');
            if (dropZone) {
                ['dragenter', 'dragover'].forEach(eventName => dropZone.addEventListener(eventName, () => dropZone.classList.add('bg-red-50', 'border-red-400'), false));
                ['dragleave', 'drop'].forEach(eventName => dropZone.addEventListener(eventName, () => dropZone.classList.remove('bg-red-50', 'border-red-400'), false));
            }

            let equipmentIndex = 1;
            const tomSelects = new Map();

            function initTomSelect(elementId) {
                const ts = new TomSelect(`#${elementId}`, {
                    create: false,
                    sortField: { field: "text", direction: "asc" },
                    placeholder: "Rechercher..."
                });
                tomSelects.set(elementId, ts);
                ts.on('change', () => updateEquipmentOptions());
            }

            function addEquipmentRow() {
                const container = document.getElementById('equipment-container');
                const newRow = document.createElement('div');
                const rowId = `equipment-select-${equipmentIndex}`;
                newRow.className = 'equipment-row grid grid-cols-1 sm:grid-cols-7 gap-4 items-end bg-white p-4 rounded-xl border border-slate-200 shadow-sm relative group animate-in slide-in-from-top-2 duration-300';
                newRow.innerHTML = `
                            <div class="sm:col-span-4 space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase">Consommable</label>
                                <select name="equipements[${equipmentIndex}][id]" id="${rowId}" class="equipment-select block w-full"></select>
                            </div>
                            <div class="sm:col-span-2 space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase">Quantité utilisé</label>
                                <input type="number" name="equipements[${equipmentIndex}][quantity]" min="1" 
                                    class="block w-full px-4 py-2.5 h-12 rounded-xl border border-slate-300 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 text-sm transition-all outline-none bg-slate-50"
                                    placeholder="0">
                            </div>
                            <div class="sm:col-span-1 flex justify-center pb-1">
                                <button type="button" onclick="removeEquipmentRow(this, '${rowId}')" 
                                    class="text-slate-400 hover:text-red-600 transition-colors p-2 rounded-full hover:bg-red-50 opacity-100">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        `;

                // Clone options from first select
                const firstSelect = document.getElementById('equipment-select-0');
                const select = newRow.querySelector('select');
                Array.from(firstSelect.options).forEach(opt => {
                    const newOpt = opt.cloneNode(true);
                    select.appendChild(newOpt);
                });

                container.appendChild(newRow);
                initTomSelect(rowId);
                equipmentIndex++;
                updateEquipmentOptions();
            }

            function removeEquipmentRow(button, rowId) {
                const rows = document.querySelectorAll('.equipment-row');
                if (rows.length > 1) {
                    if (tomSelects.has(rowId)) { tomSelects.get(rowId).destroy(); tomSelects.delete(rowId); }
                    button.closest('.equipment-row').remove();
                    updateEquipmentOptions();
                } else {
                    Swal.fire({ icon: 'info', title: 'Information', text: 'Veuillez au moins renseigner un article ou désactivez l\'utilisation des consommables.', timer: 3000 });
                }
            }

            function updateEquipmentOptions() {
                const selectedValues = Array.from(tomSelects.values()).map(ts => ts.getValue()).filter(val => val !== "");
                tomSelects.forEach((ts) => {
                    const currentValue = ts.getValue();
                    Object.keys(ts.options).forEach(key => {
                        if (key !== "" && selectedValues.includes(key) && key !== currentValue) {
                            ts.updateOption(key, { ...ts.options[key], disabled: true });
                        } else {
                            ts.updateOption(key, { ...ts.options[key], disabled: false });
                        }
                    });
                    ts.refreshOptions(false);
                });
            }

            function toggleConsommables(show) {
                const section = document.getElementById('consommables-section');
                const inputs = section.querySelectorAll('input, select');
                if (show) {
                    section.classList.remove('hidden');
                    inputs.forEach(i => i.disabled = false);
                    if (tomSelects.size === 0) initTomSelect('equipment-select-0');
                } else {
                    section.classList.add('hidden');
                    inputs.forEach(i => i.disabled = true);
                }
            }

            document.addEventListener('DOMContentLoaded', () => {
                const yes = document.getElementById('used_consommable_yes');
                toggleConsommables(yes && yes.checked);
            });
        </script>
    @endpush
@endsection