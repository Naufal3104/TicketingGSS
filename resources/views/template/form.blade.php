@extends('app')
@section('title', 'Input Data Pengguna')
@section('content')

    <div class="bg-gray-100 flex-1 p-6 md:mt-16">
        
        <h1 class="h5 mb-6">Form Input Data</h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <div class="card bg-white border rounded shadow-md col-span-2 lg:col-span-2">
                
                <div class="card-header border-b border-gray-200">
                    <h2 class="font-bold text-gray-800">Informasi Pengguna Baru</h2>
                </div>

                <div class="card-body">
                    <form action="#" method="POST">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                                    Nama Depan
                                </label>
                                <input class="w-full border border-gray-300 rounded p-3 text-gray-700 focus:outline-none focus:border-indigo-300 transition-all duration-300" 
                                       type="text" placeholder="Masukkan nama depan">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                                    Nama Belakang
                                </label>
                                <input class="w-full border border-gray-300 rounded p-3 text-gray-700 focus:outline-none focus:border-indigo-300 transition-all duration-300" 
                                       type="text" placeholder="Masukkan nama belakang">
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
                                <input class="w-full p-3 text-gray-700 focus:outline-none" 
                                       type="email" placeholder="contoh@email.com">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Kami tidak akan membagikan email Anda.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                                    Divisi / Jabatan
                                </label>
                                <select class="w-full border border-gray-300 rounded p-3 text-gray-700 focus:outline-none bg-white">
                                    <option>Pilih Divisi...</option>
                                    <option>IT Development</option>
                                    <option>Marketing</option>
                                    <option>Human Resources</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                                    Tanggal Bergabung
                                </label>
                                <input class="w-full border border-gray-300 rounded p-3 text-gray-700 focus:outline-none" 
                                       type="date">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                                Alamat Lengkap
                            </label>
                            <textarea class="w-full border border-gray-300 rounded p-3 text-gray-700 h-32 focus:outline-none focus:border-indigo-300" 
                                      placeholder="Tuliskan alamat lengkap di sini..."></textarea>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                                Upload Foto Profil
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-md p-6 text-center bg-gray-100 hover:bg-white hover:border-indigo-300 transition-all cursor-pointer">
                                <i class="fad fa-cloud-upload text-3xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-500">Klik untuk upload atau drag and drop</p>
                                <input type="file" class="hidden"> </div>
                        </div>

                        <div class="card-footer bg-gray-100 border-t border-gray-200 flex justify-end">
                            <a href="#" class="btn-gray mr-3">
                                Batal
                            </a>
                            <button type="submit" class="btn-bs-primary shadow-md hover:shadow-xl transition-all">
                                <i class="fad fa-save mr-2"></i> Simpan Data
                            </button>
                        </div>

                    </form>
                </div>
            </div>
            
            </div>
    </div>

@endsection