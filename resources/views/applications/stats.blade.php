<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Statisztika
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6">📊 Statisztika</h1>

        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <ul class="space-y-3 text-gray-700 text-lg">
                <li><strong>Összes jelentkezés:</strong> <span class="font-semibold">{{ $count }}</span></li>
                <li><strong>Redflag-es cégek:</strong> <span class="font-semibold text-red-600">{{ $redflagged }}</span></li>
                <li><strong>Cégek száma:</strong> <span class="font-semibold">{{ $companyCount }}</span></li>
                <li><strong>Utolsó jelentkezés dátuma:</strong>
                    <span class="font-semibold">{{ $lastApplicationDate ? $lastApplicationDate->format('Y-m-d') : 'Nincs adat' }}</span>
                </li>
            </ul>
        </div>

        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h3 class="text-xl font-semibold mb-4">Státusz szerinti bontás:</h3>
            <ul class="divide-y divide-gray-200 text-gray-700">
                @foreach($statuses as $status => $total)
                    <li class="py-2 flex justify-between">
                        <span class="capitalize">{{ $status }}</span>
                        <span class="font-semibold">{{ $total }} db</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h3 class="text-xl font-semibold mb-4">Leggyakoribb cégek (Top 3):</h3>
            @if($topCompanies && $topCompanies->count())
                <ul class="divide-y divide-gray-200 text-gray-700">
                    @foreach($topCompanies as $company => $total)
                        <li class="py-2 flex justify-between">
                            <span>{{ $company }}</span>
                            <span class="font-semibold">{{ $total }} db</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">Nincs elérhető adat.</p>
            @endif
        </div>

        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h3 class="text-xl font-semibold mb-4">Redflag-es cégek listája:</h3>
            @if($redflaggedCompanies && $redflaggedCompanies->count())
                <ul class="list-disc ml-6 text-sm text-red-600">
                    @foreach($redflaggedCompanies as $company)
                        <li>{{ $company }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">Nincs redflag-es cég.</p>
            @endif
        </div>

        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h3 class="text-xl font-semibold mb-4">📊 Jelentkezések státusz szerint (grafikon)</h3>
            <canvas id="statusChart" height="120"></canvas>
        </div>

        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h3 class="text-xl font-semibold mb-4">📅 Jelentkezések alakulása (hónaponként)</h3>
            <canvas id="trendChart" height="120"></canvas>
        </div>

        <!-- Itt később egy grafikon helye -->
        {{-- <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h3 class="text-xl font-semibold mb-4">Grafikon (pl. státuszok eloszlása)</h3>
            <canvas id="statusChart"></canvas>
        </div> --}}

        <a href="{{ route('applications.index') }}" class="inline-block px-5 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 transition">
            ← Vissza
        </a>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </div>
    {{-- Chart.js CDN --}}

    <script>
            const trendCtx = document.getElementById('trendChart').getContext('2d');
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode(array_keys($monthlyApplications->toArray())) !!},
                    datasets: [{
                        label: 'Jelentkezések száma',
                        data: {!! json_encode(array_values($monthlyApplications->toArray())) !!},
                        backgroundColor: 'rgba(37, 99, 235, 0.2)', // blue-600
                        borderColor: 'rgba(37, 99, 235, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: 'rgba(37, 99, 235, 1)'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Havi jelentkezési trend'
                        },
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

    </script>

   <script>
    // Státusz szerinti jelentkezések diagram
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($statuses->toArray())) !!},
            datasets: [{
                label: 'Jelentkezések száma',
                data: {!! json_encode(array_values($statuses->toArray())) !!},
                backgroundColor: [
                    'rgba(37, 99, 235, 0.7)',
                    'rgba(234, 179, 8, 0.7)',
                    'rgba(239, 68, 68, 0.7)',
                    'rgba(34, 197, 94, 0.7)',
                    'rgba(168, 85, 247, 0.7)'
                ],
                borderColor: [
                    'rgba(37, 99, 235, 1)',
                    'rgba(234, 179, 8, 1)',
                    'rgba(239, 68, 68, 1)',
                    'rgba(34, 197, 94, 1)',
                    'rgba(168, 85, 247, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Jelentkezések státusz szerint'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>





</x-app-layout>
