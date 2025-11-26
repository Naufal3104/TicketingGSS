@extends('app')
@section('title', 'Data Master Karyawan')
@section('content')

    <div class="bg-gray-100 flex-1 p-6 md:mt-16">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h1 class="h5">Data Master Karyawan</h1>
            
            <a href="#" class="btn-bs-primary shadow-md hover:shadow-xl transition-all mt-4 md:mt-0">
                <i class="fad fa-plus mr-2"></i> Tambah Karyawan
            </a>
        </div>

        <div class="card bg-white border rounded shadow-md w-full">
            
            <div class="card-header border-b border-gray-200 flex justify-between items-center p-4">
                <div class="text-sm text-gray-600">
                    Menampilkan <span class="font-bold text-gray-900">10</span> dari <span class="font-bold text-gray-900">54</span> data
                </div>
                <div class="flex items-center">
                    <input type="text" placeholder="Cari data..." class="border border-gray-300 rounded p-2 text-sm focus:outline-none focus:border-indigo-300 transition-all w-40 md:w-64">
                </div>
            </div>

            <div class="card-body p-0 overflow-x-auto">
                <table class="w-full text-left border-collapse table-auto">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 text-xs uppercase tracking-wider font-bold border-b border-gray-200">
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">Nama Lengkap</th>
                            <th class="px-6 py-4">Jabatan</th>
                            <th class="px-6 py-4">Tanggal Gabung</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        
                        <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-300 ease-in-out">
                            <td class="px-6 py-4 font-medium">1</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full overflow-hidden mr-3 border border-gray-200">
                                        <img src="img/user1.jpg" alt="Avatar" class="object-cover w-full h-full">
                                    </div>
                                    <span class="font-bold text-gray-800">Budi Santoso</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">Senior Developer</td>
                            <td class="px-6 py-4">12 Jan 2023</td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-green-200 text-green-700 py-1 px-3 rounded-full text-xs font-bold">Aktif</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex item-center justify-center">
                                    <a href="#" class="w-4 mr-2 transform hover:text-indigo-700 hover:scale-110 transition-transform">
                                        <i class="fad fa-pencil"></i>
                                    </a>
                                    <a href="#" class="w-4 transform hover:text-red-500 hover:scale-110 transition-transform">
                                        <i class="fad fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-300 ease-in-out">
                            <td class="px-6 py-4 font-medium">2</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-indigo-200 flex items-center justify-center mr-3 text-indigo-700 font-bold text-xs">
                                        SR
                                    </div>
                                    <span class="font-bold text-gray-800">Siti Rahma</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">UI/UX Designer</td>
                            <td class="px-6 py-4">05 Feb 2023</td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-green-200 text-green-700 py-1 px-3 rounded-full text-xs font-bold">Aktif</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex item-center justify-center">
                                    <a href="#" class="w-4 mr-2 transform hover:text-indigo-700 hover:scale-110 transition-transform">
                                        <i class="fad fa-pencil"></i>
                                    </a>
                                    <a href="#" class="w-4 transform hover:text-red-500 hover:scale-110 transition-transform">
                                        <i class="fad fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-300 ease-in-out">
                            <td class="px-6 py-4 font-medium">3</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-yellow-200 flex items-center justify-center mr-3 text-yellow-700 font-bold text-xs">
                                        AD
                                    </div>
                                    <span class="font-bold text-gray-800">Andi Darmawan</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">Marketing</td>
                            <td class="px-6 py-4">10 Mar 2023</td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-gray-300 text-gray-600 py-1 px-3 rounded-full text-xs font-bold">Cuti</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex item-center justify-center">
                                    <a href="#" class="w-4 mr-2 transform hover:text-indigo-700 hover:scale-110 transition-transform">
                                        <i class="fad fa-pencil"></i>
                                    </a>
                                    <a href="#" class="w-4 transform hover:text-red-500 hover:scale-110 transition-transform">
                                        <i class="fad fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div class="card-footer border-t border-gray-200 bg-gray-50 flex justify-between items-center p-4">
                <button class="text-sm bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-300 rounded shadow-sm">
                    Previous
                </button>
                <div class="text-xs text-gray-600">
                    Page 1 of 5
                </div>
                <button class="text-sm bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-300 rounded shadow-sm">
                    Next
                </button>
            </div>

        </div>
    </div>

@endsection