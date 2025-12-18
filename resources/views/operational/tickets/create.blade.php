<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('tickets.store') }}">
                        @csrf

                        <!-- Customer Selection -->
                        <div class="mb-4">
                            <label for="customer_id" class="block text-gray-700 text-sm font-bold mb-2">Customer</label>
                            <select name="customer_id" id="customer_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">-- Select Customer --</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->customer_id }}">
                                    {{ $customer->customer_name }} ({{ $customer->pic_name }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Priority -->
                        <div class="mb-4">
                            <label for="priority_level" class="block text-gray-700 text-sm font-bold mb-2">Priority Level</label>
                            <select name="priority_level" id="priority_level" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="LOW">LOW</option>
                                <option value="MEDIUM" selected>MEDIUM</option>
                                <option value="HIGH">HIGH</option>
                                <option value="URGENT">URGENT</option>
                            </select>
                        </div>

                        <!-- Issue Category -->
                        <div class="mb-4">
                            <label for="issue_category" class="block text-gray-700 text-sm font-bold mb-2">Issue Category</label>
                            <input type="text" name="issue_category" id="issue_category" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="e.g., Internet Down, Hardware Failure">
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="issue_description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                            <textarea name="issue_description" id="issue_description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                        </div>

                        <!-- Address -->
                        <div class="mb-4">
                            <label for="visit_address" class="block text-gray-700 text-sm font-bold mb-2">Visit Address</label>
                            <textarea name="visit_address" id="visit_address" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Full address location"></textarea>
                        </div>

                        <!-- Quota -->
                        <div class="mb-4">
                            <label for="ts_quota_needed" class="block text-gray-700 text-sm font-bold mb-2">Tech Support Quota Needed</label>
                            <input type="number" name="ts_quota_needed" id="ts_quota_needed" value="1" min="1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Create Ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>