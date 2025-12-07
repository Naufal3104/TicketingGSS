@extends('app')
@section('title', 'Data Master Customer')
@section('content')

    <div class="bg-gray-100 flex-1 p-6 md:mt-16">
        
        {{-- Pesan Sukses --}}
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h1 class="h5">Data Master Customer</h1>
            
            <a href="{{ route('customers.create') }}" class="btn-bs-primary shadow-md hover:shadow-xl transition-all mt-4 md:mt-0">
                <i class="fad fa-plus mr-2"></i> Tambah Customer
            </a>
        </div>

        <div class="card bg-white border rounded shadow-md w-full">
            
            <form action="{{ route('customers.index') }}" method="GET">
                <div class="card-header border-b border-gray-200 flex justify-between items-center p-4">
                    <div class="text-sm text-gray-600">
                        Menampilkan <span class="font-bold text-gray-900">{{ $customers->count() }}</span> dari <span class="font-bold text-gray-900">{{ $customers->total() }}</span> data
                    </div>
                    <div class="flex items-center">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/ID..." class="border border-gray-300 rounded p-2 text-sm focus:outline-none focus:border-indigo-300 transition-all w-40 md:w-64">
                        <button type="submit" class="ml-2 bg-indigo-500 text-white p-2 rounded text-sm hover:bg-indigo-600"><i class="fad fa-search"></i></button>
                    </div>
                </div>
            </form>

            <div class="card-body p-0 overflow-x-auto">
                <table class="w-full text-left border-collapse table-auto">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 text-xs uppercase tracking-wider font-bold border-b border-gray-200">
                            <th class="px-6 py-4">No.</th>
                            <th class="px-6 py-4">Nama Lengkap</th>
                            <th class="px-6 py-4">Email / Kontak</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        <?php $i = 1?>
                        @forelse($customers as $item)
                        <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-300 ease-in-out">
                            <td class="px-6 py-4 font-medium">{{ $i++}}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    {{-- Placeholder Avatar --}}
                                    <div class="w-8 h-8 rounded-full bg-indigo-200 flex items-center justify-center mr-3 text-indigo-700 font-bold text-xs">
                                        {{ substr($item->customer_name, 0, 2) }}
                                    </div>
                                    <span class="font-bold text-gray-800">{{ $item->customer_name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span>{{ $item->email ?? '-' }}</span>
                                    <span class="text-xs text-gray-500">{{ $item->phone_number }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($item->status == 'ACTIVE')
                                    <span class="bg-green-200 text-green-700 py-1 px-3 rounded-full text-xs font-bold">Aktif</span>
                                @else
                                    <span class="bg-red-200 text-red-700 py-1 px-3 rounded-full text-xs font-bold">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex item-center justify-center space-x-2">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('customers.edit', $item->customer_id) }}" class="w-4 transform hover:text-indigo-700 hover:scale-110 transition-transform" title="Edit">
                                        <i class="fad fa-pencil"></i>
                                    </a>

                                    {{-- Tombol Delete (Harus pakai Form) --}}
                                    <form action="{{ route('customers.destroy', $item->customer_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-4 transform hover:text-red-500 hover:scale-110 transition-transform bg-transparent border-none cursor-pointer" title="Hapus">
                                            <i class="fad fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">Belum ada data customer.</td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            <div class="card-footer border-t border-gray-200 bg-gray-50 p-4">
                {{ $customers->links() }} {{-- Pagination Laravel --}}
            </div>

        </div>
    </div>
@endsection