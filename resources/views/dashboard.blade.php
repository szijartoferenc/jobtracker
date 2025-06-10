<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Álláskövető - Irányítópult
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Sikeres üzenetek -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Redflag cégek -->
            <div class="bg-white shadow-md rounded p-6 mb-6">
                <h3 class="text-lg font-bold mb-4">🚩 Redflag Cégek</h3>
              @if($redflaggedCompanies->isEmpty())
                <p class="text-gray-500">Nincs redflag céged.</p>
            @else
                <ul class="list-disc ml-6 text-sm text-red-600">
                    @foreach($redflaggedCompanies as $company)
                        <li>{{ $company }}</li>  <!-- mivel csak stringeket tartalmaz -->
                    @endforeach
                </ul>
            @endif
            </div>

            <!-- Legfrissebb jelentkezések -->
            <div class="bg-white shadow-md rounded p-6 mb-6">
                <h3 class="text-lg font-bold mb-4">🗂️ Legfrissebb jelentkezések</h3>
                @if($latestApplications->isEmpty())
                    <p class="text-gray-500">Nincs elérhető jelentkezés.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Pozíció</th>
                                    <th class="px-4 py-2">Cég</th>
                                    <th class="px-4 py-2">Státusz</th>
                                    <th class="px-4 py-2">Jegyzet</th>
                                    <th class="px-4 py-2">Dátum</th>
                                    <th class="px-4 py-2">CV</th>
                                    <th class="px-4 py-2">Motivációs levél</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($latestApplications as $application)
                                    <tr class="border-t">
                                        <td class="px-4 py-2 font-medium text-blue-700">{{ $application->position }}</td>
                                        <td class="px-4 py-2">{{ $application->company }}</td>  <!-- Nincs company objektum! -->
                                        <td class="px-4 py-2">{{ ucfirst($application->status) }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-600">{{ Str::limit($application->notes, 30) }}</td>
                                        <td class="px-4 py-2">{{ $application->created_at->format('Y-m-d') }}</td>
                                        <td class="px-4 py-2">
                                            @if ($application->cv_path)
                                                <a href="{{ route('applications.download', ['id' => $application->id, 'type' => 'cv']) }}" class="text-blue-600 hover:underline">Letöltés</a>
                                            @else
                                                <span class="text-gray-400">Nincs</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">
                                            @if ($application->cover_letter_path)
                                                <a href="{{ route('applications.download', ['id' => $application->id, 'type' => 'cover']) }}" class="text-blue-600 hover:underline">Letöltés</a>
                                            @else
                                                <span class="text-gray-400">Nincs</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Exportálás és statisztika linkek -->
            <div class="bg-white shadow-md rounded p-6 mb-6 flex justify-between">
                <a href="{{ route('applications.export.csv') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    📄 Exportálás (CSV)
                </a>
                <a href="{{ route('applications.stats') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    📊 Statisztikák megtekintése
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
