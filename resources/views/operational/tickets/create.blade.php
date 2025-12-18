@extends('app')
@section('title', 'Buat Tiket Baru')
@section('content')

<div class="bg-gray-100 flex-1 p-6 md:mt-16">
    <h1 class="h5 mb-6">Buat Tiket Kunjungan Baru</h1>

    @if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card bg-white border rounded shadow-md col-span-2 lg:col-span-2">
        <div class="card-header border-b border-gray-200">
            <h2 class="font-bold text-gray-800">Form Tiket</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('tickets.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                            Customer
                        </label>
                        <select name="customer_id" class="w-full border border-gray-300 rounded p-3 text-gray-700 focus:outline-none bg-white">
                            <option value="">-- Pilih Customer --</option>
                            @foreach($customers as $customer)
                            <option value="{{ $customer->customer_id }}">
                                {{ $customer->customer_name }} ({{ $customer->pic_name }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                            Prioritas
                        </label>
                        <select name="priority_level" class="w-full border border-gray-300 rounded p-3 text-gray-700 focus:outline-none bg-white">
                            <option value="LOW">LOW</option>
                            <option value="MEDIUM" selected>MEDIUM</option>
                            <option value="HIGH">HIGH</option>
                            <option value="URGENT">URGENT</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                        Kategori Masalah
                    </label>
                    <div class="flex items-center border border-gray-300 rounded overflow-hidden">
                        <div class="px-3 bg-gray-100 border-r border-gray-300">
                            <i class="fad fa-tags text-gray-600"></i>
                        </div>
                        <input name="issue_category" class="w-full p-3 text-gray-700 focus:outline-none" type="text" placeholder="Contoh: Internet Mati, Router Rusak">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                        Kebutuhan Kuota Teknisi
                    </label>
                    <input type="number" name="ts_quota_needed" value="1" min="1" class="w-full border border-gray-300 rounded p-3 text-gray-700 focus:outline-none">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                        Deskripsi Masalah
                    </label>
                    <textarea name="issue_description" class="w-full border border-gray-300 rounded p-3 text-gray-700 h-24 focus:outline-none focus:border-indigo-300" placeholder="Jelaskan masalah secara detail..."></textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                        Alamat Kunjungan
                    </label>
                    <textarea name="visit_address" class="w-full border border-gray-300 rounded p-3 text-gray-700 h-24 focus:outline-none focus:border-indigo-300" placeholder="Alamat lengkap lokasi kunjungan..."></textarea>
                </div>

                <div class="card-footer bg-gray-100 border-t border-gray-200 flex justify-end">
                    <button type="submit" class="btn-bs-primary shadow-md hover:shadow-xl transition-all">
                        <i class="fad fa-save mr-2"></i> Buat Tiket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection