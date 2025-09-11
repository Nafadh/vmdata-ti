<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Virtual Machines') }}
            </h2>
            <a href="{{ route('vms.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah VM Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-500 bg-opacity-75">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 truncate">Total VMs</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $vms->total() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-500 bg-opacity-75">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 truncate">Available</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $vms->where('status', 'available')->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-500 bg-opacity-75">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 truncate">Rented</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $vms->where('status', 'rented')->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-500 bg-opacity-75">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 truncate">Maintenance</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $vms->where('status', 'maintenance')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                        <div class="flex-1 max-w-lg">
                            <form method="GET" action="{{ route('vms.index') }}" class="flex">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search VMs..." class="flex-1 border-gray-300 rounded-l-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-r-md hover:bg-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <div class="flex items-center space-x-4">
                            <select name="status_filter" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="filterByStatus(this.value)">
                                <option value="">All Status</option>
                                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>Rented</option>
                                <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="offline" {{ request('status') == 'offline' ? 'selected' : '' }}>Offline</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- VMs Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($vms as $vm)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <!-- VM Header -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="p-2 bg-gray-100 rounded-lg">
                                    @switch($vm->os)
                                        @case('ubuntu')
                                            <svg class="w-6 h-6 text-orange-500" viewBox="0 0 24 24" fill="currentColor">
                                                <circle cx="12" cy="12" r="10" fill="#E95420"/>
                                            </svg>
                                            @break
                                        @case('windows')
                                            <svg class="w-6 h-6 text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M0 3.5l9.5-1.3v9.3H0V3.5zm10.5-1.4L24 0v11.5H10.5V2.1zM0 12.5h9.5v9.3L0 20.5V12.5zm10.5 0H24V24l-13.5-1.8V12.5z"/>
                                            </svg>
                                            @break
                                        @case('centos')
                                            <svg class="w-6 h-6 text-purple-500" viewBox="0 0 24 24" fill="currentColor">
                                                <circle cx="12" cy="12" r="10" fill="#932279"/>
                                            </svg>
                                            @break
                                        @default
                                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                            </svg>
                                    @endswitch
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-medium text-gray-900">{{ $vm->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $vm->hostname }}</p>
                                </div>
                            </div>
                            
                            <!-- Status Badge -->
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
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

                        <!-- VM Details -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Category:</span>
                                <span class="font-medium">{{ $vm->category->name ?? 'N/A' }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">OS:</span>
                                <span class="font-medium capitalize">{{ $vm->os }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">IP Address:</span>
                                <span class="font-medium font-mono text-blue-600">{{ $vm->ip_address ?? 'Not assigned' }}</span>
                            </div>
                            
                            @if($vm->specification)
                            <div class="pt-3 border-t border-gray-200">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Specifications:</h4>
                                <div class="grid grid-cols-3 gap-2 text-xs">
                                    <div class="text-center p-2 bg-gray-50 rounded">
                                        <div class="font-medium">{{ $vm->specification->cpu_cores }}</div>
                                        <div class="text-gray-500">CPU Cores</div>
                                    </div>
                                    <div class="text-center p-2 bg-gray-50 rounded">
                                        <div class="font-medium">{{ $vm->specification->ram_gb }}GB</div>
                                        <div class="text-gray-500">RAM</div>
                                    </div>
                                    <div class="text-center p-2 bg-gray-50 rounded">
                                        <div class="font-medium">{{ $vm->specification->storage_gb }}GB</div>
                                        <div class="text-gray-500">Storage</div>
                                    </div>
                                </div>
                                <div class="mt-2 text-center">
                                    <span class="text-sm font-medium text-green-600">${{ $vm->specification->price_per_hour }}/hour</span>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="mt-6 flex justify-between items-center">
                            <a href="{{ route('vms.show', $vm) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                View Details
                            </a>
                            
                            <div class="flex space-x-2">
                                @if($vm->status === 'available')
                                    <button class="bg-green-500 hover:bg-green-700 text-white text-xs font-bold py-1 px-3 rounded">
                                        Rent Now
                                    </button>
                                @endif
                                
                                @if(auth()->user()->isAdmin())
                                <div class="flex space-x-1">
                                    <a href="{{ route('vms.edit', $vm) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white text-xs font-bold py-1 px-2 rounded">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('vms.destroy', $vm) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this VM?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-xs font-bold py-1 px-2 rounded">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full">
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m8-2v2m4-2v2"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No virtual machines</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new VM.</p>
                        <div class="mt-6">
                            <a href="{{ route('vms.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                </svg>
                                New Virtual Machine
                            </a>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $vms->links() }}
            </div>
        </div>
    </div>

    <script>
        function filterByStatus(status) {
            const url = new URL(window.location.href);
            if (status) {
                url.searchParams.set('status', status);
            } else {
                url.searchParams.delete('status');
            }
            window.location.href = url.toString();
        }
    </script>
</x-app-layout>