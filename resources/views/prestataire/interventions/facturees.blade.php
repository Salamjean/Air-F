@extends('prestataire.layouts.template')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Interventions Facturées</h1>
                <p class="text-gray-600 mt-2">Liste de vos interventions qui ont été facturées (confirmées par le
                    responsable).</p>
            </div>
            <div class="mt-4 md:mt-0">
                <form action="{{ route('prestataire.interventions.facturees') }}" method="GET" class="relative">
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
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Site
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
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-map-marker-alt text-red-500 text-xs"></i>
                                        <span
                                            class="text-sm font-bold text-gray-700">{{ $intervention->site->name ?? 'N/A' }}</span>
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
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800">
                                        Facturée
                                    </span>
                                    <a href="{{ route('prestataire.interventions.details', $intervention->id) }}"
                                        class="text-gray-500 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors inline-block ml-2">
                                        <i class="fas fa-eye mr-1"></i> Détails
                                    </a>
                                    <button
                                        onclick="finaliserFacture({{ $intervention->id }}, '{{ $intervention->reference }}', {{ $intervention->montant }})"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors inline-block ml-2">
                                        <i class="fas fa-file-signature mr-1"></i> Finaliser Facture
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-file-invoice text-4xl mb-3 text-gray-300"></i>
                                    <p>Aucune intervention facturée.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function finaliserFacture(interventionId, reference, montantInitial) {
            Swal.fire({
                title: 'Finaliser la Facture',
                html: `
                            <div class="text-left">
                                <p class="mb-4 text-sm text-gray-600">Référence: <strong>${reference}</strong></p>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Montant définitif (EURO)</label>
                                    <input type="number" id="montant_final" class="swal2-input w-full m-0" value="${montantInitial}" placeholder="Entrez le montant final">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Joindre la facture (PDF, Image)</label>
                                    <input type="file" id="facture_file" class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-red-50 file:text-red-700
                                        hover:file:bg-red-100
                                    ">
                                </div>
                            </div>
                        `,
                showCancelButton: true,
                confirmButtonText: 'Soumettre la facture',
                cancelButtonText: 'Annuler',
                confirmButtonColor: '#dc2626',
                preConfirm: () => {
                    const montant = document.getElementById('montant_final').value;
                    const fileInput = document.getElementById('facture_file');
                    const file = fileInput.files[0];

                    if (!montant) {
                        Swal.showValidationMessage('Veuillez entrer le montant');
                        return false;
                    }
                    if (!file) {
                        Swal.showValidationMessage('Veuillez joindre le fichier de la facture');
                        return false;
                    }

                    return {
                        montant: montant,
                        file: file
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('montant', result.value.montant);
                    formData.append('facture_file', result.value.file);
                    formData.append('_token', '{{ csrf_token() }}');

                    Swal.fire({
                        title: 'Traitement en cours...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch(`/prestataire/interventions/devis/${interventionId}/soumettre-facture-definitive`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Réussi !',
                                    text: data.success,
                                    confirmButtonColor: '#dc2626'
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erreur',
                                    text: data.error || 'Une erreur est survenue lors de la soumission.',
                                    confirmButtonColor: '#dc2626'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: 'Une erreur technique est survenue.',
                                confirmButtonColor: '#dc2626'
                            });
                        });
                }
            });
        }
    </script>
@endpush