<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-fuchsia-400 leading-tight font-display">
            {{ __('Buat Event Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
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
                    
                    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        <div class="border-b border-white/10 pb-8">
                            <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                                <span class="w-8 h-8 rounded-full bg-fuchsia-600 flex items-center justify-center text-sm">1</span>
                                Detail Konser
                            </h3>
                            
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label class="block text-sm font-bold mb-2 text-gray-400">Nama Event / Artis</label>
                                    <input type="text" name="name" class="w-full bg-slate-900 border-slate-600 rounded-lg text-white focus:border-fuchsia-500 focus:ring-fuchsia-500" placeholder="Contoh: Konser Tulus" value="{{ old('name') }}" required>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-bold mb-2 text-gray-400">Kategori</label>
                                        <select name="kategori" class="w-full bg-slate-900 border-slate-600 rounded-lg text-white focus:border-fuchsia-500">
                                            <option value="Musik Pop">Musik Pop</option>
                                            <option value="Rock Metal">Rock / Metal</option>
                                            <option value="Jazz">Jazz / Blues</option>
                                            <option value="Indie">Indie / Folk</option>
                                            <option value="EDM">EDM / DJ</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-2 text-gray-400">Tanggal & Waktu</label>
                                        <input type="datetime-local" name="tanggal" class="w-full bg-slate-900 border-slate-600 rounded-lg text-white focus:border-fuchsia-500" value="{{ old('tanggal') }}" required>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold mb-2 text-gray-400">Lokasi & Kota</label>
                                    <input type="text" name="lokasi" class="w-full bg-slate-900 border-slate-600 rounded-lg text-white focus:border-fuchsia-500" placeholder="Contoh: Stadion GBK, Jakarta" value="{{ old('lokasi') }}" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold mb-2 text-gray-400">Deskripsi Event</label>
                                    <textarea name="deskripsi" rows="4" class="w-full bg-slate-900 border-slate-600 rounded-lg text-white focus:border-fuchsia-500" placeholder="Jelaskan detail acara...">{{ old('deskripsi') }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold mb-2 text-gray-400">Poster</label>
                                    <input type="file" name="image" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-fuchsia-600 file:text-white hover:file:bg-fuchsia-700 cursor-pointer bg-slate-900 border border-slate-600 rounded-lg" required>
                                </div>
                            </div>
                        </div>

                        <div class="pb-8">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                                    <span class="w-8 h-8 rounded-full bg-cyan-600 flex items-center justify-center text-sm">2</span>
                                    Atur Tiket
                                </h3>
                                <button type="button" onclick="addTicketRow()" class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded font-bold text-sm flex items-center gap-2 transition shadow-lg">
                                    + Tambah Tiket Lain
                                </button>
                            </div>

                            <div id="ticket-container" class="space-y-4">
                                
                                <div class="bg-slate-900/50 p-4 rounded-lg border border-slate-700">
                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
                                        <div class="md:col-span-3">
                                            <label class="block text-xs text-gray-400 mb-1">Nama Tiket</label>
                                            <input type="text" name="tickets[0][name]" placeholder="Contoh: Presale 1" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm" required>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs text-gray-400 mb-1">Harga (Rp)</label>
                                            <input type="number" name="tickets[0][harga]" placeholder="150000" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm" required>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs text-gray-400 mb-1">Stok</label>
                                            <input type="number" name="tickets[0][kuota]" placeholder="100" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm" required>
                                        </div>
                                        <div class="md:col-span-5">
                                            <label class="block text-xs text-gray-400 mb-1">Deskripsi / Benefit</label>
                                            <input type="text" name="tickets[0][deskripsi]" placeholder="Benefit..." class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="flex justify-end gap-4 border-t border-white/10 pt-6">
                            <a href="{{ route('organizer.dashboard') }}" class="px-6 py-3 bg-slate-700 text-white rounded-lg font-bold hover:bg-slate-600 transition">
                                BATAL
                            </a>
                            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-fuchsia-600 to-purple-600 text-white rounded-lg font-bold hover:from-fuchsia-500 hover:to-purple-500 shadow-lg transition transform hover:scale-105">
                                TERBITKAN EVENT
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let ticketCount = 1;

        function addTicketRow() {
            const container = document.getElementById('ticket-container');
            const newRow = document.createElement('div');
            
            // Tambahkan class 'ticket-item' agar mudah dihapus
            newRow.classList.add('ticket-item', 'bg-slate-900/50', 'p-4', 'rounded-lg', 'border', 'border-slate-700', 'relative', 'mt-4');
            
            newRow.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
                    <div class="md:col-span-3">
                        <label class="block text-xs text-gray-400 mb-1">Nama Tiket</label>
                        <input type="text" name="tickets[${ticketCount}][name]" placeholder="Tiket Tambahan" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm" required>
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