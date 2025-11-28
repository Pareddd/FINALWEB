<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-fuchsia-400 leading-tight font-display">{{ __('Tiket Saya') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-white/10 p-6">
                
                @if(session('success'))
                    <div class="bg-green-600/20 border border-green-500 text-green-400 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-600/20 border border-red-500 text-red-400 px-4 py-3 rounded mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                @if($bookings->count() > 0)
                    <div class="grid gap-4">
                        @foreach($bookings as $booking)
                        <div class="bg-slate-900 p-5 rounded-xl border 
                            {{ $booking->status == 'lunas' ? 'border-green-500/30' : ($booking->status == 'pending' ? 'border-yellow-500/30' : 'border-red-500/30 opacity-70') }} 
                            flex flex-col md:flex-row justify-between items-center transition hover:bg-slate-900/80">
                            
                            <div class="flex items-center gap-4 mb-4 md:mb-0">
                                <div class="w-16 h-16 bg-slate-800 rounded-lg flex items-center justify-center text-2xl border border-white/10">🎫</div>
                                <div>
                                    <h3 class="font-bold text-xl text-white">{{ $booking->ticket->event->name }}</h3>
                                    <p class="text-gray-200">{{ $booking->ticket->name }} <span class="text-white mx-2">•</span> {{ $booking->quantity }} Tiket</p>
                                    <p class="text-sm mt-1">
                                        Status: 
                                        @if($booking->status == 'lunas')
                                            <span class="font-bold text-green-400">LUNAS / AKTIF</span>
                                        @elseif($booking->status == 'pending')
                                            <span class="font-bold text-yellow-400 animate-pulse">MENUNGGU PERSETUJUAN</span>
                                        @else
                                            <span class="font-bold text-red-400">DIBATALKAN</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex gap-3">
                                @if($booking->status == 'lunas')
                                    <a href="{{ route('booking.show', $booking) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        TIKET
                                    </a>
                                @endif

                                @if($booking->status != 'batal')
                                    <form action="{{ route('booking.cancel', $booking) }}" method="POST" onsubmit="return confirm('Batalkan pesanan ini?');">
                                        @csrf @method('PATCH')
                                        <button class="bg-red-600/10 hover:bg-red-600 text-red-500 hover:text-white border border-red-500 px-4 py-2 rounded-lg text-sm font-bold transition">
                                            BATAL
                                        </button>
                                    </form>
                                @else
                                    <span class="bg-slate-800 text-gray-500 px-4 py-2 rounded text-sm font-bold border border-white/10">HANGUS</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-white text-lg">Anda belum memesan tiket apapun.</p>
                        <a href="{{ route('home') }}" class="mt-4 inline-block text-fuchsia-400 underline hover:text-fuchsia-300">Cari Event Sekarang</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>