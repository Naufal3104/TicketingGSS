<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Draft Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Ticket Details Summary -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg border">
                        <h3 class="font-bold text-lg mb-2">Ticket Summary</h3>
                        <p><strong>Ticket ID:</strong> {{ $ticket->visit_ticket_id }}</p>
                        <p><strong>Customer:</strong> {{ $ticket->customer->customer_name }}</p>
                        <p><strong>Issue:</strong> {{ $ticket->issue_category }} - {{ $ticket->issue_description }}</p>
                        <p><strong>Completed Date:</strong> {{ $ticket->updated_at->format('d M Y') }}</p>
                    </div>

                    @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('invoices.store') }}">
                        @csrf
                        <input type="hidden" name="visit_ticket_id" value="{{ $ticket->visit_ticket_id }}">

                        <!-- Amount Base -->
                        <div class="mb-4">
                            <label for="amount_base" class="block text-gray-700 text-sm font-bold mb-2">Base Amount (IDR)</label>
                            <input type="number" name="amount_base" id="amount_base" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="e.g. 500000" required>
                        </div>

                        <!-- Amount Discount -->
                        <div class="mb-4">
                            <label for="amount_discount" class="block text-gray-700 text-sm font-bold mb-2">Discount (IDR) - Optional</label>
                            <input type="number" name="amount_discount" id="amount_discount" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="e.g. 0" value="0">
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Generate Draft Invoice
                            </button>
                            <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-gray-700 font-bold">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>