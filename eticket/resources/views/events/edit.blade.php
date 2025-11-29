<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-fuchsia-400 leading-tight font-display">
            {{ __('Edit Event & Tiket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="mb-6 bg-red-900/50 border border-red-500 text-red-200 px-4 py-3 rounded relative">
                    <strong class="font-bold">Gagal Menyimpan!</strong>
                    <ul class="list-disc pl-5 mt-2 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-slate-800 overflow-hidden shadow-xl sm:rounded-lg border border-white/10">
                <div class="p-8 text-gray-100">
                    
                    <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div class="border-b border-white/10 pb-8">
                            <h3 class="text-xl font-bold text-white mb-6">1. Edit Detail Konser</h3>
                            
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label class="block text-sm text-gray-400 mb-1">Nama Event</label>
                                    <input type="text" name="name" class="w-full bg-slate-900 border-slate-600 rounded-lg text-white focus:border-fuchsia-500" value="{{ old('name', $event->name) }}" required>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm text-gray-400 mb-1">Kategori</label>
                                        <select name="kategori" class="w-full bg-slate-900 border-slate-600 rounded-lg text-white">
                                            @foreach(['Musik Pop', 'Rock Metal', 'Jazz', 'Indie', 'EDM'] as $kat)
                                                <option value="{{ $kat }}" {{ $event->kategori == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm text-gray-400 mb-1">Tanggal</label>
                                        <input type="datetime-local" name="tanggal" class="w-full bg-slate-900 border-slate-600 rounded-lg text-white" value="{{ old('tanggal', $event->tanggal) }}" required>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-400 mb-1">Lokasi</label>
                                    <input type="text" name="lokasi" class="w-full bg-slate-900 border-slate-600 rounded-lg text-white" value="{{ old('lokasi', $event->lokasi) }}" required>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-400 mb-1">Deskripsi</label>
                                    <textarea name="deskripsi" rows="3" class="w-full bg-slate-900 border-slate-600 rounded-lg text-white">{{ old('deskripsi', $event->deskripsi) }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-400 mb-1">Ganti Poster (Opsional)</label>
                                    <div class="flex items-center gap-4 bg-slate-900 p-3 rounded-lg border border-slate-600">
                                        @if($event->image)
                                            <img src="{{ asset('storage/' . $event->image) }}" class="w-16 h-16 object-cover rounded border border-white/20">
                                        @endif
                                        <input type="file" name="image" class="w-full text-gray-400 text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pb-8">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl font-bold text-white">2. Edit Tiket</h3>
                                <button type="button" onclick="addTicketRow()" class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded font-bold text-sm flex items-center gap-2">
                                    + Tambah Tiket Baru
                                </button>
                            </div>

                            <div id="ticket-container" class="space-y-4">
                                @foreach($event->tickets as $index => $ticket)
                                <div class="bg-slate-900/50 p-4 rounded-lg border border-slate-700 relative">
                                    <input type="hidden" name="tickets[{{$index}}][id]" value="{{ $ticket->id }}">
                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
                                        <div class="md:col-span-3">
                                            <label class="block text-xs text-gray-400 mb-1">Nama Tiket</label>
                                            <input type="text" name="tickets[{{$index}}][name]" value="{{ $ticket->name }}" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm" required>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs text-gray-400 mb-1">Harga</label>
                                            <input type="number" name="tickets[{{$index}}][harga]" value="{{ $ticket->harga }}" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm" required>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs text-gray-400 mb-1">Stok</label>
                                            <input type="number" name="tickets[{{$index}}][kuota]" value="{{ $ticket->kuota }}" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm" required>
                                        </div>
                                        <div class="md:col-span-5">
                                            <label class="block text-xs text-gray-400 mb-1">Deskripsi</label>
                                            <input type="text" name="tickets[{{$index}}][deskripsi]" value="{{ $ticket->deskripsi }}" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 border-t border-white/10 pt-6">
                            <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('organizer.dashboard') }}" class="px-6 py-3 bg-slate-700 text-white rounded-lg font-bold hover:bg-slate-600 transition">
                                BATAL
                            </a>
                            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-lg font-bold hover:from-blue-500 hover:to-cyan-500 shadow-lg transition transform hover:scale-105">
                                UPDATE EVENT
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let ticketCount = {{ $event->tickets->count() }};

        function addTicketRow() {
            const container = document.getElementById('ticket-container');
            const newRow = document.createElement('div');
            
            // PERBAIKAN: Menambahkan class 'ticket-item'
            newRow.classList.add('ticket-item', 'bg-slate-900/50', 'p-4', 'rounded-lg', 'border', 'border-green-500/30', 'relative', 'mt-4');
            
            newRow.innerHTML = `
                <div class="absolute -top-3 left-3 bg-green-600 text-white text-[10px] px-2 py-0.5 rounded shadow">BARU</div>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
                    <div class="md:col-span-3">
                        <label class="block text-xs text-gray-400 mb-1">Nama Tiket</label>
                        <input type="text" name="tickets[${ticketCount}][name]" placeholder="Tiket Baru" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs text-gray-400 mb-1">Harga</label>
                        <input type="number" name="tickets[${ticketCount}][harga]" placeholder="0" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs text-gray-400 mb-1">Stok</label>
                        <input type="number" name="tickets[${ticketCount}][kuota]" placeholder="0" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm" required>
                    </div>
                    <div class="md:col-span-4">
                        <label class="block text-xs text-gray-400 mb-1">Deskripsi</label>
                        <input type="text" name="tickets[${ticketCount}][deskripsi]" placeholder="Benefit..." class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm">
                    </div>
                    <div class="md:col-span-1 flex items-end h-full pb-1">
                        <button type="button" onclick="this.closest('.ticket-item').remove()" class="text-red-500 hover:text-red-400 font-bold text-xl" title="Hapus Baris">✕</button>
                    </div>
                </div>
            `;
            
            container.appendChild(newRow);
            ticketCount++;
        }
    </script>
</x-app-layout>