@extends('financier.layouts.template')

@section('content')
    <div class="container mx-auto px-6 py-10">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 gap-6">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Attente de Règlement</h1>
                <p class="text-lg text-gray-600 mt-2">Dossiers dont le délai est fixé, en attente de validation finale du
                    paiement.</p>
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
                            <th class="px-6 py-4">Échéance</th>
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
                                    @php
                                        $diff = now()->diffInDays($intervention->date_paiement_prevue, false);
                                        $colorClass = $diff <= 5 ? 'text-red-600 bg-red-50' : 'text-blue-600 bg-blue-50';
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold {{ $colorClass }} border border-current opacity-80">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ \Carbon\Carbon::parse($intervention->date_paiement_prevue)->format('d/m/Y') }}
                                        @if($diff <= 5 && $diff >= 0)
                                            <span class="animate-pulse ml-1">(J-{{ (int) $diff }})</span>
                                        @elseif($diff < 0)
                                            <span class="ml-1 text-[8px] uppercase font-extrabold">(Retard)</span>
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <form action="{{ route('financier.interventions.payer', $intervention->id) }}"
                                            method="POST" class="inline-block">
                                            @csrf
                                            <button type="button" data-id="{{ $intervention->id }}"
                                                data-reference="{{ $intervention->reference }}"
                                                data-montant="{{ number_format($intervention->montant, 0, ',', ' ') }}"
                                                data-date="{{ \Carbon\Carbon::parse($intervention->date_paiement_prevue)->format('d/m/Y') }}"
                                                onclick="confirmPaymentInline(this)"
                                                class="inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl transition-all text-xs font-bold shadow-sm hover:shadow-md">
                                                <i class="fas fa-check-double mr-2"></i> Payer
                                            </button>
                                        </form>
                                        <a href="{{ route('financier.interventions.paiement_detail', $intervention->id) }}"
                                            class="inline-flex items-center justify-center px-4 py-2 border border-gray-200 hover:bg-gray-50 text-gray-600 rounded-xl transition-all text-xs font-bold shadow-sm">
                                            Détails
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-300">
                                            <i class="fas fa-money-check text-2xl"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900">Aucun règlement</h3>
                                        <p class="text-gray-500 mt-1 max-w-sm text-sm">Les interventions en attente de règlement
                                            final apparaîtront ici.</p>
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
        function confirmPaymentInline(button) {
            const ref = button.getAttribute('data-reference');
            const montant = button.getAttribute('data-montant');
            const date = button.getAttribute('data-date');

            Swal.fire({
                title: 'Valider le paiement ?',
                html: `
                            <div class="text-left bg-gray-50 p-5 rounded-2xl border border-gray-100 space-y-3 mt-4">
                                <div class="flex justify-between border-b border-gray-200 pb-2">
                                    <span class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Référence</span>
                                    <span class="text-gray-900 font-bold">${ref}</span>
                                </div>
                                <div class="flex justify-between border-b border-gray-200 pb-2">
                                    <span class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Montant</span>
                                    <span class="text-red-600 font-extrabold">${montant} EURO</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Échéance prévue</span>
                                    <span class="text-gray-900 font-bold">${date}</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-4 leading-relaxed px-4 text-center">
                                Voulez-vous valider ce règlement ? Cette action est irréversible et l'intervention sera classée dans l'historique.
                            </p>
                        `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#059669', // green-600
                cancelButtonColor: '#6B7280',
                confirmButtonText: '<i class="fas fa-check-circle mr-2"></i> Valider le paiement',
                cancelButtonText: 'Annuler',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'font-bold px-6 py-3 rounded-xl shadow-lg',
                    cancelButton: 'px-6 py-3 rounded-xl shadow-sm',
                    popup: 'rounded-[2rem] border-none shadow-2xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }
    </script>
@endpush