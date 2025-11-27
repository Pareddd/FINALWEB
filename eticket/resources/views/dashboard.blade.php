<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-fuchsia-400 leading-tight font-display">
            {{ __('Tiket Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-white/10">
                <div class="p-6 text-gray-100">
                    <div class="text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                        <h3 class="text-xl font-bold text-white">Belum Ada Tiket</h3>
                        <p class="text-gray-400 mt-2 mb-6">Kamu belum membeli tiket konser apapun.</p>
                        <a href="{{ route('home') }}" class="inline-block bg-white text-black hover:bg-fuchsia-500 hover:text-white px-6 py-2 rounded-full font-bold transition duration-300">
                            CARI EVENT SEKARANG
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>