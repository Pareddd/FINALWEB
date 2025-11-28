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

                @if($bookings->count() > 0)
                    <div class="grid gap-4">
                        @foreach($bookings as $booking)
                        <div class="bg-slate-900 p-5 rounded-xl border {{ $booking->status == 'lunas' ? 'border-green-500/30' : 'border-red-500/30 opacity-70' }} flex flex-col md:flex-row justify-between items-center transition hover:bg-slate-900/80">
                            
                            <div class="flex items-center gap-4 mb-4 md:mb-0">
                                <div class="w-16 h-16 bg-slate-800 rounded-lg flex items-center justify-center text-2xl">🎫</div>
                                <div>
                                    <h3 class="font-bold text-xl text-white">{{ $booking->ticket->event->name }}</h3>
                                    <p class="text-gray-400">{{ $booking->ticket->name }} <span class="text-white mx-2">•</span> {{ $booking->quantity }} Tiket</p>
                                    <p class="text-sm mt-1">
                                        Status: 
                                        <span class="font-bold {{ $booking->status == 'lunas' ? 'text-green-400' : 'text-red-400' }}">
                                            {{ strtoupper($booking->status) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            
                            @if($booking->status == 'lunas')
                                <form action="{{ route('booking.cancel', $booking) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan tiket ini? Kuota akan dikembalikan.');">
                                    @csrf @method('PATCH')
                                    <button class="bg-red-600/10 hover:bg-red-600 text-red-500 hover:text-white border border-red-600 px-6 py-2 rounded-lg text-sm font-bold transition duration-300">
                                        BATALKAN PESANAN
                                    </button>
                                </form>
                            @else
                                <span class="bg-slate-800 text-gray-500 px-4 py-2 rounded text-sm font-bold border border-white/5">TIKET HANGUS</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-500 text-lg">Anda belum memiliki tiket konser.</p>
                        <a href="{{ route('home') }}" class="mt-4 inline-block text-fuchsia-400 underline">Cari Event Sekarang</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>