<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Pool & My Assignments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Tabs Navigation -->
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="open-pool-tab" data-tabs-target="#open-pool" type="button" role="tab" aria-controls="open-pool" aria-selected="true" onclick="switchTab('open-pool')">
                            Open Pool ({{ $openTickets->count() }})
                        </button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="my-jobs-tab" data-tabs-target="#my-jobs" type="button" role="tab" aria-controls="my-jobs" aria-selected="false" onclick="switchTab('my-jobs')">
                            My Jobs ({{ $myAssignments->count() }})
                        </button>
                    </li>
                </ul>
            </div>

            <div id="myTabContent">
                <!-- Open Pool Content -->
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="open-pool" role="tabpanel" aria-labelledby="open-pool-tab">

                    @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        {{ session('error') }}
                    </div>
                    @endif

                    @forelse($openTickets as $ticket)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 p-4 border-l-4 border-blue-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-lg">{{ $ticket->issue_category }}</h3>
                                <p class="text-sm text-gray-600">{{ $ticket->visit_address }}</p>
                                <p class="text-xs text-gray-500 mt-1">Ref: {{ $ticket->visit_ticket_id }}</p>
                            </div>
                            <span class="bg-{{ $ticket->priority_level == 'URGENT' ? 'red' : ($ticket->priority_level == 'HIGH' ? 'orange' : 'blue') }}-100 text-{{ $ticket->priority_level == 'URGENT' ? 'red' : ($ticket->priority_level == 'HIGH' ? 'orange' : 'blue') }}-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                {{ $ticket->priority_level }}
                            </span>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-sm text-gray-500">{{ $ticket->created_at->diffForHumans() }}</span>
                            <button onclick="takeJob('{{ $ticket->visit_ticket_id }}', this)" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                AMBIL JOB
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10 text-gray-500">
                        No open jobs available at the moment.
                    </div>
                    @endforelse
                </div>

                <!-- My Jobs Content -->
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="my-jobs" role="tabpanel" aria-labelledby="my-jobs-tab">
                    @forelse($myAssignments as $assignment)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 p-4 border-l-4 border-green-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-lg">{{ $assignment->ticket->issue_category }}</h3>
                                <p class="text-sm text-gray-600">{{ $assignment->ticket->visit_address }}</p>
                                <p class="text-xs text-gray-500 mt-1">Status: {{ $assignment->status }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="#" class="block text-center bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-sm">
                                View Details
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10 text-gray-500">
                        You have no active assignments.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Simple Tab Script & AJAX -->
    <script>
        // Init: Show Open Pool
        document.getElementById('open-pool').classList.remove('hidden');
        document.getElementById('open-pool-tab').classList.add('text-blue-600', 'border-blue-600');

        function switchTab(tabId) {
            // Hide all
            document.getElementById('open-pool').classList.add('hidden');
            document.getElementById('my-jobs').classList.add('hidden');

            // Reset buttons
            document.getElementById('open-pool-tab').classList.remove('text-blue-600', 'border-blue-600');
            document.getElementById('my-jobs-tab').classList.remove('text-blue-600', 'border-blue-600');

            // Show selected
            document.getElementById(tabId).classList.remove('hidden');
            document.getElementById(tabId + '-tab').classList.add('text-blue-600', 'border-blue-600');
        }

        function takeJob(ticketId, btn) {
            if (!confirm('Are you sure you want to take this job?')) return;

            // Disable button
            btn.disabled = true;
            btn.innerText = 'Processing...';
            btn.classList.add('opacity-50', 'cursor-not-allowed');

            fetch("{{ route('assignments.take') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        visit_ticket_id: ticketId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Job taken successfully!');
                        window.location.reload();
                    } else {
                        alert('Failed: ' + data.message);
                        // Re-enable
                        btn.disabled = false;
                        btn.innerText = 'AMBIL JOB';
                        btn.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                    btn.disabled = false;
                    btn.innerText = 'AMBIL JOB';
                    btn.classList.remove('opacity-50', 'cursor-not-allowed');
                });
        }
    </script>
</x-app-layout>