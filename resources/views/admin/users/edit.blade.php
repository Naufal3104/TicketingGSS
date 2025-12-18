@extends('app')
@section('title', 'Edit User')
@section('content')

<div class="bg-gray-100 flex-1 p-6 md:mt-16">

    <h1 class="h5 mb-6">Edit User</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="card bg-white border rounded shadow-md col-span-2 lg:col-span-2">

            <div class="card-header border-b border-gray-200">
                <h2 class="font-bold text-gray-800">Edit Informasi Akun User</h2>
            </div>

            <div class="card-body">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input
                                class="w-full border border-gray-300 rounded p-3 text-gray-700 focus:outline-none focus:border-indigo-300 transition-all duration-300"
                                type="text" name="name"
                                value="{{ old('name', $user->name) }}"
                                placeholder="Masukkan nama user">
                            @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input
                                class="w-full border border-gray-300 rounded p-3 text-gray-700 focus:outline-none focus:border-indigo-300 transition-all duration-300"
                                type="email" name="email"
                                value="{{ old('email', $user->email) }}" placeholder="contoh@email.com">
                            @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Password (Optional) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                                Password <span class="text-xs text-gray-500 normal-case">(Kosongkan jika tidak ingin mengubah)</span>
                            </label>
                            <input
                                class="w-full border border-gray-300 rounded p-3 text-gray-700 focus:outline-none focus:border-indigo-300"
                                type="password" name="password"
                                placeholder="**********">
                            @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                                Konfirmasi Password
                            </label>
                            <input
                                class="w-full border border-gray-300 rounded p-3 text-gray-700 focus:outline-none focus:border-indigo-300"
                                type="password" name="password_confirmation"
                                placeholder="**********">
                        </div>
                    </div>

                    {{-- Role & Phone --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                                Role <span class="text-red-500">*</span>
                            </label>
                            <select name="roles[]" class="w-full border border-gray-300 rounded p-3 text-gray-700 focus:outline-none bg-white">
                                @foreach($roles as $role)
                                <option value="{{ $role }}" {{ (in_array($role, $userRole)) ? 'selected' : '' }}>{{ $role }}</option>
                                @endforeach
                            </select>
                            @error('roles')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                                No. Handphone
                            </label>
                            <input
                                class="w-full border border-gray-300 rounded p-3 text-gray-700 focus:outline-none focus:border-indigo-300"
                                type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                                placeholder="081xxx">
                        </div>
                    </div>

                    {{-- Telegram --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                            Telegram Chat ID
                        </label>
                        <input
                            class="w-full border border-gray-300 rounded p-3 text-gray-700 focus:outline-none focus:border-indigo-300"
                            type="text" name="telegram_chat_id" value="{{ old('telegram_chat_id', $user->telegram_chat_id) }}"
                            placeholder="ID Customer">
                    </div>

                    <div class="card-footer bg-gray-100 border-t border-gray-200 flex justify-end p-4">
                        <a href="{{ route('users.index') }}"
                            class="btn-gray mr-3 py-2 px-4 rounded text-gray-600 hover:bg-gray-200">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-indigo-600 text-white py-2 px-4 rounded shadow-md hover:shadow-xl transition-all hover:bg-indigo-700">
                            <i class="fad fa-save mr-2"></i> Update User
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

@endsection