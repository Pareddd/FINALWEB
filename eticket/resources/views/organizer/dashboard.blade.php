<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-fuchsia-400 leading-tight font-display">
                {{ __('Organizer Studio') }}
            </h2>
            <a href="{{ route('events.create') }}" class="bg-fuchsia-600 hover:bg-fuchsia-700 text-white px-4 py-2 rounded text-sm font-bold transition shadow-lg">
                + BUAT EVENT BARU
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-600/20 border border-green-500 text-green-400 px-4 py-3 rounded relative mb-6">
                    <strong class="font-bold">Berhasil!</strong> {{ session('success') }}
                </div>
            @endif

            <div class="bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-white/10 p-6">
                
                <h3 class="text-xl font-bold text-white mb-6">Daftar Event Saya</h3>

                @if($events->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-white">
                            <thead class="text-xs uppercase bg-slate-700 text-white">
                                <tr>
                                    <th class="px-6 py-3">Poster</th>
                                    <th class="px-6 py-3">Nama Event</th>
                                    <th class="px-6 py-3">Jadwal</th>
                                    <th class="px-6 py-3">Tiket</th>
                                    <th class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700">
                                @foreach($events as $event)
                                <tr class="hover:bg-slate-700/50 transition">
                                    <td class="px-6 py-4">
                                        @if($event->image)
                                            <img src="{{ asset('storage/' . $event->image) }}" class="w-16 h-10 object-cover rounded border border-white/20">
                                        @else
                                            <div class="w-16 h-10 bg-slate-600 rounded flex items-center justify-center text-xs text-gray-400">No IMG</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-bold text-white">{{ $event->name }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y, H:i') }}
                                        <br>
                                        <span class="text-xs text-gray-300">{{ $event->lokasi }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @foreach($event->tickets as $ticket)
                                            <span class="block text-xs bg-fuchsia-900 text-fuchsia-200 px-2 py-1 rounded mb-1 w-fit border border-fuchsia-500/30">
                                                {{ $ticket->name }}: {{ $ticket->kuota }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('events.show', $event) }}" class="text-cyan-400 hover:text-cyan-300 text-sm font-bold underline">
                                                Lihat
                                            </a>

                                            <a href="{{ route('events.edit', $event) }}" class="text-yellow-400 hover:text-yellow-300 text-sm font-bold underline">
                                                Edit
                                            </a>

                                            <a href="{{ route('events.bookings', $event) }}" class="text-green-400 hover:text-green-300 text-sm font-bold underline relative">
                                                Pesanan
                                                @php
                                                    $pendingCount = \App\Models\Booking::whereIn('ticket_id', $event->tickets->pluck('id'))->where('status', 'pending')->count();
                                                @endphp
                                                @if($pendingCount > 0)
                                                    <span class="absolute -top-2 -right-2 bg-red-600 text-white text-[10px] px-1.5 rounded-full animate-pulse">{{ $pendingCount }}</span>
                                                @endif
                                            </a>

                                            <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus event ini?');">
                                                @csrf @method('DELETE')
                                                <button class="text-red-500 hover:text-red-400 text-sm font-bold underline">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-white mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <p class="text-white mb-4">Anda belum mempublikasikan event apapun.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>