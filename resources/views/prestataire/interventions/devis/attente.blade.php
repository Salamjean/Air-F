@extends('prestataire.layouts.template')

@section('content')
    <div class="container mx-auto px-6 py-10">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 gap-6">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Interventions en Attente de Devis</h1>
                <p class="text-lg text-gray-600 mt-2">Veuillez soumettre vos devis pour les interventions traitées.</p>
            </div>

            <!-- Search Bar -->
            <div class="w-full md:w-auto relative">
                <form action="{{ route('prestataire.interventions.devis.attente') }}" method="GET" class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 group-focus-within:text-yellow-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="pl-10 pr-4 py-3 w-full md:w-80 bg-white border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-300 placeholder-gray-400 text-gray-700"
                        placeholder="Rechercher par référence, code...">
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
                            class="bg-yellow-50/50 border-b border-gray-100 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Code</th>
                            <th class="px-6 py-4">Référence</th>
                            <th class="px-6 py-4">Libellé</th>
                            <th class="px-6 py-4">Période</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($interventions as $intervention)
                            <tr class="hover:bg-gray-50 transition-colors duration-200 group">
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold text-gray-900 group-hover:text-yellow-600 transition-colors">
                                        {{ $intervention->code }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-mono text-gray-500 bg-gray-100 px-2 py-0.5 rounded">
                                        {{ $intervention->reference }}
                                    </span>
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
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700 border border-yellow-100">
                                        <i class="fas fa-file-invoice-dollar text-yellow-500"></i> À faire
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        @if($intervention->rapport_path)
                                            <button onclick="openReportDetails(
                                                                                    '{{ $intervention->id }}', 
                                                                                    `{{ addslashes($intervention->rapport_commentaire) }}`, 
                                                                                    '{{ \Carbon\Carbon::parse($intervention->date_debut_reelle)->format('d/m/Y H:i') }}', 
                                                                                    '{{ \Carbon\Carbon::parse($intervention->date_fin_reelle)->format('d/m/Y H:i') }}',
                                                                                    '{{ asset('storage/' . $intervention->rapport_path) }}',
                                                                                    {{ json_encode($intervention->equipements->map(fn($e) => ['name' => $e->name, 'quantity' => $e->pivot->quantity, 'unit' => $e->unit])) }}
                                                                                )"
                                                class="inline-flex items-center justify-center px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-xs font-medium"
                                                title="Détails du Rapport">
                                                <i class="fas fa-eye mr-1"></i> Rapport
                                            </button>
                                        @endif

                                        <button onclick="openDevisModal('{{ $intervention->id }}')"
                                            class="inline-flex items-center justify-center px-3 py-1.5 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg shadow-sm hover:shadow-md transition-all text-xs font-medium"
                                            title="Soumettre Devis">
                                            <i class="fas fa-upload mr-1"></i> Devis
                                        </button>
                                    </div>
                                    <form id="reject-form-{{ $intervention->id }}"
                                        action="{{ route('prestataire.interventions.devis.rejeter_rapport', $intervention->id) }}"
                                        method="POST" style="display:none;">
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-file-invoice text-2xl text-gray-300"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900">Aucune intervention en attente de devis
                                        </h3>
                                        <p class="text-gray-500 mt-1 max-w-sm text-sm">Dès qu'une intervention sera traitée,
                                            elle apparaîtra ici pour soumission de devis.</p>
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
        function openReportDetails(id, comment, start, end, fileUrl, equipments) {
            let equipHtml = '';
            if (equipments && equipments.length > 0) {
                equipHtml = `
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <h4 class="text-xs font-bold text-gray-500 uppercase mb-2">Matériel Utilisé</h4>
                            <div class="space-y-2">
                                ${equipments.map(e => `
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-700 font-medium">${e.name}</span>
                                        <span class="text-blue-600 font-bold">${e.quantity} ${e.unit}</span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    `;
            }

            Swal.fire({
                title: 'Détails du Rapport',
                html: `
                                                    <div class="text-left space-y-4">
                                                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                                                            <h4 class="text-xs font-bold text-gray-500 uppercase mb-1">Dates Réelles</h4>
                                                            <p class="text-sm text-gray-800">Du <strong>${start}</strong> au <strong>${end}</strong></p>
                                                        </div>

                                                        ${equipHtml}

                                                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                                                            <h4 class="text-xs font-bold text-gray-500 uppercase mb-1">Commentaire</h4>
                                                            <p class="text-sm text-gray-700 whitespace-pre-wrap">${comment}</p>
                                                        </div>

                                                        <div class="flex flex-col gap-3 mt-4">
                                                            <a href="${fileUrl}" target="_blank" class="flex items-center justify-center gap-2 w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold text-sm">
                                                                <i class="fas fa-file-download"></i> Voir le fichier joint
                                                            </a>

                                                            <button onclick="confirmReject('${id}')" class="w-full py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors font-semibold text-sm flex items-center justify-center gap-2">
                                                                <i class="fas fa-times-circle"></i> Signaler comme Incorrect
                                                            </button>

                                                        </div>
                                                    </div>
                                                `,
                showConfirmButton: false,
                showCloseButton: true,
                width: '600px'
            });
        }

        function confirmReject(id) {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Voulez-vous vraiment signaler ce rapport comme incorrect ? Le personnel devra le corriger.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, signaler incorrect',
                cancelButtonText: 'Annuler',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`reject-form-${id}`).submit();
                }
            });
        }

        function openDevisModal(id) {
            Swal.fire({
                title: 'Soumettre un devis',
                html: `
                                                            <div class="text-left space-y-4">
                                                                <p class="text-gray-600 text-sm">Veuillez indiquer le montant et télécharger le fichier du devis.</p>

                                                                <div>
                                                                    <label class="block text-gray-700 text-sm font-bold mb-2">Montant du devis (EURO)</label>
                                                                    <input type="number" id="swal-montant" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 border-gray-300" placeholder="Ex: 150000">
                                                                </div>

                                                                <div>
                                                                    <label class="block text-gray-700 text-sm font-bold mb-2">Fichier du devis (PDF, IMG)</label>
                                                                    <input type="file" id="swal-file" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 border-gray-300" accept=".pdf,.jpg,.jpeg,.png">
                                                                </div>
                                                            </div>
                                                        `,
                showCancelButton: true,
                confirmButtonColor: '#FBBF24',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Soumettre',
                cancelButtonText: 'Annuler',
                preConfirm: () => {
                    const montant = document.getElementById('swal-montant').value;
                    const fileInput = document.getElementById('swal-file');
                    const file = fileInput.files[0];

                    if (!montant || !file) {
                        Swal.showValidationMessage('Tous les champs sont obligatoires');
                        return false;
                    }

                    return { montant: montant, file: file };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('montant', result.value.montant);
                    formData.append('devis_file', result.value.file);

                    // We need to submit this via a form because of file upload handling with JS/Swal limitations usually requiring AJAX or form construction
                    // Constructing a hidden form to submit properly with file

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/prestataire/interventions/${id}/devis/soumettre`;
                    form.enctype = 'multipart/form-data';

                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';
                    form.appendChild(csrfInput);

                    const montantInput = document.createElement('input');
                    montantInput.type = 'hidden';
                    montantInput.name = 'montant';
                    montantInput.value = result.value.montant;
                    form.appendChild(montantInput);

                    // Create a hidden file input and assign the file object from Swal (Tricky part)
                    // Standard file inputs are read-only for security.
                    // Instead, let's use fetch API (AJAX) for better UX with file uploads

                    Swal.fire({
                        title: 'Envoi en cours...',
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch(`/prestataire/interventions/devis/${id}/soumettre`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest', // Force JSON response from Laravel if possible
                            'Accept': 'application/json'
                        }
                    })
                        .then(async response => {
                            if (!response.ok) {
                                const data = await response.json().catch(() => ({}));
                                // Laravel often returns detailed validation errors in data.errors
                                let errorMessage = data.message || data.error || 'Erreur lors de la soumission';

                                if (data.errors) {
                                    errorMessage += '\n' + Object.values(data.errors).join('\n');
                                }

                                throw new Error(errorMessage);
                            }
                            return response.json();
                        })
                        .then(data => {
                            Swal.fire('Succès', 'Devis soumis avec succès', 'success').then(() => {
                                location.reload();
                            });
                        })
                        .catch(error => {
                            Swal.fire('Erreur', error.message, 'error');
                        });
                }
            });
        }
    </script>
@endsection