@extends('admin.layouts.template')

@section('title', 'Tableau de bord - Admin')

@section('header_title', 'Tableau de bord')

@section('content')
    <div class="container-fluid px-6 py-8">
        <!-- Welcome Section -->
        <div class="mb-10 animate-fade-in">
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Espace <span
                    class="text-blue-600">Administration</span></h1>
            <p class="text-lg text-gray-600 mt-2">Bienvenue. Voici l'état global de vos services et interventions.</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
            <!-- Interventions -->
            <div class="relative group">
                <div
                    class="absolute -inset-0.5 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-1000">
                </div>
                <div
                    class="relative bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                            <i class="fas fa-tools text-xl"></i>
                        </div>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Activité</span>
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-gray-900">{{ $stats['interventions'] }}</h3>
                        <p class="text-sm font-medium text-gray-500 mt-1">Total Interventions</p>
                    </div>
                </div>
            </div>

            <!-- Utilisateurs -->
            <div class="relative group">
                <div
                    class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-1000">
                </div>
                <div
                    class="relative bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-purple-50 rounded-xl text-purple-600">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Communauté</span>
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-gray-900">{{ $stats['users'] }}</h3>
                        <p class="text-sm font-medium text-gray-500 mt-1">Utilisateurs Inscrits</p>
                    </div>
                </div>
            </div>

            <!-- Equipements -->
            <div class="relative group">
                <div
                    class="absolute -inset-0.5 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-1000">
                </div>
                <div
                    class="relative bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-green-50 rounded-xl text-green-600">
                            <i class="fas fa-cubes text-xl"></i>
                        </div>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Stock</span>
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-gray-900">{{ $stats['equipements'] }}</h3>
                        <p class="text-sm font-medium text-gray-500 mt-1">Équipements Référencés</p>
                    </div>
                </div>
            </div>

            <!-- Prestataires -->
            <div class="relative group">
                <div
                    class="absolute -inset-0.5 bg-gradient-to-r from-orange-500 to-yellow-600 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-1000">
                </div>
                <div
                    class="relative bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-orange-50 rounded-xl text-orange-600">
                            <i class="fas fa-building text-xl"></i>
                        </div>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Partenaires</span>
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-gray-900">{{ $stats['prestataire'] }}</h3>
                        <p class="text-sm font-medium text-gray-500 mt-1">Prestataires Partenaires</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary Stats (Intervention Statuses) -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-12 animate-fade-in"
            style="animation-delay: 0.2s">
            <!-- Validées -->
            <div
                class="bg-white rounded-2xl p-4 border border-gray-50 shadow-sm hover:shadow-md transition-all border-b-4 border-b-blue-500">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-sm">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Validées</p>
                        <h4 class="text-xl font-black text-gray-900">{{ $stats['valider'] }}</h4>
                    </div>
                </div>
            </div>

            <!-- Confirmées -->
            <div
                class="bg-white rounded-2xl p-4 border border-gray-50 shadow-sm hover:shadow-md transition-all border-b-4 border-b-yellow-500">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-yellow-50 text-yellow-600 flex items-center justify-center text-sm">
                        <i class="fas fa-play"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Confirmées</p>
                        <h4 class="text-xl font-black text-gray-900">{{ $stats['confirmer'] }}</h4>
                    </div>
                </div>
            </div>

            <!-- Devis -->
            <div
                class="bg-white rounded-2xl p-4 border border-gray-50 shadow-sm hover:shadow-md transition-all border-b-4 border-b-cyan-500">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-cyan-50 text-cyan-600 flex items-center justify-center text-sm">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Devis</p>
                        <h4 class="text-xl font-black text-gray-900">{{ $stats['devis'] }}</h4>
                    </div>
                </div>
            </div>

            <!-- Accords -->
            <div
                class="bg-white rounded-2xl p-4 border border-gray-50 shadow-sm hover:shadow-md transition-all border-b-4 border-b-teal-500">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center text-sm">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Accords</p>
                        <h4 class="text-xl font-black text-gray-900">{{ $stats['accord'] }}</h4>
                    </div>
                </div>
            </div>

            <!-- Finances -->
            <div
                class="bg-white rounded-2xl p-4 border border-gray-50 shadow-sm hover:shadow-md transition-all border-b-4 border-b-emerald-500">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Finance</p>
                        <h4 class="text-xl font-black text-gray-900">{{ $stats['finance'] }}</h4>
                    </div>
                </div>
            </div>

            <!-- Payées -->
            <div
                class="bg-white rounded-2xl p-4 border border-gray-50 shadow-sm hover:shadow-md transition-all border-b-4 border-b-indigo-500">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Payées</p>
                        <h4 class="text-xl font-black text-gray-900">{{ $stats['payer'] }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Chart Section -->
            <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Tendance des Interventions</h3>
                        <p class="text-sm text-gray-500 mt-1">Volume mensuel sur les 6 derniers mois</p>
                    </div>
                    <div class="p-2 bg-gray-50 rounded-lg">
                        <i class="fas fa-chart-line text-blue-600"></i>
                    </div>
                </div>
                <div class="h-80">
                    <canvas id="interventionsChart"></canvas>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl font-bold text-gray-900">Dernières Actions</h3>
                    <a href="{{ route('admin.interventions.index') }}"
                        class="text-xs font-bold text-blue-600 hover:text-blue-700">Voir tout</a>
                </div>
                <div class="space-y-6">
                    @forelse($recentInterventions as $intervention)
                        <div class="flex gap-4 group cursor-default">
                            <div class="relative">
                                <div
                                    class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold z-10 relative">
                                    <i class="fas fa-file-invoice"></i>
                                </div>
                                @if(!$loop->last)
                                    <div class="absolute top-10 left-1/2 -translate-x-1/2 w-0.5 h-10 bg-gray-50"></div>
                                @endif
                            </div>
                            <div class="flex-1 pb-4">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                        {{ $intervention->reference }}</p>
                                    <span
                                        class="text-[10px] text-gray-400">{{ $intervention->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-xs text-gray-500 line-clamp-1 mt-0.5">{{ $intervention->libelle }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <p class="text-sm text-gray-400">Aucune activité récente</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('interventionsChart').getContext('2d');

                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
                gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($chartData['labels']) !!},
                        datasets: [{
                            label: 'Interventions',
                            data: {!! json_encode($chartData['data']) !!},
                            borderColor: '#3b82f6',
                            backgroundColor: gradient,
                            borderWidth: 4,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#3b82f6',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#1f2937',
                                padding: 12,
                                titleFont: { size: 14, weight: 'bold' },
                                bodyFont: { size: 13 },
                                cornerRadius: 8,
                                displayColors: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: '#f3f4f6', drawBorder: false },
                                ticks: {
                                    color: '#9ca3af',
                                    stepSize: 1,
                                    font: { weight: '500' }
                                }
                            },
                            x: {
                                grid: { display: false },
                                ticks: {
                                    color: '#9ca3af',
                                    font: { weight: '500' }
                                }
                            }
                        }
                    }
                });
            });
        </script>
        <style>
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in {
                animation: fadeIn 0.8s ease-out forwards;
            }
        </style>
    @endpush
@endsection