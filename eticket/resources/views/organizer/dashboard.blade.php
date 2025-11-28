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
                        <table class="w-full text-left text-gray-300">
                            <thead class="text-xs uppercase bg-slate-700 text-gray-400">
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
                                        <img src="{{ asset('storage/' . $event->image) }}" class="w-16 h-10 object-cover rounded">
                                    </td>
                                    <td class="px-6 py-4 font-bold text-white">{{ $event->name }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y, H:i') }}
                                        <br>
                                        <span class="text-xs text-gray-500">{{ $event->lokasi }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @foreach($event->tickets as $ticket)
                                            <span class="block text-xs bg-fuchsia-900/50 text-fuchsia-300 px-2 py-1 rounded mb-1 w-fit">
                                                {{ $ticket->name }}: {{ $ticket->kuota }} slot
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

                                            <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus event ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-400 text-sm font-bold underline">
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
                        <p class="text-gray-400 mb-4">Anda belum mempublikasikan event apapun.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>