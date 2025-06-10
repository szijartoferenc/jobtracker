<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Álláspályázatok
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

        {{-- Új jelentkezés gomb --}}
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('applications.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded shadow">
                + Új jelentkezés
            </a>

            <div>
                <a href="{{ route('applications.export.csv') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm rounded text-gray-700 hover:bg-gray-100 mr-2">
                    📁 CSV export
                </a>
                <a href="{{ route('applications.export.pdf') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm rounded text-gray-700 hover:bg-gray-100">
                    📄 PDF export
                </a>
            </div>
        </div>

        {{-- Sikeres üzenet --}}
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Ha nincs adat --}}
        @if($applications->isEmpty())
            <p class="text-gray-600">Nincs még rögzített jelentkezés.</p>
        @else

            {{-- Szűrő űrlap --}}
            <form method="GET" action="{{ route('applications.index') }}" class="bg-white p-4 rounded shadow mb-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Keresés (cég/pozíció)</label>
                        <input type="text" name="search" id="search" class="mt-1 block w-full rounded border-gray-300 shadow-sm" value="{{ request('search') }}">
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Státusz</label>
                        <select name="status" id="status" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                            <option value="">– összes –</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="redflag" class="block text-sm font-medium text-gray-700">Redflag</label>
                        <select name="redflag" id="redflag" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                            <option value="">– összes –</option>
                            <option value="1" {{ request('redflag') === '1' ? 'selected' : '' }}>Igen</option>
                            <option value="0" {{ request('redflag') === '0' ? 'selected' : '' }}>Nem</option>
                        </select>
                    </div>

                    <div>
                        <label for="from" class="block text-sm font-medium text-gray-700">Dátumtól</label>
                        <input type="date" name="from" id="from" class="mt-1 block w-full rounded border-gray-300 shadow-sm" value="{{ request('from') }}">
                    </div>

                    <div>
                        <label for="to" class="block text-sm font-medium text-gray-700">Dátumig</label>
                        <input type="date" name="to" id="to" class="mt-1 block w-full rounded border-gray-300 shadow-sm" value="{{ request('to') }}">
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                            Szűrés
                        </button>
                    </div>
                </div>
            </form>

            {{-- Táblázat --}}
            <div class="overflow-x-auto bg-white shadow rounded">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cég</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pozíció</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dátum</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Státusz</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">⚠️</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Műveletek</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @foreach($applications as $app)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $app->company }}</td>
                            <td class="px-4 py-2">{{ $app->position ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $app->applied_at?->format('Y-m-d') ?? '-' }}</td>
                            <td class="px-4 py-2">{{ ucfirst($app->status) }}</td>
                            <td class="px-4 py-2 text-center">
                                @if($app->redflag)
                                    ⚠️
                                @endif
                            </td>
                            <td class="px-4 py-2 space-x-2 whitespace-nowrap">
                                <a href="{{ route('applications.edit', $app) }}" class="inline-block text-yellow-700 hover:text-yellow-900 font-medium">✏️</a>

                                <form action="{{ route('applications.destroy', $app) }}" method="POST" class="inline" onsubmit="return confirm('Biztosan törlöd?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium">🗑️</button>
                                </form>

                                @if($app->cv_path)
                                    <a href="{{ asset('storage/' . $app->cv_path) }}" target="_blank" class="text-blue-600 hover:underline">CV</a>
                                @endif
                                @if($app->cover_letter_path)
                                    <a href="{{ asset('storage/' . $app->cover_letter_path) }}" target="_blank" class="text-blue-600 hover:underline">Motivációs levél</a>
                                @endif

                                {{-- Részletek link --}}
                                <a href="{{ route('applications.show', $app) }}" class="inline-block text-blue-700 hover:text-blue-900 font-medium ml-2">
                                    🔍 Részletek
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif
    </div>
</x-app-layout>
