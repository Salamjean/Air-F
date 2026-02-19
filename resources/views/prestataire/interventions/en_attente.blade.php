@extends('prestataire.layouts.template')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Interventions En Attente</h1>
            <p class="text-gray-600 mt-2">Validez ou refusez vos nouvelles demandes.</p>
        </div>
        <div class="mt-4 md:mt-0">
             <form action="{{ route('prestataire.interventions.en_attente') }}" method="GET" class="relative">
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
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Référence</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Libellé</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Dates</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($interventions as $intervention)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="font-bold text-gray-800">{{ $intervention->reference }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="text-sm font-medium text-gray-900">{{ $intervention->libelle }}</div>
                                <div class="text-xs text-gray-500 truncate max-w-xs">{{ Str::limit($intervention->description, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center" >
                                @if($intervention->date_debut && $intervention->date_fin)
                                    <div>Du: <span class="font-medium">{{ \Carbon\Carbon::parse($intervention->date_debut)->format('d/m/Y') }}</span></div>
                                    <div>Au: <span class="font-medium">{{ \Carbon\Carbon::parse($intervention->date_fin)->format('d/m/Y') }}</span></div>
                                @else
                                    <span class="text-yellow-600 italic"><i class="fas fa-exclamation-triangle mr-1"></i> À définir</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center" style="display:flex; justify-content: center;">
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
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $statusClasses[$intervention->statut] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusLabels[$intervention->statut] ?? $intervention->statut }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                @if($intervention->statut === 'en_attente' || $intervention->statut === 'rejeter') <!-- Permettre re-validation si rejeté ? À voir workflow -->
                                    <button onclick="openValidationModal('{{ $intervention->id }}', '{{ $intervention->reference }}', {{ var_export($intervention->date_debut === null, true) }})" 
                                        class="text-white bg-green-600 hover:bg-green-700 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors mr-2">
                                        <i class="fas fa-check mr-1"></i> Valider
                                    </button>
                                    
                                    <button onclick="openRefusalModal('{{ $intervention->id }}', '{{ $intervention->reference }}')" 
                                        class="text-white bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">
                                        <i class="fas fa-times mr-1"></i> Refuser
                                    </button>
                                     <a href="{{ route('prestataire.interventions.details', $intervention->id) }}" 
                                       class="text-gray-500 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors inline-block ml-2">
                                        <i class="fas fa-eye mr-1"></i> Détails
                                    </a>
                                @else
                                    <a href="{{ route('prestataire.interventions.details', $intervention->id) }}" 
                                       class="text-gray-500 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors inline-block">
                                        <i class="fas fa-eye mr-1"></i> Détails
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                                <p>Aucune intervention assignée pour le moment.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<style>
    .ts-control { border-radius: 0.75rem !important; padding: 0.625rem !important; border-color: #e5e7eb !important; }
    .ts-wrapper.multi .ts-control > div { border-radius: 0.5rem !important; background: #fee2e2 !important; color: #b91c1c !important; font-weight: 600 !important; }
</style>
<script>
    // Pass personnel data to JS
    const availablePersonnel = @json($personnels);

    function openValidationModal(interventionId, reference, needsDates) {
        // Build personnel options
        let personnelOptions = '<option value="">-- Choisir un membre --</option>';
        availablePersonnel.forEach(p => {
            personnelOptions += `<option value="${p.id}">${p.name} ${p.prenom}</option>`;
        });

        let htmlContent = `
            <div class="text-left">
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Assigner au personnel technique</label>
                    <select id="swal-personnel" multiple placeholder="Rechercher et sélectionner du personnel..." autocomplete="off">
                        ${availablePersonnel.map(p => `<option value="${p.id}">${p.name} ${p.prenom}</option>`).join('')}
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Chef d'équipe (Responsable du rapport)</label>
                    <select id="swal-responsible" class="shadow border border-gray-200 rounded-xl w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all">
                        <option value="">-- Sélectionnez d\'abord du personnel --</option>
                    </select>
                </div>
        `;

        // If dates are missing, add fields for them
        if (needsDates) {
            htmlContent += `
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Date de début</label>
                    <input type="date" id="swal-date-debut" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Date de fin</label>
                    <input type="date" id="swal-date-fin" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
            `;
        }

        htmlContent += `</div>`;

        Swal.fire({
            title: 'Valider l\'intervention ' + reference,
            html: htmlContent,
            width: '900px',
            showCancelButton: true,
            confirmButtonText: 'Valider & Assigner',
            cancelButtonText: 'Annuler',
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#d33',
            didOpen: () => {
                const ts = new TomSelect('#swal-personnel', {
                    plugins: ['remove_button'],
                    render: {
                        option: function(data, escape) {
                            return '<div><span class="font-bold">' + escape(data.text) + '</span></div>';
                        },
                        item: function(data, escape) {
                            return '<div>' + escape(data.text) + '</div>';
                        }
                    }
                });

                const responsibleSelect = document.getElementById('swal-responsible');

                const updateResponsibleList = () => {
                    const checkedIds = ts.getValue();
                    const currentSelected = responsibleSelect.value;
                    
                    let options = '<option value="">-- Choisir le responsable --</option>';
                    
                    if (checkedIds.length === 0) {
                        options = '<option value="">-- Sélectionnez d\'abord du personnel --</option>';
                    } else {
                        checkedIds.forEach(id => {
                            const p = availablePersonnel.find(pers => pers.id == id);
                            if (p) {
                                options += `<option value="${p.id}" ${p.id == currentSelected ? 'selected' : ''}>${p.name} ${p.prenom}</option>`;
                            }
                        });
                    }
                    
                    responsibleSelect.innerHTML = options;
                };

                ts.on('change', updateResponsibleList);
            },
            preConfirm: () => {
                const selectedOptions = Array.from(document.getElementById('swal-personnel').selectedOptions).map(opt => opt.value);
                const responsibleId = document.getElementById('swal-responsible').value;
                
                let dateDebut = null;
                let dateFin = null;

                if (selectedOptions.length === 0) {
                    Swal.showValidationMessage('Veuillez assigner au moins un membre du personnel');
                    return false;
                }

                if (!responsibleId) {
                    Swal.showValidationMessage('Veuillez désigner un chef d\'équipe');
                    return false;
                }

                if (!selectedOptions.includes(responsibleId)) {
                    Swal.showValidationMessage('Le chef d\'équipe doit faire partie du personnel sélectionné');
                    return false;
                }

                if (needsDates) {
                    dateDebut = document.getElementById('swal-date-debut').value;
                    dateFin = document.getElementById('swal-date-fin').value;

                    if (!dateDebut || !dateFin) {
                        Swal.showValidationMessage('Les dates sont obligatoires');
                        return false;
                    }
                    if (dateFin < dateDebut) {
                        Swal.showValidationMessage('La date de fin ne peut pas être antérieure à la date de début');
                        return false;
                    }
                }

                return { personnel_ids: selectedOptions, responsible_id: responsibleId, date_debut: dateDebut, date_fin: dateFin };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form dynamically
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/prestataire/interventions/${interventionId}/validate`;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // Add personnel_ids[] inputs
                result.value.personnel_ids.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'personnel_ids[]';
                    input.value = id;
                    form.appendChild(input);
                });

                const responsibleInput = document.createElement('input');
                responsibleInput.type = 'hidden';
                responsibleInput.name = 'responsible_id';
                responsibleInput.value = result.value.responsible_id;
                form.appendChild(responsibleInput);

                if (needsDates) {
                    const dateDebutInput = document.createElement('input');
                    dateDebutInput.type = 'hidden';
                    dateDebutInput.name = 'date_debut';
                    dateDebutInput.value = result.value.date_debut;
                    form.appendChild(dateDebutInput);

                    const dateFinInput = document.createElement('input');
                    dateFinInput.type = 'hidden';
                    dateFinInput.name = 'date_fin';
                    dateFinInput.value = result.value.date_fin;
                    form.appendChild(dateFinInput);
                }

                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    function openRefusalModal(interventionId, reference) {
        Swal.fire({
            title: 'Refuser l\'intervention ' + reference,
            input: 'textarea',
            inputLabel: 'Motif du refus',
            inputPlaceholder: 'Expliquez pourquoi vous refusez cette intervention...',
            inputAttributes: {
                'aria-label': 'Expliquez pourquoi vous refusez cette intervention'
            },
            showCancelButton: true,
            confirmButtonText: 'Confirmer le refus',
            cancelButtonText: 'Annuler',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            inputValidator: (value) => {
                if (!value) {
                    return 'Vous devez fournir un motif pour le refus !'
                }
                if (value.length < 5) {
                    return 'Le motif est trop court.'
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/prestataire/interventions/${interventionId}/refuse`;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                const motifInput = document.createElement('input');
                motifInput.type = 'hidden';
                motifInput.name = 'motif_refus';
                motifInput.value = result.value;
                form.appendChild(motifInput);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
@endsection
