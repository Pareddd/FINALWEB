<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-fuchsia-400 leading-tight font-display">
            {{ __('Buat Event Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
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
                            <h3 class="text-xl font-bold text-white mb-6">1. Detail Konser</h3>
                            
                            <div class="mb-6">
                                <label class="block text-sm font-bold mb-2 text-gray-400">Nama Event</label>
                                <input type="text" name="name" class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-fuchsia-500" value="{{ old('name') }}" required>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-bold mb-2 text-gray-400">Kategori</label>
                                    <select name="kategori" class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-fuchsia-500">
                                        <option value="Musik Pop">Musik Pop</option>
                                        <option value="Rock Metal">Rock / Metal</option>
                                        <option value="Jazz">Jazz / Blues</option>
                                        <option value="Indie">Indie / Folk</option>
                                        <option value="EDM">EDM / DJ</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold mb-2 text-gray-400">Tanggal & Waktu</label>
                                    <input type="datetime-local" name="tanggal" class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-fuchsia-500" value="{{ old('tanggal') }}" required>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-bold mb-2 text-gray-400">Lokasi Venue</label>
                                <input type="text" name="lokasi" class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-fuchsia-500" value="{{ old('lokasi') }}" required>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-bold mb-2 text-gray-400">Deskripsi Event</label>
                                <textarea name="deskripsi" rows="4" class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-fuchsia-500">{{ old('deskripsi') }}</textarea>
                            </div>

                            <div class="mb-2">
                                <label class="block text-sm font-bold mb-2 text-gray-400">Banner / Poster</label>
                                <input type="file" name="image" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-fuchsia-600 file:text-white hover:file:bg-fuchsia-700 cursor-pointer bg-slate-900 border border-slate-600 rounded-lg" required>
                                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WEBP. Maks: 10MB.</p>
                            </div>
                        </div>

                        <div class="border-b border-white/10 pb-8">
                            <h3 class="text-xl font-bold text-white mb-6">2. Tiket Pertama</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-bold mb-2 text-gray-400">Nama Tiket</label>
                                    <input type="text" name="ticket_name" class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-cyan-500" value="{{ old('ticket_name') }}" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold mb-2 text-gray-400">Harga (Rp)</label>
                                    <input type="number" name="ticket_harga" class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-cyan-500" value="{{ old('ticket_harga') }}" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold mb-2 text-gray-400">Stok Tiket</label>
                                    <input type="number" name="ticket_kuota" class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-cyan-500" value="{{ old('ticket_kuota') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4">
                            <a href="{{ route('organizer.dashboard') }}" class="px-6 py-3 bg-slate-700 text-white rounded-lg font-bold hover:bg-slate-600 transition">
                                BATAL
                            </a>
                            <button type="submit" class="px-8 py-3 bg-fuchsia-600 text-white rounded-lg font-bold hover:bg-fuchsia-700 shadow-lg transition transform hover:scale-105">
                                SIMPAN EVENT
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>