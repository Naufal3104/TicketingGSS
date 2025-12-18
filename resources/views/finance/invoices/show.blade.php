<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invoice Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
            @endif

            @if(session('warning'))
            <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
                {{ session('warning') }}
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200" id="invoice-paper">
                <div class="p-8">

                    <!-- Header -->
                    <div class="flex justify-between items-start mb-8 border-b pb-4">
                        <div>
                            <h1 class="text-4xl font-bold text-gray-800">INVOICE</h1>
                            <span class="inline-block mt-2 px-3 py-1 rounded-full text-sm font-semibold 
                                @if($invoice->status == 'PAID') bg-green-100 text-green-800 
                                @elseif($invoice->status == 'CANCELLED') bg-red-100 text-red-800 
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $invoice->status }}
                            </span>
                        </div>
                        <div class="text-right">
                            <h3 class="font-bold text-xl">GSS Ticketing</h3>
                            <p class="text-gray-600">Jl. Teknologi No. 12<br>Jakarta, Indonesia</p>
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="flex justify-between mb-8">
                        <div>
                            <h4 class="font-bold text-gray-600 mb-1">Bill To:</h4>
                            <p class="font-bold text-lg">{{ $invoice->ticket->customer->customer_name }}</p>
                            <p>{{ $invoice->ticket->customer->customer_address ?? 'No Address' }}</p>
                        </div>
                        <div class="text-right">
                            <p><strong>Invoice ID:</strong> {{ $invoice->invoice_id }}</p>
                            <p><strong>Date:</strong> {{ $invoice->created_at->format('d M Y') }}</p>
                            <p><strong>Ticket Ref:</strong> {{ $invoice->visit_ticket_id }}</p>
                            <p><strong>Sales:</strong> {{ $invoice->sales->name ?? 'System' }}</p>
                        </div>
                    </div>

                    <!-- Items -->
                    <table class="w-full mb-8">
                        <thead>
                            <tr class="border-b-2 border-gray-800">
                                <th class="text-left py-2">Description</th>
                                <th class="text-right py-2">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-200">
                                <td class="py-4">
                                    <p class="font-bold">Visitation Service</p>
                                    <p class="text-sm text-gray-600">{{ $invoice->ticket->issue_category }} - {{ $invoice->ticket->issue_description }}</p>
                                </td>
                                <td class="text-right py-4">Rp {{ number_format($invoice->amount_base, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Totals -->
                    <div class="flex justify-end mb-8">
                        <div class="w-1/2">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-bold">Rp {{ number_format($invoice->amount_base, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between mb-2 text-red-500">
                                <span class="text-gray-600">Discount</span>
                                <span>- Rp {{ number_format($invoice->amount_discount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between border-t border-gray-800 pt-2">
                                <span class="font-bold text-xl">Total</span>
                                <span class="font-bold text-xl">Rp {{ number_format($invoice->amount_final, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="border-t pt-6 bg-gray-50 -mx-8 -mb-8 p-8 flex justify-between items-center rounded-b-lg">

                        <!-- Status Controls -->
                        <form action="{{ route('invoices.update', $invoice->invoice_id) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PUT')
                            <label class="font-bold text-sm text-gray-700">Update Status:</label>
                            <select name="status" onchange="this.form.submit()" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="DRAFT" {{ $invoice->status == 'DRAFT' ? 'selected' : '' }}>DRAFT</option>
                                <option value="SENT" {{ $invoice->status == 'SENT' ? 'selected' : '' }}>SENT</option>
                                <option value="PAID" {{ $invoice->status == 'PAID' ? 'selected' : '' }}>PAID</option>
                                <option value="CANCELLED" {{ $invoice->status == 'CANCELLED' ? 'selected' : '' }}>CANCELLED</option>
                            </select>
                        </form>

                        <div>
                            <button onclick="window.print()" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z" />
                                </svg>
                                Print / Save PDF
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>