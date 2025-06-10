<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Jelentkezés részletei: {{ $application->company }} - {{ $application->position ?? '-' }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8 space-y-10">

        {{-- Jelentkezés alapadatok --}}
        <section class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-4">Alapadatok</h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-gray-700">
                <div>
                    <dt class="font-medium">Cég:</dt>
                    <dd>{{ $application->company }}</dd>
                </div>
                <div>
                    <dt class="font-medium">Pozíció:</dt>
                    <dd>{{ $application->position }}</dd>
                </div>
                <div>
                    <dt class="font-medium">Jelentkezés dátuma:</dt>
                    <dd>{{ $application->applied_at->format('Y-m-d') }}</dd>
                </div>
                <div>
                    <dt class="font-medium">Aktuális státusz:</dt>
                    <dd>{{ $application->status }}</dd>
                </div>
            </dl>
        </section>

        {{-- Státusz frissítés űrlap --}}
        <section class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-4">Státusz frissítése</h3>
            <form action="{{ route('applications.updateStatus', $application->id) }}" method="POST" class="space-y-4 max-w-md">
                @csrf
                @php
                    $statuses = ['Jelentkezve', 'Előszűrés', 'Interjú', 'Ajánlat', 'Elutasítva'];
                @endphp
                <label for="status" class="block text-sm font-medium text-gray-700">Státusz</label>
                <select name="status" id="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" {{ $application->status == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="inline-flex justify-center px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded shadow">
                    Frissítés
                </button>
            </form>
        </section>

        {{-- Jegyzet hozzáadása --}}
        <section class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-4">Új jegyzet hozzáadása</h3>
            <form action="{{ route('applications.addNote', $application->id) }}" method="POST" class="space-y-4 max-w-md">
                @csrf
                <label for="note" class="block text-sm font-medium text-gray-700">Jegyzet</label>
                <textarea name="note" id="note" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Írd be a megjegyzést..."></textarea>
                <button type="submit" class="inline-flex justify-center px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded shadow">
                    Mentés
                </button>
            </form>
        </section>

        {{-- Jegyzetek listája --}}
       @if($application->applicationNotes->isNotEmpty())
            <ul class="divide-y divide-gray-200">
                @foreach($application->applicationNotes as $note)
                    <li class="py-3">
                        <p class="text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($note->noted_at)->format('Y-m-d H:i') }}
                        </p>
                        <p class="mt-1 text-gray-800 whitespace-pre-line">{{ $note->note }}</p>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-600">Nincsenek jegyzetek.</p>
        @endif

        {{-- Státuszváltozások listája --}}
        <section class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-4">Státuszváltozások</h3>
            @if($application->statusChanges->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach($application->statusChanges as $change)
                        <li class="py-3">
                            <p class="text-sm text-gray-500">{{ $change->changed_at->format('Y-m-d H:i') }}</p>
                            <p class="mt-1 text-gray-800">{{ $change->old_status }} &rarr; {{ $change->new_status }}</p>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-600">Nincs státuszváltozás.</p>
            @endif
        </section>

        {{-- Naplóbejegyzés hozzáadása --}}
        <section class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-4">📝 Naplóbejegyzés hozzáadása</h3>
            <form method="POST" action="{{ route('applications.logs.store', $application) }}" class="space-y-6 max-w-md">
                @csrf
                <div>
                    <label for="status_log" class="block text-sm font-medium text-gray-700">Státusz (opcionális)</label>
                    <input type="text" name="status" id="status_log" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Pl. Interjúra hívtak">
                </div>

                <div>
                    <label for="note_log" class="block text-sm font-medium text-gray-700">Jegyzet <span class="text-red-500">*</span></label>
                    <textarea name="note" id="note_log" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Írd be a megjegyzést..."></textarea>
                </div>

                <div>
                    <label for="logged_at" class="block text-sm font-medium text-gray-700">Dátum <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="logged_at" id="logged_at" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <div>
                    <button type="submit" class="inline-flex justify-center px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded shadow">
                        Hozzáadás
                    </button>
                </div>
            </form>
        </section>

        {{-- Előzmények --}}
        <section class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-4">📜 Előzmények</h3>
            @if($application->logs()->exists())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Dátum</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Státusz</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jegyzet</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm">
                            @foreach ($application->logs()->latest()->get() as $log)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ $log->logged_at->format('Y.m.d H:i') }}</td>
                                    <td class="px-4 py-2">{{ $log->status ?? '—' }}</td>
                                    <td class="px-4 py-2 whitespace-pre-line">{{ $log->note }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-600">Még nincs naplóbejegyzés ehhez a jelentkezéshez.</p>
            @endif
        </section>

        {{-- Fájl letöltések --}}
        <section class="mt-8 space-y-2">
            @if ($application->resume_path)
                <p class="text-gray-700">
                    Önéletrajz:
                    <a href="{{ route('applications.download', ['application' => $application->id, 'file' => 'resume']) }}" target="_blank" rel="noopener" class="text-indigo-600 hover:underline">
                        Letöltés
                    </a>
                </p>
            @endif

            @if ($application->motivation_path)
                <p class="text-gray-700">
                    Motivációs levél:
                    <a href="{{ route('applications.download', ['application' => $application->id, 'file' => 'motivation']) }}" target="_blank" rel="noopener" class="text-indigo-600 hover:underline">
                        Letöltés
                    </a>
                </p>
            @endif
        </section>

    </div>
</x-app-layout>
