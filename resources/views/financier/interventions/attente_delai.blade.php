@extends('financier.layouts.template')

@section('content')
    <div class="container mx-auto px-6 py-10">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 gap-6">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Fixer le Délai de Paiement</h1>
                <p class="text-lg text-gray-600 mt-2">Dossiers réceptionnés en attente de planification du règlement.</p>
            </div>
        </div>

        <!-- Table Container -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr
                            class="bg-gray-50 border-b border-gray-100 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Référence</th>
                            <th class="px-6 py-4">Libellé</th>
                            <th class="px-6 py-4">Prestataire / Personnel</th>
                            <th class="px-6 py-4">Montant</th>
                            <th class="px-6 py-4">Choisir le Délai</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($interventions as $intervention)
                            <tr class="hover:bg-gray-50 transition-colors duration-200 group">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-sm font-bold text-gray-900 group-hover:text-red-600 transition-colors">
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
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 flex-shrink-0 text-[10px]">
                                                <i class="fas fa-building"></i>
                                            </div>
                                            <span class="text-xs font-bold text-gray-700 truncate max-w-[120px]"
                                                title="{{ $intervention->prestataire->name ?? 'N/A' }}">
                                                {{ $intervention->prestataire->name ?? 'N/A' }}
                                            </span>
                                        </div>
                                        @if($intervention->personnels->count() > 0)
                                            <div class="flex flex-wrap gap-1 mt-1">
                                                @foreach($intervention->personnels as $p)
                                                    <span
                                                        class="text-[9px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded border border-blue-100">
                                                        {{ $p->prenom }} {{ $p->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold text-gray-900">
                                        {{ number_format($intervention->montant, 0, ',', ' ') }} EURO
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('financier.interventions.fixer_delai', $intervention->id) }}"
                                        method="POST" class="flex items-center gap-2">
                                        @csrf
                                        <select name="delai_paiement" required
                                            class="text-xs bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 outline-none p-2.5 font-bold text-gray-700">
                                            <option value="" disabled selected>Sélectionner...</option>
                                            <option value="30">30 Jours</option>
                                            <option value="45">45 Jours</option>
                                            <option value="60">60 Jours</option>
                                            <option value="95">95 Jours</option>
                                            <option value="120">120 Jours</option>
                                        </select>
                                        <button type="button" data-reference="{{ $intervention->reference }}"
                                            data-montant="{{ number_format($intervention->montant, 0, ',', ' ') }}"
                                            onclick="confirmDelay(this)"
                                            class="bg-indigo-600 text-white w-9 h-9 rounded-xl hover:bg-indigo-700 transition-all flex items-center justify-center shadow-sm hover:shadow-md"
                                            title="Valider le délai">
                                            <i class="fas fa-calendar-check"></i>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('financier.interventions.paiement_detail', $intervention->id) }}"
                                        class="inline-flex items-center justify-center px-4 py-2 border border-gray-200 hover:bg-gray-50 text-gray-600 rounded-xl transition-all text-xs font-bold shadow-sm">
                                        Détails
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-300">
                                            <i class="fas fa-hourglass-half text-2xl"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900">Aucun dossier</h3>
                                        <p class="text-gray-500 mt-1 max-w-sm text-sm">Les interventions réceptionnées
                                            apparaîtront ici pour fixer le délai.</p>
                                    </div>
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
        function confirmDelay(button) {
            const form = button.closest('form');
            const select = form.querySelector('select');

            if (!select.value) {
                Swal.fire({
                    icon: 'error',
                    title: 'Délai manquant',
                    text: 'Veuillez sélectionner un délai avant de valider.',
                    confirmButtonColor: '#6B7280'
                });
                return;
            }

            const ref = button.getAttribute('data-reference');
            const montant = button.getAttribute('data-montant');
            const delai = select.value;

            Swal.fire({
                title: 'Valider le délai ?',
                html: `
                            <div class="text-left bg-gray-50 p-5 rounded-2xl border border-gray-100 space-y-3 mt-4">
                                <div class="flex justify-between border-b border-gray-200 pb-2">
                                    <span class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Référence</span>
                                    <span class="text-gray-900 font-bold">${ref}</span>
                                </div>
                                <div class="flex justify-between border-b border-gray-200 pb-2">
                                    <span class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Montant</span>
                                    <span class="text-gray-900 font-bold">${montant} EURO</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Délai choisi</span>
                                    <span class="text-indigo-600 font-extrabold">${delai} Jours</span>
                                </div>
                            </div>
                        `,
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#4F46E5', // indigo-600
                cancelButtonColor: '#6B7280',
                confirmButtonText: '<i class="fas fa-check-circle mr-2"></i> Confirmer le délai',
                cancelButtonText: 'Annuler',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'font-bold px-6 py-3 rounded-xl shadow-lg',
                    cancelButton: 'px-6 py-3 rounded-xl shadow-sm',
                    popup: 'rounded-[2rem] border-none shadow-2xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
@endpush