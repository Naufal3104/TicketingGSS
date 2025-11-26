@extends('app')
@section('title', 'Ticketing')
@section('content')
    <div class="bg-gray-100 flex-1 p-6 md:mt-16 grid grid-cols-8">
        <div class="col-span-2 bg-white border rounded p-6 mr-8">
            <a href="#" class="btn-bs-dark uppercase tracking-wider">
                <i class="fad fa-layer-plus mr-2"></i>
                Compose
            </a>
            <hr class="my-6" />

            <ul>
                <li class="my-5 mt-0">
                    <a class="btn-indigo text-left" href="#">
                        <i class="text-xs fad fa-inbox mr-1"></i>
                        inbox
                    </a>
                </li>

                <li>
                    <a class="btn text-left text-gray-800 bg-white hover:bg-gray-100 hover:text-gray-900" href="#">
                        <i class="text-xs fad fa-paper-plane mr-1"></i>
                        sent
                    </a>
                </li>

                <li>
                    <a class="btn text-left text-gray-800 bg-white hover:bg-gray-100 hover:text-gray-900" href="#">
                        <i class="text-xs fad fa-star mr-1"></i>
                        Marked
                    </a>
                </li>

                <li>
                    <a class="btn text-left text-gray-800 bg-white hover:bg-gray-100 hover:text-gray-900" href="#">
                        <i class="text-xs fad fa-inbox-in mr-1"></i>
                        draft
                    </a>
                </li>

                <li>
                    <a class="btn text-left text-gray-800 bg-white hover:bg-gray-100 hover:text-gray-900" href="#">
                        <i class="text-xs fad fa-inbox-out mr-1"></i>
                        sent
                    </a>
                </li>

                <li>
                    <a class="btn text-left text-gray-800 bg-white hover:bg-gray-100 hover:text-gray-900" href="#">
                        <i class="text-xs fad fa-trash mr-1"></i>
                        trash
                    </a>
                </li>

                <!-- seprator -->
                <hr class="my-10" />

                <li>
                    <a class="btn text-left text-gray-800 bg-white hover:bg-gray-100 hover:text-gray-900" href="#">
                        <i class="text-indigo-700 fad fa-dot-circle mr-1"></i>
                        Custom Work
                    </a>
                </li>

                <li>
                    <a class="btn text-left text-gray-800 bg-white hover:bg-gray-100 hover:text-gray-900" href="#">
                        <i class="text-gray-700 fad fa-dot-circle mr-1"></i>
                        Important
                    </a>
                </li>

                <li>
                    <a class="btn text-left text-gray-800 bg-white hover:bg-gray-100 hover:text-gray-900" href="#">
                        <i class="text-green-700 fad fa-dot-circle mr-1"></i>
                        work
                    </a>
                </li>

                <li>
                    <a class="btn text-left text-gray-800 bg-white hover:bg-gray-100 hover:text-gray-900" href="#">
                        <i class="text-yellow-700 fad fa-dot-circle mr-1"></i>
                        design
                    </a>
                </li>

                <li>
                    <a class="btn text-left text-gray-800 bg-white hover:bg-gray-100 hover:text-gray-900" href="#">
                        <i class="text-red-700 fad fa-dot-circle mr-1"></i>
                        laravel
                    </a>
                </li>

                <li>
                    <a class="btn text-left text-gray-800 bg-white hover:bg-gray-100 hover:text-gray-900" href="#">
                        <i class="text-teal-800 fad fa-dot-circle mr-1"></i>
                        add new label
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-span-6 card flex flex-col">
            <div class="px-3 border-b">
                <form action="" class="flex">
                    <input class="p-3 flex-1" type="text" placeholder="search" />
                    <button type="submit" class="p-3">
                        <i class="fad fa-search"></i>
                    </button>
                </form>
            </div>

            <div class="flex-1 flex flex-col">
                <!-- message -->
                <div class="flex items-center shadow-xs transition-all duration-300 ease-in-out p-5 hover:shadow-md">
                    <div class="w-10 h-10 overflow-hidden rounded-md">
                        <img class="img-responsive" src="img/user1.jpg" alt="" />
                    </div>
                    <h1 class="ml-3">mohamed</h1>
                    <p class="ml-6 flex-1 text-xs">
                        page when looking at its layout looking at its layout The point
                        of using Lorem...
                    </p>
                    <p class="font-bold text-gray-900">05:09 AM</p>
                </div>
                <!-- message -->
                <!-- message -->
                <div class="flex items-center shadow-xs transition-all duration-300 ease-in-out p-5 hover:shadow-md">
                    <div class="w-10 h-10 overflow-hidden rounded-md">
                        <img class="img-responsive" src="img/user1.jpg" alt="" />
                    </div>
                    <h1 class="ml-3">mohamed</h1>
                    <p class="ml-6 flex-1 text-xs">
                        page when looking at its layout looking at its layout The point
                        of using Lorem...
                    </p>
                    <p class="font-bold text-gray-900">05:09 AM</p>
                </div>
                <!-- message -->
                <!-- message -->
                <div class="flex items-center shadow-xs transition-all duration-300 ease-in-out p-5 hover:shadow-md">
                    <div class="w-10 h-10 overflow-hidden rounded-md">
                        <img class="img-responsive" src="img/user1.jpg" alt="" />
                    </div>
                    <h1 class="ml-3">mohamed</h1>
                    <p class="ml-6 flex-1 text-xs">
                        page when looking at its layout looking at its layout The point
                        of using Lorem...
                    </p>
                    <p class="font-bold text-gray-900">05:09 AM</p>
                </div>
                <!-- message -->
                <!-- message -->
                <div class="flex items-center shadow-xs transition-all duration-300 ease-in-out p-5 hover:shadow-md">
                    <div class="w-10 h-10 overflow-hidden rounded-md">
                        <img class="img-responsive" src="img/user1.jpg" alt="" />
                    </div>
                    <h1 class="ml-3">mohamed</h1>
                    <p class="ml-6 flex-1 text-xs">
                        page when looking at its layout looking at its layout The point
                        of using Lorem...
                    </p>
                    <p class="font-bold text-gray-900">05:09 AM</p>
                </div>
                <!-- message -->
                <!-- message -->
                <div class="flex items-center shadow-xs transition-all duration-300 ease-in-out p-5 hover:shadow-md">
                    <div class="w-10 h-10 overflow-hidden rounded-md">
                        <img class="img-responsive" src="img/user1.jpg" alt="" />
                    </div>
                    <h1 class="ml-3">mohamed</h1>
                    <p class="ml-6 flex-1 text-xs">
                        page when looking at its layout looking at its layout The point
                        of using Lorem...
                    </p>
                    <p class="font-bold text-gray-900">05:09 AM</p>
                </div>
                <!-- message -->
                <!-- message -->
                <div class="flex items-center shadow-xs transition-all duration-300 ease-in-out p-5 hover:shadow-md">
                    <div class="w-10 h-10 overflow-hidden rounded-md">
                        <img class="img-responsive" src="img/user1.jpg" alt="" />
                    </div>
                    <h1 class="ml-3">mohamed</h1>
                    <p class="ml-6 flex-1 text-xs">
                        page when looking at its layout looking at its layout The point
                        of using Lorem...
                    </p>
                    <p class="font-bold text-gray-900">05:09 AM</p>
                </div>
                <!-- message -->
                <!-- message -->
                <div class="flex items-center shadow-xs transition-all duration-300 ease-in-out p-5 hover:shadow-md">
                    <div class="w-10 h-10 overflow-hidden rounded-md">
                        <img class="img-responsive" src="img/user1.jpg" alt="" />
                    </div>
                    <h1 class="ml-3">mohamed</h1>
                    <p class="ml-6 flex-1 text-xs">
                        page when looking at its layout looking at its layout The point
                        of using Lorem...
                    </p>
                    <p class="font-bold text-gray-900">05:09 AM</p>
                </div>
                <!-- message -->
                <!-- message -->
                <div class="flex items-center shadow-xs transition-all duration-300 ease-in-out p-5 hover:shadow-md">
                    <div class="w-10 h-10 overflow-hidden rounded-md">
                        <img class="img-responsive" src="img/user1.jpg" alt="" />
                    </div>
                    <h1 class="ml-3">mohamed</h1>
                    <p class="ml-6 flex-1 text-xs">
                        page when looking at its layout looking at its layout The point
                        of using Lorem...
                    </p>
                    <p class="font-bold text-gray-900">05:09 AM</p>
                </div>
                <!-- message -->
                <!-- message -->
                <div class="flex items-center shadow-xs transition-all duration-300 ease-in-out p-5 hover:shadow-md">
                    <div class="w-10 h-10 overflow-hidden rounded-md">
                        <img class="img-responsive" src="img/user1.jpg" alt="" />
                    </div>
                    <h1 class="ml-3">mohamed</h1>
                    <p class="ml-6 flex-1 text-xs">
                        page when looking at its layout looking at its layout The point
                        of using Lorem...
                    </p>
                    <p class="font-bold text-gray-900">05:09 AM</p>
                </div>
                <!-- message -->
            </div>

            <div class="card-footer flex justify-between">
                <p>4.41 GB (25%) of 17 GB used Manage</p>
                <p>Last account activity: 36 minutes ago</p>
            </div>
        </div>
    </div>
@endsection
