@extends('financier.layouts.template')

@section('title', 'Liste des utilisateurs Finance')

@section('content')
    <div class="mx-auto" style="width: 90%;">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Utilisateurs Finance</h2>
                <p class="text-gray-500 mt-1">Gérez les comptes financiers et consultez leur créateur.</p>
            </div>
            <a href="{{ route('financier.users.create') }}"
                class="group relative inline-flex items-center justify-center px-8 py-3 font-semibold text-white transition-all duration-200 bg-red-600 font-pj rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600 hover:bg-red-700 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <span class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-gradient-to-b from-transparent via-transparent to-black"></span>
                <i class="fas fa-plus mr-2 z-10"></i> <span class="z-10">Nouvel Utilisateur</span>
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            <!-- Table Header Decoration -->
            <div class="h-1 bg-gradient-to-r from-red-500 via-red-400 to-red-600"></div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-500 uppercase text-xs tracking-wider border-b border-gray-100">
                            <th class="px-8 py-6 font-semibold text-center">Utilisateur</th>
                            <th class="px-6 py-6 font-semibold text-center">Contact</th>
                            <th class="px-6 py-6 font-semibold text-center">Localisation</th>
                            <th class="px-6 py-6 font-semibold text-center">Ajouté par</th>
                            <th class="px-6 py-6 font-semibold text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50/80 transition-all duration-200 group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center justify-center">
                                        <div class="h-12 w-12 flex-shrink-0 relative">
                                            @if($user->profile_picture)
                                                <img class="h-12 w-12 rounded-xl object-cover border border-gray-100 shadow-sm transition-transform group-hover:scale-105"
                                                    src="{{ asset('storage/' . $user->profile_picture) }}"
                                                    alt="{{ $user->name }}">
                                            @else
                                                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-red-50 to-red-100 text-red-500 flex items-center justify-center text-lg font-bold border border-red-100 shadow-sm">
                                                    {{ substr($user->name, 0, 1) }}{{ substr($user->prenom, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900 group-hover:text-red-600 transition-colors">{{ $user->name }} {{ $user->prenom }}</div>
                                            <div class="text-xs text-gray-500 font-medium">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center text-sm text-gray-600">
                                        <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center mr-2 text-gray-400">
                                            <i class="fas fa-phone-alt text-xs"></i>
                                        </div>
                                        <span class="font-medium">{{ $user->contact }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center text-sm text-gray-600">
                                        <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center mr-2 text-gray-400">
                                            <i class="fas fa-map-marker-alt text-xs"></i>
                                        </div>
                                        <span>{{ $user->adresse ?? 'Non renseigné' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center text-sm text-gray-600">
                                        @if($user->creator)
                                            <div class="flex items-center bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100">
                                                <i class="fas fa-user-tag text-gray-400 mr-2 text-xs"></i>
                                                <span class="font-medium text-gray-700">{{ $user->creator->name }} {{ $user->creator->prenom }}</span>
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">Système / Inconnu</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        @if($user->created_by === auth('user')->id())
                                            <form action="{{ route('financier.users.destroy', $user) }}" method="POST"
                                                class="inline-block" onsubmit="return confirmDelete(event)">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200"
                                                    title="Archiver">
                                                    <i class="fas fa-trash-can"></i>
                                                </button>
                                            </form>
                                        @else
                                            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-300 cursor-help" title="Seul le créateur peut archiver ce compte">
                                                <i class="fas fa-lock"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-users text-gray-300 text-3xl"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900">Aucun utilisateur trouvé</h3>
                                        <p class="text-gray-500 mt-1 max-w-sm">Commencez par ajouter un nouvel utilisateur financier.</p>
                                        <a href="{{ route('financier.users.create') }}" class="mt-6 text-red-600 font-medium hover:text-red-700 transition-colors">
                                            <i class="fas fa-plus mr-1"></i> Ajouter maintenant
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function confirmDelete(event) {
                event.preventDefault();
                const form = event.target;

                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: "Cette action est irréversible !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#9ca3af',
                    confirmButtonText: 'Oui, archiver',
                    cancelButtonText: 'Annuler',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl px-6 py-3 font-bold',
                        cancelButton: 'rounded-xl px-6 py-3 font-medium'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            }
        </script>
    @endpush
@endsection
