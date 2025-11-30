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
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-slate-800 overflow-hidden shadow-xl sm:rounded-lg border border-white/10">
                <div class="p-8 text-gray-100">
                    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        <div class="border-b border-white/10 pb-8">
                            <h3 class="text-xl font-bold text-white mb-6">1. Detail Konser</h3>
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label class="block text-sm font-bold mb-2 text-gray-400">Nama Event / Artis</label>
                                    <input type="text" name="name" class="w-full bg-slate-900 border-slate-600 rounded-lg text-white" required>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-bold mb-2 text-gray-400">Kategori</label>
                                        <select name="kategori" class="w-full bg-slate-900 border-slate-600 rounded-lg text-white">
                                            <option>Musik Pop</option><option>Rock Metal</option><option>Jazz</option><option>Dangdut</option><option>Dj</option><option>Indie</option><option>EDM</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-2 text-gray-400">Tanggal</label>
                                        <input type="datetime-local" name="tanggal" class="w-full bg-slate-900 border-slate-600 rounded-lg text-white" required>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold mb-2 text-gray-400">Lokasi</label>
                                    <input type="text" name="lokasi" class="w-full bg-slate-900 border-slate-600 rounded-lg text-white" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold mb-2 text-gray-400">Deskripsi</label>
                                    <textarea name="deskripsi" rows="4" class="w-full bg-slate-900 border-slate-600 rounded-lg text-white"></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold mb-2 text-gray-400">Poster</label>
                                    <input type="file" name="image" class="w-full text-gray-400 bg-slate-900 border border-slate-600 rounded-lg" required>
                                </div>
                            </div>
                        </div>

                        <div class="pb-8">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl font-bold text-white">2. Atur Tiket</h3>
                                <button type="button" onclick="addTicketRow()" class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded font-bold text-sm">+ Tambah Tiket</button>
                            </div>

                            <div id="ticket-container" class="space-y-4">
                                <div class="ticket-item bg-slate-900/50 p-4 rounded-lg border border-slate-700">
                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
                                        <div class="md:col-span-3">
                                            <label class="block text-xs text-gray-400 mb-1">Nama</label>
                                            <input type="text" name="tickets[0][name]" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm" required>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs text-gray-400 mb-1">Harga</label>
                                            <input type="number" name="tickets[0][harga]" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm" required>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs text-gray-400 mb-1">Stok</label>
                                            <input type="number" name="tickets[0][kuota]" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm" required>
                                        </div>
                                        <div class="md:col-span-5">
                                            <label class="block text-xs text-gray-400 mb-1">Deskripsi</label>
                                            <input type="text" name="tickets[0][deskripsi]" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 border-t border-white/10 pt-6">
                            <button type="submit" class="bg-fuchsia-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-fuchsia-700 w-full md:w-auto">TERBITKAN</button>
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
            newRow.classList.add('ticket-item', 'bg-slate-900/50', 'p-4', 'rounded-lg', 'border', 'border-slate-700', 'relative', 'mt-4');
            
            newRow.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
                    <div class="md:col-span-3">
                        <label class="block text-xs text-gray-400 mb-1">Nama</label>
                        <input type="text" name="tickets[${ticketCount}][name]" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs text-gray-400 mb-1">Harga</label>
                        <input type="number" name="tickets[${ticketCount}][harga]" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs text-gray-400 mb-1">Stok</label>
                        <input type="number" name="tickets[${ticketCount}][kuota]" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm" required>
                    </div>
                    <div class="md:col-span-4">
                        <label class="block text-xs text-gray-400 mb-1">Deskripsi</label>
                        <input type="text" name="tickets[${ticketCount}][deskripsi]" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm">
                    </div>
                    <div class="md:col-span-1 flex items-end h-full pb-1">
                        <button type="button" onclick="this.closest('.ticket-item').remove()" class="text-red-500 font-bold text-xl">✕</button>
                    </div>
                </div>
            `;
            container.appendChild(newRow);
            ticketCount++;
        }
    </script>
</x-app-layout>