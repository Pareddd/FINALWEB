<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SoundStage - Tiket Konser</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Raleway:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #0f172a; color: #ffffff; font-family: 'Raleway', sans-serif; margin: 0; }
        h1, h2, .font-display { font-family: 'Orbitron', sans-serif; text-transform: uppercase; }
        .neon-text { text-shadow: 0 0 5px #fff, 0 0 10px #d946ef, 0 0 20px #d946ef; }
    </style>
</head>
<body class="antialiased bg-slate-900 text-white overflow-x-hidden">
    @include('layouts.navigation')

    <div class="relative min-h-[80vh] flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1470225620780-dba8ba36b745?q=80&w=2070&auto=format&fit=crop" alt="Concert" class="w-full h-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-purple-900/40 to-slate-900"></div>
        </div>

        <div class="relative z-10 text-center max-w-4xl mx-auto mt-10 w-full">
            <div class="inline-block border border-fuchsia-500/50 bg-black/30 backdrop-blur px-3 py-1 rounded-full mb-6">
                <span class="text-fuchsia-400 text-[10px] sm:text-xs font-bold tracking-[0.2em] uppercase">The Ultimate Music Experience</span>
            </div>
            
            <h1 class="font-display text-5xl sm:text-6xl md:text-8xl font-black text-white mb-6 leading-tight">
                FEEL THE <br/> <span class="neon-text">RHYTHM</span>
            </h1>
            
            <p class="text-gray-200 text-base sm:text-lg md:text-xl mb-10 max-w-2xl mx-auto font-light tracking-wide px-4">
                Dapatkan tiket eksklusif konser band favoritmu. Jangan lewatkan momen bersejarah di panggung impian.
            </p>

            <form action="{{ route('home') }}" method="GET" class="w-full max-w-md sm:max-w-xl mx-auto relative group px-2">
                <div class="absolute -inset-1 bg-gradient-to-r from-fuchsia-600 to-blue-600 rounded-lg blur opacity-40 group-hover:opacity-100 transition duration-200"></div>
                <div class="relative flex flex-col sm:flex-row bg-black rounded-lg border border-white/20 p-1">
                    <input type="text" name="search" placeholder="Cari Artis, Genre, atau Kota..." 
                           class="w-full bg-transparent text-white border-none focus:ring-0 px-4 py-3 placeholder-gray-500 outline-none text-center sm:text-left mb-2 sm:mb-0"
                           value="{{ request('search') }}">
                    <button type="submit" class="bg-white text-black font-black px-6 py-2 rounded hover:bg-gray-200 transition uppercase tracking-widest text-sm w-full sm:w-auto">
                        CARI
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="py-16 sm:py-24 relative bg-slate-900 px-4 sm:px-6 lg:px-8">
        <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-fuchsia-500 to-transparent opacity-50"></div>
        
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-end mb-12 border-b border-white/10 pb-4">
                <div>
                    <h2 class="text-2xl sm:text-4xl font-display font-bold text-white mb-2">UPCOMING <span class="text-fuchsia-500">GIGS</span></h2>
                </div>
                <div class="hidden md:block">
                    <span class="text-gray-400 text-sm tracking-widest">SCROLL DOWN FOR MORE</span>
                </div>
            </div>

            @if($events->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @foreach($events as $event)
                    <div class="group relative bg-gray-800 rounded-xl overflow-hidden hover:-translate-y-2 transition-all duration-300 shadow-2xl border border-white/5 flex flex-col h-full">
                        
                        <div class="relative h-64 overflow-hidden shrink-0">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent z-10 opacity-80"></div>
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full bg-slate-700 flex items-center justify-center text-gray-500">No IMG</div>
                            @endif

                            <div class="absolute top-4 right-4 z-20 bg-black/80 border border-fuchsia-500 text-center px-3 py-2 rounded">
                                <span class="block text-2xl font-bold font-display text-white">{{ \Carbon\Carbon::parse($event->tanggal)->format('d') }}</span>
                                <span class="block text-xs text-fuchsia-400 uppercase">{{ \Carbon\Carbon::parse($event->tanggal)->format('M') }}</span>
                            </div>
                        </div>

                        <div class="p-6 relative z-20 flex flex-col flex-grow -mt-4">
                            <span class="text-xs font-bold tracking-widest text-blue-400 uppercase mb-2 block">{{ $event->kategori }}</span>
                            <h3 class="text-2xl font-bold text-white mb-2 font-display leading-tight group-hover:text-fuchsia-400 transition">
                                {{ $event->name }}
                            </h3>
                            <div class="flex items-center text-gray-400 text-sm mb-6">
                                <span class="mr-1">📍</span> {{ $event->lokasi }}
                            </div>

                            <div class="mt-auto flex items-center justify-between border-t border-white/10 pt-4">
                                <div>
                                    <span class="text-xs text-gray-500 block uppercase">Mulai Dari</span>
                                    @if($event->tickets->count() > 0)
                                        <span class="text-lg font-bold text-white">IDR {{ number_format($event->tickets->min('harga'), 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-lg font-bold text-white">TBA</span>
                                    @endif
                                </div>
                                <a href="{{ route('events.show', $event) }}" class="bg-white text-black hover:bg-fuchsia-500 hover:text-white px-6 py-2 rounded-full font-bold text-sm transition-colors duration-300">
                                    TIKET
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-white/5 rounded-2xl border border-white/10 border-dashed">
                    <h3 class="text-2xl font-display text-white mb-2">Belum Ada Jadwal</h3>
                    <p class="text-gray-400">Panggung sedang disiapkan. Cek lagi nanti!</p>
                </div>
            @endif
        </div>
    </div>
    <footer class="bg-black border-t border-white/10 py-12 pb-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="font-display text-2xl font-bold text-white mb-4">SOUND<span class="text-fuchsia-500">STAGE</span></h2>
            <p class="text-gray-600 text-xs">&copy; {{ date('Y') }} SoundStage. Keep Rocking! 🤘</p>
        </div>
    </footer>
</body>
</html>