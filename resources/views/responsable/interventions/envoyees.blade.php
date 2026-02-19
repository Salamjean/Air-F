@extends('responsable.layouts.template')

@section('content')
    <div class="container mx-auto px-6 py-10">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 gap-6">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Interventions Envoyées</h1>
                <p class="text-lg text-gray-600 mt-2">Validez la réception et confirmez les interventions envoyées par
                    l'administration.</p>
            </div>

            <!-- Search Bar -->
            <div class="w-full md:w-auto relative">
                <form action="{{ route('responsable.interventions.envoyees') }}" method="GET" class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="pl-10 pr-4 py-3 w-full md:w-80 bg-white border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 placeholder-gray-400 text-gray-700"
                        placeholder="Rechercher par référence, code...">
                </form>
            </div>
        </div>

        <!-- Table Container -->
        <div class="w-full">
            <!-- Table Container -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr
                                class="bg-blue-50/50 border-b border-gray-100 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-4">Référence</th>
                                <th class="px-6 py-4">Libellé</th>
                                <th class="px-6 py-4">Prestataire</th>
                                <th class="px-6 py-4">Période</th>
                                <th class="px-6 py-4">Personnel</th>
                                <th class="px-6 py-4">Statut</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($interventions as $intervention)
                                <tr class="hover:bg-gray-50 transition-colors duration-200 group">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
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
                                        <div class="text-xs text-gray-500 truncate mt-0.5"
                                            title="{{ $intervention->description }}">
                                            {{ $intervention->description }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-6 h-6 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 flex-shrink-0 text-xs">
                                                <i class="fas fa-building"></i>
                                            </div>
                                            <span class="text-sm text-gray-700">
                                                {{ $intervention->prestataire->name . ' ' . $intervention->prestataire->prenom ?? 'Non assigné' }}
                                            </span>
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
                                        @if($intervention->personnels->count() > 0)
                                            <div class="flex flex-col gap-1.5">
                                                @foreach($intervention->personnels as $personnel)
                                                    <div class="flex items-center gap-2 cursor-pointer hover:bg-purple-50 p-1 rounded-lg transition-colors group/personnel"
                                                        onclick="showPersonnelInfo('{{ $personnel->name }}', '{{ $personnel->prenom }}', '{{ $personnel->email }}', '{{ $personnel->contact }}')">
                                                        <div
                                                            class="w-6 h-6 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-[10px] font-bold">
                                                            {{ substr($personnel->name, 0, 1) }}{{ substr($personnel->prenom, 0, 1) }}
                                                        </div>
                                                        <span
                                                            class="text-xs text-gray-700 group-hover/personnel:text-purple-700 font-medium dotted-underline">
                                                            {{ Str::limit($personnel->name . ' ' . $personnel->prenom, 15) }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Non assigné</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                            <i class="fas fa-paper-plane text-blue-500"></i> Envoyée
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <button
                                                onclick="confirmValidation('{{ $intervention->id }}', '{{ $intervention->reference }}')"
                                                class="inline-flex items-center justify-center w-8 h-8 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 hover:text-green-700 transition-colors"
                                                title="Confirmer">
                                                <i class="fas fa-check-double"></i>
                                            </button>
                                            <a href="{{ route('responsable.interventions.details', $intervention->id) }}"
                                                class="inline-flex items-center justify-center w-8 h-8 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-800 transition-colors"
                                                title="Détails">
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                                <i class="fas fa-inbox text-2xl text-gray-300"></i>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900">Aucune intervention reçue</h3>
                                            <p class="text-gray-500 mt-1 max-w-sm text-sm">Les interventions envoyées par
                                                l'administration apparaîtront ici pour confirmation.</p>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showPersonnelInfo(name, prenom, email, contact) {
            Swal.fire({
                title: `<div class="text-xl font-bold text-gray-800">Assigné à</div>`,
                html: `
                                        <div class="flex flex-col items-center mb-4">
                                            <div class="w-20 h-20 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-3xl font-bold mb-4">
                                                ${name.charAt(0)}${prenom.charAt(0)}
                                            </div>
                                            <h3 class="text-lg font-bold text-gray-900">${name} ${prenom}</h3>
                                            <p class="text-gray-500">Personnel Technique</p>
                                        </div>
                                        <div class="bg-gray-50 rounded-xl p-4 text-left w-full space-y-3 border border-gray-100">
                                            <div class="flex items-center gap-3">
                                                <i class="fas fa-envelope text-gray-400"></i>
                                                <span class="text-sm font-medium text-gray-800">${email}</span>
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <i class="fas fa-phone text-gray-400"></i>
                                                <span class="text-sm font-medium text-gray-800">${contact}</span>
                                            </div>
                                        </div>
                                    `,
                showConfirmButton: false,
                showCloseButton: true
            });
        }

        function confirmValidation(id, reference) {
            Swal.fire({
                title: 'Confirmer la réception ?',
                text: `L'intervention ${reference} passera au statut "Confirmée".`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10B981',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, confirmer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/responsable/interventions/${id}/confirm`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection