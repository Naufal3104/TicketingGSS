@extends('app')
@section('title', 'Laporan Performa Teknisi')
@section('content')

<div class="bg-gray-100 flex-1 p-6 md:mt-16">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <h1 class="h5">Laporan Performa Teknisi</h1>
    </div>

    <div class="card bg-white border rounded shadow-md w-full">
        <div class="card-header border-b border-gray-200 flex justify-between items-center p-4">
            <div class="text-sm text-gray-600">
                Menampilkan data performa teknisi
            </div>
        </div>

        <div class="card-body p-0 overflow-x-auto">
            <table class="w-full text-left border-collapse table-auto">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-xs uppercase tracking-wider font-bold border-b border-gray-200">
                        <th class="px-6 py-4">Nama Teknisi</th>
                        <th class="px-6 py-4 text-center">Total Review</th>
                        <th class="px-6 py-4 text-center">Rata-rata Rating</th>
                        <th class="px-6 py-4 text-center">Status Performa</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse ($tsRatings as $rating)
                    <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-300 ease-in-out">
                        <td class="px-6 py-4 font-bold text-gray-800">
                            {{ $rating->name }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $rating->total_reviews }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-bold text-yellow-600 text-base">
                                {{ number_format($rating->avg_rating, 1) }} <i class="fas fa-star"></i>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($rating->avg_rating >= 4.5)
                            <span class="bg-green-200 text-green-700 py-1 px-3 rounded-full text-xs font-bold">Excellent</span>
                            @elseif($rating->avg_rating >= 4.0)
                            <span class="bg-blue-200 text-blue-700 py-1 px-3 rounded-full text-xs font-bold">Good</span>
                            @elseif($rating->avg_rating >= 3.0)
                            <span class="bg-yellow-200 text-yellow-700 py-1 px-3 rounded-full text-xs font-bold">Average</span>
                            @else
                            <span class="bg-red-200 text-red-700 py-1 px-3 rounded-full text-xs font-bold">Poor</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data rating tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection