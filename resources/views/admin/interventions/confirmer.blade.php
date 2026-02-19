@extends('admin.layouts.template')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Interventions Confirmées</h1>
                <p class="text-gray-500 mt-1">Liste des interventions confirmées par le responsable</p>
            </div>

            <!-- Search Bar -->
            <div class="w-full md:w-auto relative">
                <form action="{{ route('admin.interventions.confirmer') }}" method="GET" class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 group-focus-within:text-green-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="pl-10 pr-4 py-2.5 w-full md:w-80 bg-white border border-gray-200 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all placeholder-gray-400 text-gray-700 font-medium"
                        placeholder="Rechercher par référence, code...">
                </form>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Top Decorative Bar -->
            <div class="h-2 bg-gradient-to-r from-green-500 via-emerald-400 to-green-500"></div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Référence / Code</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Libellé</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Prestataire</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Personnel</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Période</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Statut</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($interventions as $intervention)
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-900">{{ $intervention->reference }}</span>
                                        <span
                                            class="text-xs font-mono text-gray-500 bg-gray-100 px-2 py-0.5 rounded mt-1 overflow-hidden">{{ $intervention->code }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="text-sm font-semibold text-gray-800 line-clamp-1"
                                        title="{{ $intervention->libelle }}">{{ $intervention->libelle }}</div>
                                    <div class="text-xs text-gray-500 truncate max-w-xs mx-auto">
                                        {{ Str::limit($intervention->description, 40) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center">
                                        <div
                                            class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-2">
                                            <i class="fas fa-building text-[10px]"></i>
                                        </div>
                                        <span
                                            class="text-sm font-medium text-gray-700">{{ $intervention->prestataire->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($intervention->personnel)
                                        <button
                                            onclick="showPersonnelInfo('{{ $intervention->personnel->name }}', '{{ $intervention->personnel->prenom }}', '{{ $intervention->personnel->email }}', '{{ $intervention->personnel->contact }}')"
                                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition-colors text-xs font-bold">
                                            <div
                                                class="w-5 h-5 rounded-full bg-indigo-200 flex items-center justify-center text-[10px]">
                                                {{ substr($intervention->personnel->name, 0, 1) }}{{ substr($intervention->personnel->prenom, 0, 1) }}
                                            </div>
                                            {{ Str::limit($intervention->personnel->prenom, 10) }}
                                        </button>
                                    @else
                                        <span class="text-xs italic text-gray-400">Non assigné</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex flex-col text-xs text-gray-600">
                                        <span class="flex items-center justify-center gap-1">
                                            <i class="far fa-calendar-alt text-gray-400"></i>
                                            {{ \Carbon\Carbon::parse($intervention->date_debut)->format('d/m/Y') }}
                                        </span>
                                        <span class="flex items-center justify-center gap-1 mt-1">
                                            <i class="far fa-calendar-check text-gray-400"></i>
                                            {{ \Carbon\Carbon::parse($intervention->date_fin)->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="px-2.5 py-1 bg-green-100 text-green-700 text-[10px] font-bold uppercase rounded-full border border-green-200 flex items-center justify-center gap-1 w-fit mx-auto">
                                        <i class="fas fa-check-double text-[8px]"></i> Confirmée
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.interventions.details', $intervention->id) }}"
                                            class="p-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg transition-colors flex items-center gap-2 text-xs font-bold"
                                            title="Détails">
                                            <i class="fas fa-eye"></i> Détails
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-check-double text-2xl text-gray-300"></i>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-800">Aucune intervention confirmée</h3>
                                        <p class="text-gray-500 text-sm max-w-sm mx-auto mt-1">
                                            Les interventions confirmées par le responsable apparaîtront ici.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Personnel Info Popup Script (Reused) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showPersonnelInfo(name, prenom, email, contact) {
            Swal.fire({
                title: `<div class="text-lg font-bold text-gray-800">Assigné à</div>`,
                html: `
                            <div class="flex flex-col items-center mb-3">
                                <div class="w-16 h-16 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-2xl font-bold mb-2">
                                    ${name.charAt(0)}${prenom.charAt(0)}
                                </div>
                                <h3 class="text-base font-bold text-gray-900">${name} ${prenom}</h3>
                                <p class="text-sm text-gray-500">Personnel Technique</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3 text-left w-full space-y-2 border border-gray-100">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-6 flex justify-center"><i class="fas fa-envelope text-gray-400 text-xs"></i></div>
                                    <span class="text-sm font-medium text-gray-800">${email}</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <div class="w-6 flex justify-center"><i class="fas fa-phone text-gray-400 text-xs"></i></div>
                                    <span class="text-sm font-medium text-gray-800">${contact}</span>
                                </div>
                            </div>
                        `,
                showConfirmButton: false,
                showCloseButton: true,
                customClass: {
                    popup: 'rounded-xl shadow-xl border border-gray-100' // Custom tailwind classes if configured, usually SweetAlert classes
                }
            });
        }

        function confirmTraiter(id, reference) {
            Swal.fire({
                title: 'Traiter l\'intervention ?',
                text: `L'intervention ${reference} passera au statut "Traité".`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, traiter',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/interventions/${id}/traiter`;

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