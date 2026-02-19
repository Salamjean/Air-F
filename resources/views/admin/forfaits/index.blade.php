@extends('admin.layouts.template')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-[#111827]">Gestion des Forfaits</h1>
                <p class="text-gray-500 mt-2">Gérez les forfaits d'intervention et leurs tâches associées.</p>
            </div>
            <a href="{{ route('admin.forfaits.create') }}"
                class="inline-flex items-center px-6 py-3 bg-[#111827] text-white font-bold rounded-xl shadow-lg hover:bg-red-600 transition-all duration-300">
                <i class="fas fa-plus mr-2"></i> Nouveau Forfait
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($forfaits as $forfait)
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="h-2 bg-gradient-to-r from-red-600 to-amber-500"></div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <span
                                class="bg-gray-100 text-[#111827] text-xs font-bold px-3 py-1 rounded-full uppercase">{{ $forfait->name }}</span>
                            <h3 class="text-2xl font-bold text-[#111827]">{{ number_format($forfait->price, 0) }} €</h3>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">{{ $forfait->label }}</h4>
                        <p class="text-sm text-gray-500 mb-6 flex items-center">
                            <i class="fas fa-tasks mr-2"></i> {{ $forfait->tasks_count }} tâches incluses
                        </p>

                        <div class="flex items-center gap-3 pt-4 border-t border-gray-50">
                            <a href="{{ route('admin.forfaits.edit', $forfait) }}"
                                class="flex-1 text-center py-2 bg-gray-50 text-[#111827] text-sm font-bold rounded-lg hover:bg-gray-100 transition-colors">
                                Modifier
                            </a>
                            <form action="{{ route('admin.forfaits.destroy', $forfait) }}" method="POST" class="inline"
                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce forfait ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection