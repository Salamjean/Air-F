@extends('admin.layouts.template')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="mx-auto max-w-4xl">
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-[#111827]">Nouveau Forfait</h1>
                    <p class="text-gray-500 mt-2">Définissez un nouveau forfait d'intervention.</p>
                </div>
                <a href="{{ route('admin.forfaits.index') }}"
                    class="text-sm font-bold text-gray-500 hover:text-[#111827] flex items-center transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Annuler
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="h-2 bg-[#111827]"></div>
                <form action="{{ route('admin.forfaits.store') }}" method="POST" class="p-8 md:p-10 space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label for="name" class="block text-sm font-bold text-[#111827] mb-2">Identifiant (ex: F1,
                                F2)</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="w-full px-4 py-3 rounded-xl border-gray-300 focus:border-red-600 focus:ring-0 bg-gray-50 font-medium"
                                required>
                            @error('name') <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="price" class="block text-sm font-bold text-[#111827] mb-2">Prix H.T (€)</label>
                            <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}"
                                class="w-full px-4 py-3 rounded-xl border-gray-300 focus:border-red-600 focus:ring-0 bg-gray-50 font-medium"
                                required>
                            @error('price') <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="label" class="block text-sm font-bold text-[#111827] mb-2">Libellé du forfait</label>
                        <input type="text" name="label" id="label" value="{{ old('label') }}"
                            class="w-full px-4 py-3 rounded-xl border-gray-300 focus:border-red-600 focus:ring-0 bg-gray-50 font-medium"
                            placeholder="Ex: Maintenance Préventive Niveau 1" required>
                        @error('label') <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Tasks Management -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <label class="block text-sm font-bold text-[#111827]">Liste des tâches à inclure</label>
                            <button type="button" id="add-task-btn"
                                class="text-xs font-bold text-red-600 hover:text-red-700 flex items-center">
                                <i class="fas fa-plus-circle mr-1"></i> Ajouter une tâche
                            </button>
                        </div>

                        <div id="tasks-container" class="space-y-3">
                            <div class="flex items-center gap-3 task-row">
                                <input type="text" name="tasks[]"
                                    class="flex-1 px-4 py-3 rounded-xl border-gray-200 focus:border-red-600 focus:ring-0 bg-gray-50 text-sm"
                                    placeholder="Description de la tâche...">
                                <button type="button"
                                    class="remove-task-btn p-3 text-gray-400 hover:text-red-500 transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-50 flex justify-end">
                        <button type="submit"
                            class="px-10 py-4 bg-[#111827] text-white font-bold rounded-xl shadow-lg hover:bg-red-600 transition-all duration-300 transform hover:-translate-y-0.5">
                            <i class="fas fa-save mr-2"></i> Créer le forfait
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('tasks-container');
            const addBtn = document.getElementById('add-task-btn');

            addBtn.addEventListener('click', function () {
                const row = document.createElement('div');
                row.className = 'flex items-center gap-3 task-row animate-fadeIn';
                row.innerHTML = `
                    <input type="text" name="tasks[]" class="flex-1 px-4 py-3 rounded-xl border-gray-200 focus:border-red-600 focus:ring-0 bg-gray-50 text-sm" placeholder="Description de la tâche...">
                    <button type="button" class="remove-task-btn p-3 text-gray-400 hover:text-red-500 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                container.appendChild(row);
            });

            container.addEventListener('click', function (e) {
                if (e.target.closest('.remove-task-btn')) {
                    const row = e.target.closest('.task-row');
                    if (container.querySelectorAll('.task-row').length > 1) {
                        row.remove();
                    } else {
                        row.querySelector('input').value = '';
                    }
                }
            });
        });
    </script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out forwards;
        }
    </style>
@endpush