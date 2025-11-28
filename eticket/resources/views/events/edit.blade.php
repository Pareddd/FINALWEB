<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-fuchsia-400 leading-tight font-display">
            {{ __('Edit Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-slate-800 overflow-hidden shadow-xl sm:rounded-lg border border-white/10">
                <div class="p-8 text-gray-100">
                    
                    <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div class="border-b border-white/10 pb-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center font-bold">1</div>
                                <h3 class="text-xl font-bold text-white">Edit Detail Konser</h3>
                            </div>
                            
                            <div class="mb-6">
                                <label class="block text-sm font-bold mb-2 text-gray-400">Nama Event</label>
                                <input type="text" name="name" class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-fuchsia-500" value="{{ old('name', $event->name) }}" required>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-bold mb-2 text-gray-400">Kategori</label>
                                    <select name="kategori" class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-fuchsia-500">
                                        <option value="Musik Pop" {{ $event->kategori == 'Musik Pop' ? 'selected' : '' }}>Musik Pop</option>
                                        <option value="Rock Metal" {{ $event->kategori == 'Rock Metal' ? 'selected' : '' }}>Rock / Metal</option>
                                        <option value="Jazz" {{ $event->kategori == 'Jazz' ? 'selected' : '' }}>Jazz / Blues</option>
                                        <option value="Indie" {{ $event->kategori == 'Indie' ? 'selected' : '' }}>Indie / Folk</option>
                                        <option value="EDM" {{ $event->kategori == 'EDM' ? 'selected' : '' }}>EDM / DJ</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold mb-2 text-gray-400">Tanggal & Waktu</label>
                                    <input type="datetime-local" name="tanggal" class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-fuchsia-500" value="{{ old('tanggal', $event->tanggal) }}" required>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-bold mb-2 text-gray-400">Lokasi Venue</label>
                                <input type="text" name="lokasi" class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-fuchsia-500" value="{{ old('lokasi', $event->lokasi) }}" required>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-bold mb-2 text-gray-400">Deskripsi Event</label>
                                <textarea name="deskripsi" rows="4" class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-fuchsia-500">{{ old('deskripsi', $event->deskripsi) }}</textarea>
                            </div>

                            <div class="mb-2">
                                <label class="block text-sm font-bold mb-2 text-gray-400">Ganti Poster (Opsional)</label>
                                <div class="flex items-center gap-4 bg-slate-900 p-4 rounded-lg border border-slate-600">
                                    <img src="{{ asset('storage/' . $event->image) }}" class="w-20 h-20 object-cover rounded border border-white/20">
                                    <div class="w-full">
                                        <input type="file" name="image" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                                        <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-b border-white/10 pb-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-8 h-8 rounded-full bg-cyan-600 flex items-center justify-center font-bold">2</div>
                                <h3 class="text-xl font-bold text-white">Edit Tiket</h3>
                            </div>

                            @php $ticket = $event->tickets->first(); @endphp

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-bold mb-2 text-gray-400">Nama Tiket</label>
                                    <input type="text" name="ticket_name" class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-cyan-500" value="{{ old('ticket_name', $ticket->name ?? '') }}" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold mb-2 text-gray-400">Harga (Rp)</label>
                                    <input type="number" name="ticket_harga" class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-cyan-500" value="{{ old('ticket_harga', $ticket->harga ?? 0) }}" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold mb-2 text-gray-400">Stok Tiket</label>
                                    <input type="number" name="ticket_kuota" class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-cyan-500" value="{{ old('ticket_kuota', $ticket->kuota ?? 0) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4">
                            <a href="{{ route('organizer.dashboard') }}" class="px-6 py-3 bg-slate-700 text-white rounded-lg font-bold hover:bg-slate-600 transition">
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
</x-app-layout>