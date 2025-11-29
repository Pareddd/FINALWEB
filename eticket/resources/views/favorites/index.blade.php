<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-fuchsia-400 leading-tight font-display">
            {{ __('Event Favorit Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-600/20 border border-green-500 text-green-400 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-white/10 p-6">
                
                @if($favorites->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($favorites as $event)
                        <div class="group relative bg-slate-900 rounded-xl overflow-hidden hover:-translate-y-2 transition-all duration-300 shadow-xl border border-white/5 flex flex-col h-full">
                            
                            <div class="relative h-48 overflow-hidden shrink-0">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent z-10 opacity-80"></div>
                                @if($event->image)
                                    <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full bg-slate-800 flex items-center justify-center text-gray-500">No Image</div>
                                @endif

                                <div class="absolute top-3 right-3 z-20 bg-black/80 border border-fuchsia-500 text-center px-2 py-1 rounded">
                                    <span class="block text-lg font-bold font-display text-white">{{ \Carbon\Carbon::parse($event->tanggal)->format('d') }}</span>
                                    <span class="block text-[10px] text-fuchsia-400 uppercase">{{ \Carbon\Carbon::parse($event->tanggal)->format('M') }}</span>
                                </div>
                            </div>

                            <div class="p-5 relative z-20 flex flex-col flex-grow -mt-4">
                                <span class="text-[10px] font-bold tracking-widest text-blue-400 uppercase mb-1 block">{{ $event->kategori }}</span>
                                
                                <h3 class="text-xl font-bold text-white mb-2 font-display leading-tight group-hover:text-fuchsia-400 transition">
                                    {{ $event->name }}
                                </h3>
                                
                                <div class="flex items-center text-gray-400 text-xs mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1 text-fuchsia-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $event->lokasi }}
                                </div>

                                <div class="mt-auto flex items-center justify-between border-t border-white/10 pt-3 gap-2">
                                    <a href="{{ route('events.show', $event) }}" class="flex-1 bg-white text-black hover:bg-fuchsia-500 hover:text-white py-2 rounded-lg font-bold text-xs text-center transition-colors duration-300">
                                        BELI TIKET
                                    </a>
                                    
                                    <form action="{{ route('events.favorite', $event) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-slate-800 text-red-500 hover:bg-red-500 hover:text-white p-2 rounded-lg border border-slate-700 transition" title="Hapus dari Favorit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-700 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Belum Ada Favorit</h3>
                        <p class="text-gray-400 mb-6">Simpan event yang Anda suka agar mudah ditemukan nanti.</p>
                        <a href="{{ route('home') }}" class="inline-block bg-fuchsia-600 hover:bg-fuchsia-700 text-white px-6 py-2 rounded-full font-bold transition">
                            Cari Event
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>