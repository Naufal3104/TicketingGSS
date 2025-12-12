<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Performance Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-bold mb-4">Technician Performance Ratings</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b text-left">Technician Name</th>
                                    <th class="py-2 px-4 border-b text-center">Total Reviews</th>
                                    <th class="py-2 px-4 border-b text-center">Average Rating</th>
                                    <th class="py-2 px-4 border-b text-center">Performance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tsRatings as $rating)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $rating->name }}</td>
                                    <td class="py-2 px-4 border-b text-center">{{ $rating->total_reviews }}</td>
                                    <td class="py-2 px-4 border-b text-center">
                                        <span class="font-bold text-lg text-yellow-500">
                                            {{ number_format($rating->avg_rating, 1) }} <i class="bx bxs-star"></i>
                                        </span>
                                    </td>
                                    <td class="py-2 px-4 border-b text-center">
                                        @if($rating->avg_rating >= 4.5)
                                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Excellent</span>
                                        @elseif($rating->avg_rating >= 4.0)
                                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">Good</span>
                                        @elseif($rating->avg_rating >= 3.0)
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">Average</span>
                                        @else
                                        <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">Poor</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-500">No ratings data available yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>