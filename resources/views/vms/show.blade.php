<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('vms.index') }}" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $vm->name }}
                </h2>
                <!-- Status Badge -->
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @switch($vm->status)
                        @case('available')
                            bg-green-100 text-green-800
                            @break
                        @case('rented')
                            bg-yellow-100 text-yellow-800
                            @break
                        @case('maintenance')
                            bg-red-100 text-red-800
                            @break
                        @case('offline')
                            bg-gray-100 text-gray-800
                            @break
                        @default
                            bg-gray-100 text-gray-800
                    @endswitch
                ">
                    {{ ucfirst($vm->status) }}
                </span>
            </div>
            
            <div class="flex space-x-3">
                @if($vm->status === 'available')
                    <button onclick="openRentModal()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Rent This VM
                    </button>
                @endif
                
                @if(auth()->user()->isAdmin())
                <a href="{{ route('vms.edit', $vm) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Main Information -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- VM Overview -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center mb-6">
                                <div class="p-4 bg-gray-100 rounded-lg">
                                    @switch($vm->os)
                                        @case('ubuntu')
                                            <svg class="w-12 h-12 text-orange-500" viewBox="0 0 24 24" fill="currentColor">
                                                <circle cx="12" cy="12" r="10" fill="#E95420"/>
                                                <text x="12" y="16" text-anchor="middle" font-size="8" fill="white" font-weight="bold">Ubuntu</text>
                                            </svg>
                                            @break
                                        @case('windows')
                                            <svg class="w-12 h-12 text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M0 3.5l9.5-1.3v9.3H0V3.5zm10.5-1.4L24 0v11.5H10.5V2.1zM0 12.5h9.5v9.3L0 20.5V12.5zm10.5 0H24V24l-13.5-1.8V12.5z"/>
                                            </svg>
                                            @break
                                        @case('centos')
                                            <svg class="w-12 h-12 text-purple-500" viewBox="0 0 24 24" fill="currentColor">
                                                <circle cx="12" cy="12" r="10" fill="#932279"/>
                                                <text x="12" y="16" text-anchor="middle" font-size="6" fill="white" font-weight="bold">CentOS</text>
                                            </svg>
                                            @break
                                        @case('debian')
                                            <svg class="w-12 h-12 text-red-500" viewBox="0 0 24 24" fill="currentColor">
                                                <circle cx="12" cy="12" r="10" fill="#A81D33"/>
                                                <text x="12" y="16" text-anchor="middle" font-size="6" fill="white" font-weight="bold">Debian</text>
                                            </svg>
                                            @break
                                        @default
                                            <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                            </svg>
                                    @endswitch
                                </div>
                                <div class="ml-6">
                                    <h3 class="text-2xl font-bold text-gray-900">{{ $vm->name }}</h3>
                                    <p class="text-gray-600">{{ $vm->hostname }}</p>
                                    <p class="text-sm text-gray-500 mt-1">{{ $vm->category->name ?? 'No Category' }}</p>
                                </div>
                            </div>

                            @if($vm->description)
                            <div class="mb-6">
                                <h4 class="text-lg font-medium text-gray-900 mb-2">Description</h4>
                                <p class="text-gray-600">{{ $vm->description }}</p>
                            </div>
                            @endif

                            <!-- VM Details Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Hostname</label>
                                        <p class="text-gray-900 font-mono">{{ $vm->hostname }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Operating System</label>
                                        <p class="text-gray-900 capitalize">{{ $vm->os }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Category</label>
                                        <p class="text-gray-900">{{ $vm->category->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">IP Address</label>
                                        <p class="text-gray-900 font-mono">{{ $vm->ip_address ?? 'Not assigned' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Status</label>
                                        <p class="text-gray-900 capitalize">{{ $vm->status }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Created</label>
                                        <p class="text-gray-900">{{ $vm->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Open Ports -->
                            @if($vm->ports && is_array($vm->ports))
                            <div class="mt-6">
                                <h4 class="text-lg font-medium text-gray-900 mb-3">Open Ports</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($vm->ports as $port)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        {{ $port }}
                                    </span>
                                    @en