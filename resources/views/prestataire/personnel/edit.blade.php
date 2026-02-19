@extends('prestataire.layouts.template')

@section('title', 'Modifier le membre')

@section('header_title', 'Gestion du personnel')

@section('content')
    <div class=" mx-auto" style="width: 80%;">

        <!-- Breadcrumb / Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Modifier le membre</h2>
                <p class="text-sm text-gray-500 mt-1">Mise à jour des informations de {{ $personnel->name }}.</p>
            </div>
            <a href="{{ route('prestataire.personnel.index') }}"
                class="group flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:text-red-600 hover:border-red-200 transition-all shadow-sm">
                <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i>
                Retour à la liste
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Form Header Decoration -->
            <div class="h-2 bg-gradient-to-r from-red-500 to-red-600"></div>

            <div class="p-8">
                <form action="{{ route('prestataire.personnel.update', $personnel) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-8">
                        <div class="flex items-center mb-6">
                            <div
                                class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-500 mr-4 border border-red-100">
                                <i class="fas fa-user-edit"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Informations du Personnel</h3>
                                <p class="text-xs text-gray-500">Modifiez les détails du membre de votre équipe.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nom -->
                            <div class="relative">
                                <label for="name"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nom
                                    <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-signature"></i>
                                    </span>
                                    <input type="text" name="name" id="name" value="{{ old('name', $personnel->name) }}"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all outline-none text-gray-700 placeholder-gray-400"
                                        required>
                                </div>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Prénom -->
                            <div class="relative">
                                <label for="prenom"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Prénom
                                    <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-signature"></i>
                                    </span>
                                    <input type="text" name="prenom" id="prenom"
                                        value="{{ old('prenom', $personnel->prenom) }}"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all outline-none text-gray-700 placeholder-gray-400"
                                        required>
                                </div>
                                @error('prenom')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="relative md:col-span-2">
                                <label for="email"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Email
                                    <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email', $personnel->email) }}"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all outline-none text-gray-700 placeholder-gray-400"
                                        required>
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Contact -->
                            <div class="relative md:col-span-2">
                                <label for="contact"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Contact
                                    <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-phone-alt"></i>
                                    </span>
                                    <input type="text" name="contact" id="contact"
                                        value="{{ old('contact', $personnel->contact) }}"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all outline-none text-gray-700 placeholder-gray-400"
                                        required>
                                </div>
                                @error('contact')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2 mt-4 pt-4 border-t border-gray-100">
                                <div class="flex items-center mb-4">
                                    <div
                                        class="w-8 h-8 rounded-full bg-yellow-50 flex items-center justify-center text-yellow-600 mr-3 border border-yellow-100">
                                        <i class="fas fa-key"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-800">Changer le mot de passe</h3>
                                        <p class="text-xs text-gray-500">Laissez vide si vous ne souhaitez pas le modifier.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Mot de passe -->
                            <div class="relative">
                                <label for="password"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nouveau
                                    mot de passe</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" name="password" id="password"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all outline-none text-gray-700 placeholder-gray-400"
                                        minlength="8">
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirmation Mot de passe -->
                            <div class="relative">
                                <label for="password_confirmation"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Confirmer
                                    nouveau mot de passe</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-check-double"></i>
                                    </span>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all outline-none text-gray-700 placeholder-gray-400">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="flex items-center justify-end pt-6 border-t border-gray-100">
                        <a href="{{ route('prestataire.personnel.index') }}"
                            class="px-6 py-3 mr-4 text-gray-500 hover:text-gray-700 font-medium transition-colors">
                            Annuler
                        </a>
                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-red-600 to-red-500 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:from-red-700 hover:to-red-600 transform hover:-translate-y-0.5 transition-all">
                            <i class="fas fa-check-circle mr-2"></i> Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection