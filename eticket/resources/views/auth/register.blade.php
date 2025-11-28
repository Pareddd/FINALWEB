<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <h2 class="text-2xl font-bold text-white mb-6 text-center font-display">Buat Akun Baru</h2>

        <div>
            <label for="name" class="block font-medium text-sm text-gray-300">Nama Lengkap</label>
            <input id="name" class="block mt-1 w-full bg-slate-900 border-slate-600 text-white rounded-md shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="email" class="block font-medium text-sm text-gray-300">Email</label>
            <input id="email" class="block mt-1 w-full bg-slate-900 border-slate-600 text-white rounded-md shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="role" class="block font-medium text-sm text-gray-300">Daftar Sebagai</label>
            <select id="role" name="role" class="block mt-1 w-full bg-slate-900 border-slate-600 text-white rounded-md shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500">
                <option value="user">Pengunjung (Beli Tiket)</option>
                <option value="organizer">Event Organizer (Buat Event)</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-300">Password</label>
            <input id="password" class="block mt-1 w-full bg-slate-900 border-slate-600 text-white rounded-md shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="password_confirmation" class="block font-medium text-sm text-gray-300">Konfirmasi Password</label>
            <input id="password_confirmation" class="block mt-1 w-full bg-slate-900 border-slate-600 text-white rounded-md shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-gray-400 hover:text-white" href="{{ route('login') }}">
                {{ __('Sudah punya akun?') }}
            </a>

            <button type="submit" class="ms-4 bg-fuchsia-600 hover:bg-fuchsia-700 text-white font-bold py-2 px-4 rounded shadow-lg transition">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</x-guest-layout>