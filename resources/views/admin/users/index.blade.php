@extends('admin.layouts.template')

@section('title', 'Liste des utilisateurs')

@section('header_title', 'Gestion des utilisateurs')

@section('content')
    <div class="mx-auto" style="width: 80%;">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Utilisateurs</h2>
                <p class="text-gray-500 mt-1">Gérez les comptes et les accès à la plateforme.</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
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
                            <th class="px-6 py-6 font-semibold text-center">Rôle</th>
                            <th class="px-6 py-6 font-semibold text-center">Contact</th>
                            <th class="px-6 py-6 font-semibold text-center">Localisation</th>
                            <th class="px-6 py-6 font-semibold text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50/80 transition-all duration-200 group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center" style="display: flex; justify-content: center; align-items: center;">
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
                                            <!-- Status Indicator logic (optional) -->
                                            <span class="absolute -bottom-1 -right-1 h-3 w-3 bg-green-500 border-2 border-white rounded-full"></span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900 group-hover:text-red-600 transition-colors">{{ $user->name }} {{ $user->prenom }}</div>
                                            <div class="text-xs text-gray-500 font-medium">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center" >
                                    @php
                                        $roleStyles = [
                                            'admin' => 'bg-red-50 text-red-700 border-red-100',
                                            'responsable' => 'bg-purple-50 text-purple-700 border-purple-100',
                                            'prestataire' => 'bg-blue-50 text-blue-700 border-blue-100',
                                            'finance' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                        ];
                                        $style = $roleStyles[$user->role] ?? 'bg-gray-50 text-gray-700 border-gray-100';
                                        $label = ucfirst($user->role);
                                    @endphp
                                    <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-bold rounded-lg border {{ $style }}">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td class="px-6 py-5" style="display: flex; justify-content: center; align-items: center;">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center mr-2 text-gray-400">
                                            <i class="fas fa-phone-alt text-xs"></i>
                                        </div>
                                        <span class="font-medium">{{ $user->contact }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center text-sm text-gray-600" style="display: flex; justify-content: center; align-items: center;">
                                        <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center mr-2 text-gray-400">
                                            <i class="fas fa-map-marker-alt text-xs"></i>
                                        </div>
                                        <span>{{ $user->adresse ?? 'Non renseigné' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @if ($user->role != 'admin')
                                        <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                            class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200" 
                                            title="Modifier">
                                            <i class="fas fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                            class="inline-block" onsubmit="return confirmDelete(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200"
                                                title="Supprimer">
                                                <i class="fas fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                    @else
                                        <span class="text-gray-400">Aucune action</span>
                                    @endif
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
                                        <p class="text-gray-500 mt-1 max-w-sm">Commencez par ajouter un nouvel utilisateur à la plateforme.</p>
                                        <a href="{{ route('admin.users.create') }}" class="mt-6 text-red-600 font-medium hover:text-red-700 transition-colors">
                                            <i class="fas fa-plus mr-1"></i> Ajouter maintenant
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination if needed -->
            @if(method_exists($users, 'links') && $users->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-center">
                {{ $users->links() }}
            </div>
            @endif
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
                    confirmButtonColor: '#ef4444', // red-500
                    cancelButtonColor: '#9ca3af', // gray-400
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