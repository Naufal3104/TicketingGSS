@extends('app')
@section('title', isset($customer) ? 'Edit Customer' : 'Input Customer')
@section('content')

    <div class="bg-gray-100 flex-1 p-6 md:mt-16">

        <h1 class="h5 mb-6">{{ isset($customer) ? 'Edit Data Customer' : 'Form Input Data Customer' }}</h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="card bg-white border rounded shadow-md col-span-2 lg:col-span-2">

                <div class="card-header border-b border-gray-200">
                    <h2 class="font-bold text-gray-800">Informasi Customer</h2>
                </div>

                <div class="card-body">
                    {{-- 
                        LOGIKA FORM:
                        Jika ada $customer, arahkan ke route update (PUT).
                        Jika tidak, arahkan ke route store (POST).
                    --}}
                    <form
                        action="{{ isset($customer) ? route('customers.update', $customer->customer_id) : route('customers.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($customer))
                            @method('PUT')
                        @endif
                        <input
                            class="w-full border border-gray-300 rounded p-3 text-gray-700 focus:outline-none focus:border-indigo-300"
                            type="hidden" name="customer_id" value="{{ old('customer_id', $customer->customer_id ?? '') }}"
                            placeholder="Contoh: CUST-001" {{ isset($customer) ? 'readonly' : '' }}>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input
                                    class="w-full border border-gray-300 rounded p-3 text-gray-700 focus:outline-none focus:border-indigo-300 transition-all duration-300"
                                    type="text" name="customer_name"
                                    value="{{ old('customer_name', $customer->customer_name ?? '') }}"
                                    placeholder="Masukkan nama lengkap">
                                @error('customer_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                                    Nomor Telepon
                                </label>
                                <input
                                    class="w-full border border-gray-300 rounded p-3 text-gray-700 focus:outline-none focus:border-indigo-300 transition-all duration-300"
                                    type="text" name="phone_number"
                                    value="{{ old('phone_number', $customer->phone_number ?? '') }}" placeholder="081xxxxx">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                                Alamat Email
                            </label>
                            <div class="flex items-center border border-gray-300 rounded overflow-hidden">
                                <div class="px-3 bg-gray-100 border-r border-gray-300">
                                    <i class="fad fa-envelope text-gray-600"></i>
                                </div>
                                <input class="w-full p-3 text-gray-700 focus:outline-none" type="email" name="email"
                                    value="{{ old('email', $customer->email ?? '') }}" placeholder="contoh@email.com">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                                Status
                            </label>
                            <select name="status"
                                class="w-full border border-gray-300 rounded p-3 text-gray-700 focus:outline-none bg-white">
                                <option value="ACTIVE"
                                    {{ old('status', $customer->status ?? '') == 'ACTIVE' ? 'selected' : '' }}>Active
                                </option>
                                <option value="INACTIVE"
                                    {{ old('status', $customer->status ?? '') == 'INACTIVE' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                                Alamat Lengkap
                            </label>
                            <textarea
                                class="w-full border border-gray-300 rounded p-3 text-gray-700 h-32 focus:outline-none focus:border-indigo-300"
                                name="address_primary" placeholder="Tuliskan alamat lengkap di sini...">{{ old('address_primary', $customer->address_primary ?? '') }}</textarea>
                        </div>

                        <div class="card-footer bg-gray-100 border-t border-gray-200 flex justify-end">
                            <a href="{{ route('customers.index') }}"
                                class="btn-gray mr-3 py-2 px-4 rounded text-gray-600 hover:bg-gray-200">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-indigo-600 text-white py-2 px-4 rounded shadow-md hover:shadow-xl transition-all hover:bg-indigo-700">
                                <i class="fad fa-save mr-2"></i> {{ isset($customer) ? 'Update Data' : 'Simpan Data' }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection
