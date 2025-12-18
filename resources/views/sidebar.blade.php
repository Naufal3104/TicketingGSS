<div id="sideBar" class="relative flex flex-col flex-wrap bg-white border-r border-gray-300 p-6 flex-none w-64 md:-ml-64 md:fixed md:top-0 md:z-30 md:h-screen md:shadow-xl animated faster">

    <div class="flex flex-col">

        <div class="text-right hidden md:block mb-4">
            <button id="sideBarHideBtn">
                <i class="fad fa-times-circle"></i>
            </button>
        </div>
        <p class="uppercase text-xs text-gray-600 mb-4 tracking-wider">homes</p>

        <a href="{{ route('dashboard-ecommerce') }}" class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-chart-pie text-xs mr-2"></i>
            Performance Report
        </a>

        <a href="{{ route('monitoring.index') }}" class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-desktop text-xs mr-2"></i>
            Monitoring Dashboard
        </a>

        <p class="uppercase text-xs text-gray-600 mb-4 mt-4 tracking-wider">Operational</p>

        <a href="{{ route('customers.index') }}" class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-users text-xs mr-2"></i>
            Data Customer
        </a>

        <a href="{{ route('tickets.index') }}" class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-ticket-alt text-xs mr-2"></i>
            List Tiket
        </a>

        {{-- <a href="{{ route('tickets.create') }}" class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-plus-circle text-xs mr-2"></i>
            Buat Tiket Baru
        </a> --}}

        <a href="{{ route('assignments.open') }}" class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-tasks text-xs mr-2"></i>
            Job Pool (Tugas)
        </a>

        <p class="uppercase text-xs text-gray-600 mb-4 mt-4 tracking-wider">Finance & Tools</p>

        <a href="{{ route('invoices.index') }}" class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-file-invoice-dollar text-xs mr-2"></i>
            Invoices
        </a>

        <a href="{{ route('calendar') }}" class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-calendar-alt text-xs mr-2"></i>
            Calendar
        </a>

        </div>
    </div>