<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Új jelentkezés
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-8">
            <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Cég -->
                <div>
                    <label for="company" class="block text-sm font-medium text-gray-700">Cég *</label>
                    <input type="text" name="company" id="company" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                </div>

                <!-- Pozíció -->
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700">Pozíció</label>
                    <input type="text" name="position" id="position"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                </div>

                <!-- Jelentkezés dátuma -->
                <div>
                    <label for="applied_at" class="block text-sm font-medium text-gray-700">Jelentkezés dátuma</label>
                    <input type="date" name="applied_at" id="applied_at"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                </div>

                <!-- Státusz -->
               <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Státusz *</label>
                    <select name="status" id="status" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="palyazva">Pályázva</option>
                        <option value="interju">Interjú</option>
                        <option value="ajanlat">Ajánlat</option>
                        <option value="elutasitva">Elutasítva</option>
                        <option value="visszajelzes_var">Visszajelzés várása</option>
                    </select>
            </div>
                <!-- Jegyzet -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700">Jegyzet</label>
                    <textarea name="notes" id="notes" rows="3"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>

                <!-- Redflag -->
                <div class="flex items-center">
                    <input type="checkbox" name="redflag" id="redflag" value="1"
                        class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                    <label for="redflag" class="ml-2 block text-sm text-gray-700">Redflag cég?</label>
                </div>

                <!-- Önéletrajz -->
                <div>
                    <label for="cv" class="block text-sm font-medium text-gray-700">Önéletrajz (PDF, DOC, DOCX, max 2MB)</label>
                    <input type="file" name="cv" id="cv"
                        class="mt-1 block w-full text-sm text-gray-500 file:bg-indigo-600 file:text-white file:py-2 file:px-4 file:rounded-md file:border-0 file:cursor-pointer hover:file:bg-indigo-700" />
                </div>

                <!-- Motivációs levél -->
                <div>
                    <label for="cover_letter" class="block text-sm font-medium text-gray-700">Motivációs levél (PDF, DOC, DOCX, max 2MB)</label>
                    <input type="file" name="cover_letter" id="cover_letter"
                        class="mt-1 block w-full text-sm text-gray-500 file:bg-indigo-600 file:text-white file:py-2 file:px-4 file:rounded-md file:border-0 file:cursor-pointer hover:file:bg-indigo-700" />
                </div>

                <!-- Gombok -->
                <div class="flex justify-between">
                    <a href="{{ route('applications.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                        Mégse
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Mentés
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
