<x-app-layout>
    <div class="min-h-screen bg-gradient-to-b from-indigo-100 via-white to-white flex flex-col justify-between">

        {{-- HERO SZAKASZ --}}
        <div class="text-center pt-20 px-6">
            <h1 class="text-5xl font-extrabold text-indigo-800 mb-4">Álláskeresés Követő App</h1>
            <p class="text-lg text-gray-700 max-w-2xl mx-auto">
                Tartsd nyilván az összes álláspályázatodat, cégeidet, státuszaidat, jegyzeteidet és fájljaidat egy helyen.
            </p>

            <div class="mt-8 space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition transform hover:scale-105">
                        Irány a Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="inline-block bg-indigo-500 hover:bg-indigo-600 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition transform hover:scale-105">
                        Bejelentkezés
                    </a>
                    <a href="{{ route('register') }}"
                       class="inline-block bg-white text-indigo-600 border border-indigo-600 font-semibold px-6 py-3 rounded-lg shadow-md hover:bg-indigo-50 transition transform hover:scale-105">
                        Regisztráció
                    </a>
                @endauth
            </div>
        </div>

        {{-- FUNKCIÓK KÁRTYÁK --}}
        <div class="mt-16 px-6 lg:px-24">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white/70 backdrop-blur-md shadow-md rounded-lg p-6 hover:shadow-xl transition">
                    <h2 class="text-xl font-bold text-indigo-700 mb-2">📂 Jelentkezések kezelése</h2>
                    <p class="text-gray-600">Add hozzá, szerkeszd vagy töröld az álláspályázataidat, és kövesd a státuszukat.</p>
                </div>
                <div class="bg-white/70 backdrop-blur-md shadow-md rounded-lg p-6 hover:shadow-xl transition">
                    <h2 class="text-xl font-bold text-indigo-700 mb-2">📝 Jegyzetek & Redflags</h2>
                    <p class="text-gray-600">Adj hozzá megjegyzéseket, és jelöld be a problémás cégeket "Redflag" státusszal.</p>
                </div>
                <div class="bg-white/70 backdrop-blur-md shadow-md rounded-lg p-6 hover:shadow-xl transition">
                    <h2 class="text-xl font-bold text-indigo-700 mb-2">📊 Export & Statisztika</h2>
                    <p class="text-gray-600">Exportálj CSV vagy PDF formátumban, és nézd meg az összesített statisztikáidat.</p>
                </div>
            </div>
        </div>

        {{-- CTA SZAKASZ --}}
        <div class="mt-20 bg-indigo-600 text-white py-12 px-6 text-center">
            <h2 class="text-2xl md:text-3xl font-bold mb-2">Készen állsz rendszerezni a karriered?</h2>
            <p class="text-lg">Próbáld ki most – ingyenes és biztonságos.</p>
            @guest
                <a href="{{ route('register') }}"
                   class="mt-6 inline-block bg-white text-indigo-600 font-semibold px-8 py-3 rounded-full shadow-lg hover:bg-gray-100 transition">
                    Regisztrálok
                </a>
            @endguest
        </div>

        {{-- FOOTER --}}
        <footer class="text-center text-gray-500 py-6 text-sm">
            &copy; {{ now()->year }} Álláskövető App. Minden jog fenntartva.
        </footer>

    </div>
</x-app-layout>
