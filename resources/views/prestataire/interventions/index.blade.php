@extends('prestataire.layouts.template')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Mes Interventions</h1>
            <p class="text-gray-600 mt-2">Gérez vos demandes d'intervention.</p>
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
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Statut
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Actions</th>
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
                                        {{ Str::limit($intervention->description, 50) }}</div>
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
                                        <span class="text-yellow-600 italic"><i class="fas fa-exclamation-triangle mr-1"></i> À
                                            définir</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
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
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $statusClasses[$intervention->statut] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $statusLabels[$intervention->statut] ?? $intervention->statut }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if($intervention->statut === 'en_attente' || $intervention->statut === 'rejeter')
                                        <!-- Permettre re-validation si rejeté ? À voir workflow -->
                                        <button
                                            onclick="openValidationModal('{{ $intervention->id }}', '{{ $intervention->reference }}', {{ var_export($intervention->date_debut === null, true) }})"
                                            class="text-white bg-green-600 hover:bg-green-700 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors mr-2">
                                            <i class="fas fa-check mr-1"></i> Valider
                                        </button>

                                        <form action="{{ route('prestataire.interventions.refuse', $intervention) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Êtes-vous sûr de vouloir refuser cette intervention ?');">
                                            @csrf
                                            <button type="submit"
                                                class="text-white bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">
                                                <i class="fas fa-times mr-1"></i> Refuser
                                            </button>
                                        </form>
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
    <script>
        function openValidationModal(interventionId, reference, needsDates) {
            let htmlContent = `
                <div class="text-left">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Montant de la prestation (EURO)</label>
                        <input type="number" id="swal-montant" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Ex: 150000" min="0">
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
                showCancelButton: true,
                confirmButtonText: 'Valider',
                cancelButtonText: 'Annuler',
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#d33',
                preConfirm: () => {
                    const montant = document.getElementById('swal-montant').value;
                    let dateDebut = null;
                    let dateFin = null;

                    if (!montant) {
                        Swal.showValidationMessage('Le montant est obligatoire');
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

                    return { montant: montant, date_debut: dateDebut, date_fin: dateFin };
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

                    const montantInput = document.createElement('input');
                    montantInput.type = 'hidden';
                    montantInput.name = 'montant';
                    montantInput.value = result.value.montant;
                    form.appendChild(montantInput);

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
    </script>
@endsection