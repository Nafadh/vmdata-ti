<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('vms.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Virtual Machine') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <!-- Progress Steps -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex items-center justify-center w-8 h-8 bg-indigo-600 text-white rounded-full">
                                    <span class="text-sm font-medium">1</span>
                                </div>
                                <span class="ml-2 text-sm font-medium text-gray-900">Basic Information</span>
                            </div>
                            <div class="flex-1 mx-4 h-1 bg-gray-200">
                                <div class="h-full bg-indigo-600 rounded" style="width: 0%"></div>
                            </div>
                            <div class="flex items-center">
                                <div class="flex items-center justify-center w-8 h-8 bg-gray-300 text-gray-500 rounded-full">
                                    <span class="text-sm font-medium">2</span>
                                </div>
                                <span class="ml-2 text-sm font-medium text-gray-500">Configuration</span>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('vms.store') }}" id="vmForm">
                        @csrf

                        <!-- Basic Information Section -->
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- VM Name -->
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                            VM Name <span class="text-red-500">*</span>
                                        </label>
                                    </div>
                                    
                                    <div class="relative">
                                        <input type="radio" name="os" value="windows" id="os_windows" {{ old('os') == 'windows' ? 'checked' : '' }} class="sr-only">
                                        <label for="os_windows" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 peer-checked:border-indigo-500 peer-checked:bg-indigo-50">
                                            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mb-2">
                                                <span class="text-white font-bold text-sm">W</span>
                                            </div>
                                            <span class="text-sm font-medium">Windows</span>
                                        </label>
                                    </div>
                                    
                                    <div class="relative">
                                        <input type="radio" name="os" value="debian" id="os_debian" {{ old('os') == 'debian' ? 'checked' : '' }} class="sr-only">
                                        <label for="os_debian" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 peer-checked:border-indigo-500 peer-checked:bg-indigo-50">
                                            <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center mb-2">
                                                <span class="text-white font-bold text-sm">D</span>
                                            </div>
                                            <span class="text-sm font-medium">Debian</span>
                                        </label>
                                    </div>
                                </div>
                                @error('os')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Network Configuration -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Network Configuration</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- IP Address -->
                                    <div>
                                        <label for="ip_address" class="block text-sm font-medium text-gray-700 mb-2">
                                            IP Address
                                        </label>
                                        <input type="text" name="ip_address" id="ip_address" value="{{ old('ip_address') }}"
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                               placeholder="e.g., 192.168.1.100">
                                        @error('ip_address')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">Leave empty to auto-assign</p>
                                    </div>

                                    <!-- Open Ports -->
                                    <div>
                                        <label for="ports" class="block text-sm font-medium text-gray-700 mb-2">
                                            Open Ports
                                        </label>
                                        <input type="text" name="ports" id="ports" value="{{ old('ports') }}"
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                               placeholder="e.g., 22,80,443">
                                        <p class="mt-1 text-xs text-gray-500">Comma-separated port numbers</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Description
                                </label>
                                <textarea name="description" id="description" rows="4"
                                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                          placeholder="Describe the purpose and configuration of this virtual machine...">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Summary Card -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Summary</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="text-gray-600">VM Name:</span>
                                        <span id="summaryName" class="ml-2 font-medium">-</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Hostname:</span>
                                        <span id="summaryHostname" class="ml-2 font-medium font-mono">-</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Category:</span>
                                        <span id="summaryCategory" class="ml-2 font-medium">-</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Operating System:</span>
                                        <span id="summaryOS" class="ml-2 font-medium">-</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Specification:</span>
                                        <span id="summarySpec" class="ml-2 font-medium">-</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Estimated Cost:</span>
                                        <span id="summaryCost" class="ml-2 font-medium text-green-600">-</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                                <a href="{{ route('vms.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                                    Cancel
                                </a>
                                
                                <div class="flex space-x-3">
                                    <button type="button" id="previewBtn" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                                        Preview
                                    </button>
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded">
                                        Create Virtual Machine
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" style="z-index: 50;">
        <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-2xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">VM Configuration Preview</h3>
                    <button onclick="closePreviewModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-6">
                    <!-- VM Card Preview -->
                    <div class="bg-white border-2 border-gray-200 rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="p-2 bg-gray-100 rounded-lg">
                                    <div id="previewOSIcon" class="w-6 h-6 bg-gray-500 rounded flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">?</span>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-medium text-gray-900" id="previewVMName">VM Name</h3>
                                    <p class="text-sm text-gray-500 font-mono" id="previewHostname">hostname</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Available
                            </span>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Category:</span>
                                <span class="font-medium" id="previewCategoryName">-</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">OS:</span>
                                <span class="font-medium capitalize" id="previewOSName">-</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">IP Address:</span>
                                <span class="font-medium font-mono text-blue-600" id="previewIP">Auto-assign</span>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-gray-200 mt-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Specifications:</h4>
                            <div class="grid grid-cols-3 gap-2 text-xs">
                                <div class="text-center p-2 bg-gray-50 rounded">
                                    <div class="font-medium" id="previewSpecCPU">-</div>
                                    <div class="text-gray-500">CPU Cores</div>
                                </div>
                                <div class="text-center p-2 bg-gray-50 rounded">
                                    <div class="font-medium" id="previewSpecRAM">-</div>
                                    <div class="text-gray-500">RAM</div>
                                </div>
                                <div class="text-center p-2 bg-gray-50 rounded">
                                    <div class="font-medium" id="previewSpecStorage">-</div>
                                    <div class="text-gray-500">Storage</div>
                                </div>
                            </div>
                            <div class="mt-2 text-center">
                                <span class="text-sm font-medium text-green-600" id="previewSpecPrice">-</span>
                            </div>
                        </div>

                        <div id="previewPorts" class="mt-4 hidden">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Open Ports:</h4>
                            <div class="flex flex-wrap gap-1" id="previewPortsList">
                                <!-- Ports will be populated here -->
                            </div>
                        </div>

                        <div id="previewDesc" class="mt-4 hidden">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Description:</h4>
                            <p class="text-sm text-gray-600" id="previewDescription">-</p>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closePreviewModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Close
                        </button>
                        <button type="button" onclick="submitForm()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Create VM
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Form data tracking
        let formData = {};

        // Update summary and track form changes
        function updateSummary() {
            // Get form values
            formData.name = document.getElementById('name').value;
            formData.hostname = document.getElementById('hostname').value;
            formData.category = document.getElementById('category_id');
            formData.specification = document.getElementById('vm_specification_id');
            formData.os = document.querySelector('input[name="os"]:checked');
            formData.ip_address = document.getElementById('ip_address').value;
            formData.ports = document.getElementById('ports').value;
            formData.description = document.getElementById('description').value;

            // Update summary
            document.getElementById('summaryName').textContent = formData.name || '-';
            document.getElementById('summaryHostname').textContent = formData.hostname || '-';
            document.getElementById('summaryCategory').textContent = formData.category ? formData.category.options[formData.category.selectedIndex].text : '-';
            document.getElementById('summaryOS').textContent = formData.os ? formData.os.value : '-';
            
            if (formData.specification && formData.specification.selectedIndex > 0) {
                const option = formData.specification.options[formData.specification.selectedIndex];
                document.getElementById('summarySpec').textContent = option.text;
                document.getElementById('summaryCost').textContent = '
                                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                               placeholder="e.g., Web Server 01">
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Hostname -->
                                    <div>
                                        <label for="hostname" class="block text-sm font-medium text-gray-700 mb-2">
                                            Hostname <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="hostname" id="hostname" value="{{ old('hostname') }}" required
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                               placeholder="e.g., web-server-01">
                                        @error('hostname')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">Must be unique and contain only lowercase letters, numbers, and hyphens</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Category & Specification -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Category & Specifications</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Category -->
                                    <div>
                                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            Category <span class="text-red-500">*</span>
                                        </label>
                                        <select name="category_id" id="category_id" required
                                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- VM Specification -->
                                    <div>
                                        <label for="vm_specification_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            Specification <span class="text-red-500">*</span>
                                        </label>
                                        <select name="vm_specification_id" id="vm_specification_id" required
                                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select Specification</option>
                                            @foreach($specifications as $spec)
                                                <option value="{{ $spec->id }}" data-cpu="{{ $spec->cpu_cores }}" data-ram="{{ $spec->ram_gb }}" data-storage="{{ $spec->storage_gb }}" data-price="{{ $spec->price_per_hour }}" {{ old('vm_specification_id') == $spec->id ? 'selected' : '' }}>
                                                    {{ $spec->name }} - {{ $spec->cpu_cores }}CPU, {{ $spec->ram_gb }}GB RAM, {{ $spec->storage_gb }}GB Storage (${{ $spec->price_per_hour }}/hr)
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('vm_specification_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Specification Preview -->
                                <div id="specPreview" class="mt-4 p-4 bg-gray-50 rounded-lg hidden">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Selected Specification:</h4>
                                    <div class="grid grid-cols-4 gap-4 text-center">
                                        <div>
                                            <div class="text-lg font-semibold text-gray-900" id="previewCPU">-</div>
                                            <div class="text-xs text-gray-500">CPU Cores</div>
                                        </div>
                                        <div>
                                            <div class="text-lg font-semibold text-gray-900" id="previewRAM">-</div>
                                            <div class="text-xs text-gray-500">RAM (GB)</div>
                                        </div>
                                        <div>
                                            <div class="text-lg font-semibold text-gray-900" id="previewStorage">-</div>
                                            <div class="text-xs text-gray-500">Storage (GB)</div>
                                        </div>
                                        <div>
                                            <div class="text-lg font-semibold text-green-600" id="previewPrice">-</div>
                                            <div class="text-xs text-gray-500">Price/Hour</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Operating System -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Operating System</h3>
                                
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="relative">
                                        <input type="radio" name="os" value="ubuntu" id="os_ubuntu" {{ old('os') == 'ubuntu' ? 'checked' : '' }} class="sr-only">
                                        <label for="os_ubuntu" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 peer-checked:border-indigo-500 peer-checked:bg-indigo-50">
                                            <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center mb-2">
                                                <span class="text-white font-bold text-sm">U</span>
                                            </div>
                                            <span class="text-sm font-medium">Ubuntu</span>
                                        </label>
                                    </div>
                                    
                                    <div class="relative">
                                        <input type="radio" name="os" value="centos" id="os_centos" {{ old('os') == 'centos' ? 'checked' : '' }} class="sr-only">
                                        <label for="os_centos" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 peer-checked:border-indigo-500 peer-checked:bg-indigo-50">
                                            <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mb-2">
                                                <span class="text-white font-bold text-sm">C</span>
                                            </div>
                                            <span class="text-sm font-medium">CentOS</span>
                                        </label>
                                 + option.dataset.price + '/hour';
            } else {
                document.getElementById('summarySpec').textContent = '-';
                document.getElementById('summaryCost').textContent = '-';
            }
        }

        // Update specification preview
        function updateSpecPreview() {
            const select = document.getElementById('vm_specification_id');
            const preview = document.getElementById('specPreview');
            
            if (select.selectedIndex > 0) {
                const option = select.options[select.selectedIndex];
                document.getElementById('previewCPU').textContent = option.dataset.cpu;
                document.getElementById('previewRAM').textContent = option.dataset.ram;
                document.getElementById('previewStorage').textContent = option.dataset.storage;
                document.getElementById('previewPrice').textContent = '
                                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                               placeholder="e.g., Web Server 01">
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Hostname -->
                                    <div>
                                        <label for="hostname" class="block text-sm font-medium text-gray-700 mb-2">
                                            Hostname <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="hostname" id="hostname" value="{{ old('hostname') }}" required
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                               placeholder="e.g., web-server-01">
                                        @error('hostname')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">Must be unique and contain only lowercase letters, numbers, and hyphens</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Category & Specification -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Category & Specifications</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Category -->
                                    <div>
                                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            Category <span class="text-red-500">*</span>
                                        </label>
                                        <select name="category_id" id="category_id" required
                                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- VM Specification -->
                                    <div>
                                        <label for="vm_specification_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            Specification <span class="text-red-500">*</span>
                                        </label>
                                        <select name="vm_specification_id" id="vm_specification_id" required
                                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select Specification</option>
                                            @foreach($specifications as $spec)
                                                <option value="{{ $spec->id }}" data-cpu="{{ $spec->cpu_cores }}" data-ram="{{ $spec->ram_gb }}" data-storage="{{ $spec->storage_gb }}" data-price="{{ $spec->price_per_hour }}" {{ old('vm_specification_id') == $spec->id ? 'selected' : '' }}>
                                                    {{ $spec->name }} - {{ $spec->cpu_cores }}CPU, {{ $spec->ram_gb }}GB RAM, {{ $spec->storage_gb }}GB Storage (${{ $spec->price_per_hour }}/hr)
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('vm_specification_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Specification Preview -->
                                <div id="specPreview" class="mt-4 p-4 bg-gray-50 rounded-lg hidden">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Selected Specification:</h4>
                                    <div class="grid grid-cols-4 gap-4 text-center">
                                        <div>
                                            <div class="text-lg font-semibold text-gray-900" id="previewCPU">-</div>
                                            <div class="text-xs text-gray-500">CPU Cores</div>
                                        </div>
                                        <div>
                                            <div class="text-lg font-semibold text-gray-900" id="previewRAM">-</div>
                                            <div class="text-xs text-gray-500">RAM (GB)</div>
                                        </div>
                                        <div>
                                            <div class="text-lg font-semibold text-gray-900" id="previewStorage">-</div>
                                            <div class="text-xs text-gray-500">Storage (GB)</div>
                                        </div>
                                        <div>
                                            <div class="text-lg font-semibold text-green-600" id="previewPrice">-</div>
                                            <div class="text-xs text-gray-500">Price/Hour</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Operating System -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Operating System</h3>
                                
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="relative">
                                        <input type="radio" name="os" value="ubuntu" id="os_ubuntu" {{ old('os') == 'ubuntu' ? 'checked' : '' }} class="sr-only">
                                        <label for="os_ubuntu" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 peer-checked:border-indigo-500 peer-checked:bg-indigo-50">
                                            <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center mb-2">
                                                <span class="text-white font-bold text-sm">U</span>
                                            </div>
                                            <span class="text-sm font-medium">Ubuntu</span>
                                        </label>
                                    </div>
                                    
                                    <div class="relative">
                                        <input type="radio" name="os" value="centos" id="os_centos" {{ old('os') == 'centos' ? 'checked' : '' }} class="sr-only">
                                        <label for="os_centos" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 peer-checked:border-indigo-500 peer-checked:bg-indigo-50">
                                            <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mb-2">
                                                <span class="text-white font-bold text-sm">C</span>
                                            </div>
                                            <span class="text-sm font-medium">CentOS</span>
                                        </label>
                                 + option.dataset.price;
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
            }
        }

        // Auto-generate hostname from name
        function generateHostname() {
            const name = document.getElementById('name').value;
            const hostname = name.toLowerCase()
                .replace(/[^a-z0-9]/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
            document.getElementById('hostname').value = hostname;
            updateSummary();
        }

        // Modal functions
        function openPreviewModal() {
            updatePreview();
            document.getElementById('previewModal').classList.remove('hidden');
        }

        function closePreviewModal() {
            document.getElementById('previewModal').classList.add('hidden');
        }

        function submitForm() {
            document.getElementById('vmForm').submit();
        }

        // Update preview modal
        function updatePreview() {
            // Update form data
            updateSummary();
            
            // Update preview modal
            document.getElementById('previewVMName').textContent = formData.name || 'VM Name';
            document.getElementById('previewHostname').textContent = formData.hostname || 'hostname';
            document.getElementById('previewCategoryName').textContent = formData.category && formData.category.selectedIndex > 0 ? formData.category.options[formData.category.selectedIndex].text : '-';
            document.getElementById('previewOSName').textContent = formData.os ? formData.os.value : '-';
            document.getElementById('previewIP').textContent = formData.ip_address || 'Auto-assign';

            // Update OS icon
            const osIcon = document.getElementById('previewOSIcon');
            if (formData.os) {
                switch(formData.os.value) {
                    case 'ubuntu':
                        osIcon.className = 'w-6 h-6 bg-orange-500 rounded flex items-center justify-center';
                        osIcon.innerHTML = '<span class="text-white font-bold text-sm">U</span>';
                        break;
                    case 'centos':
                        osIcon.className = 'w-6 h-6 bg-purple-500 rounded flex items-center justify-center';
                        osIcon.innerHTML = '<span class="text-white font-bold text-sm">C</span>';
                        break;
                    case 'windows':
                        osIcon.className = 'w-6 h-6 bg-blue-500 rounded flex items-center justify-center';
                        osIcon.innerHTML = '<span class="text-white font-bold text-sm">W</span>';
                        break;
                    case 'debian':
                        osIcon.className = 'w-6 h-6 bg-red-500 rounded flex items-center justify-center';
                        osIcon.innerHTML = '<span class="text-white font-bold text-sm">D</span>';
                        break;
                    default:
                        osIcon.className = 'w-6 h-6 bg-gray-500 rounded flex items-center justify-center';
                        osIcon.innerHTML = '<span class="text-white font-bold text-sm">?</span>';
                }
            }

            // Update specifications
            if (formData.specification && formData.specification.selectedIndex > 0) {
                const option = formData.specification.options[formData.specification.selectedIndex];
                document.getElementById('previewSpecCPU').textContent = option.dataset.cpu;
                document.getElementById('previewSpecRAM').textContent = option.dataset.ram + 'GB';
                document.getElementById('previewSpecStorage').textContent = option.dataset.storage + 'GB';
                document.getElementById('previewSpecPrice').textContent = '
                                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                               placeholder="e.g., Web Server 01">
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Hostname -->
                                    <div>
                                        <label for="hostname" class="block text-sm font-medium text-gray-700 mb-2">
                                            Hostname <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="hostname" id="hostname" value="{{ old('hostname') }}" required
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                               placeholder="e.g., web-server-01">
                                        @error('hostname')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">Must be unique and contain only lowercase letters, numbers, and hyphens</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Category & Specification -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Category & Specifications</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Category -->
                                    <div>
                                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            Category <span class="text-red-500">*</span>
                                        </label>
                                        <select name="category_id" id="category_id" required
                                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- VM Specification -->
                                    <div>
                                        <label for="vm_specification_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            Specification <span class="text-red-500">*</span>
                                        </label>
                                        <select name="vm_specification_id" id="vm_specification_id" required
                                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select Specification</option>
                                            @foreach($specifications as $spec)
                                                <option value="{{ $spec->id }}" data-cpu="{{ $spec->cpu_cores }}" data-ram="{{ $spec->ram_gb }}" data-storage="{{ $spec->storage_gb }}" data-price="{{ $spec->price_per_hour }}" {{ old('vm_specification_id') == $spec->id ? 'selected' : '' }}>
                                                    {{ $spec->name }} - {{ $spec->cpu_cores }}CPU, {{ $spec->ram_gb }}GB RAM, {{ $spec->storage_gb }}GB Storage (${{ $spec->price_per_hour }}/hr)
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('vm_specification_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Specification Preview -->
                                <div id="specPreview" class="mt-4 p-4 bg-gray-50 rounded-lg hidden">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Selected Specification:</h4>
                                    <div class="grid grid-cols-4 gap-4 text-center">
                                        <div>
                                            <div class="text-lg font-semibold text-gray-900" id="previewCPU">-</div>
                                            <div class="text-xs text-gray-500">CPU Cores</div>
                                        </div>
                                        <div>
                                            <div class="text-lg font-semibold text-gray-900" id="previewRAM">-</div>
                                            <div class="text-xs text-gray-500">RAM (GB)</div>
                                        </div>
                                        <div>
                                            <div class="text-lg font-semibold text-gray-900" id="previewStorage">-</div>
                                            <div class="text-xs text-gray-500">Storage (GB)</div>
                                        </div>
                                        <div>
                                            <div class="text-lg font-semibold text-green-600" id="previewPrice">-</div>
                                            <div class="text-xs text-gray-500">Price/Hour</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Operating System -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Operating System</h3>
                                
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="relative">
                                        <input type="radio" name="os" value="ubuntu" id="os_ubuntu" {{ old('os') == 'ubuntu' ? 'checked' : '' }} class="sr-only">
                                        <label for="os_ubuntu" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 peer-checked:border-indigo-500 peer-checked:bg-indigo-50">
                                            <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center mb-2">
                                                <span class="text-white font-bold text-sm">U</span>
                                            </div>
                                            <span class="text-sm font-medium">Ubuntu</span>
                                        </label>
                                    </div>
                                    
                                    <div class="relative">
                                        <input type="radio" name="os" value="centos" id="os_centos" {{ old('os') == 'centos' ? 'checked' : '' }} class="sr-only">
                                        <label for="os_centos" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 peer-checked:border-indigo-500 peer-checked:bg-indigo-50">
                                            <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mb-2">
                                                <span class="text-white font-bold text-sm">C</span>
                                            </div>
                                            <span class="text-sm font-medium">CentOS</span>
                                        </label>
                                 + option.dataset.price + '/hour';
            }

            // Update ports
            const portsDiv = document.getElementById('previewPorts');
            const portsList = document.getElementById('previewPortsList');
            if (formData.ports) {
                const ports = formData.ports.split(',').map(p => p.trim()).filter(p => p);
                if (ports.length > 0) {
                    portsList.innerHTML = ports.map(port => 
                        `<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">${port}</span>`
                    ).join('');
                    portsDiv.classList.remove('hidden');
                } else {
                    portsDiv.classList.add('hidden');
                }
            } else {
                portsDiv.classList.add('hidden');
            }

            // Update description
            const descDiv = document.getElementById('previewDesc');
            if (formData.description) {
                document.getElementById('previewDescription').textContent = formData.description;
                descDiv.classList.remove('hidden');
            } else {
                descDiv.classList.add('hidden');
            }
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Form field listeners
            document.getElementById('name').addEventListener('input', function() {
                generateHostname();
                updateSummary();
            });
            
            document.getElementById('hostname').addEventListener('input', updateSummary);
            document.getElementById('category_id').addEventListener('change', updateSummary);
            document.getElementById('vm_specification_id').addEventListener('change', function() {
                updateSpecPreview();
                updateSummary();
            });
            
            document.querySelectorAll('input[name="os"]').forEach(radio => {
                radio.addEventListener('change', updateSummary);
            });
            
            document.getElementById('ip_address').addEventListener('input', updateSummary);
            document.getElementById('ports').addEventListener('input', updateSummary);
            document.getElementById('description').addEventListener('input', updateSummary);

            // Preview button
            document.getElementById('previewBtn').addEventListener('click', openPreviewModal);

            // Close modal when clicking outside
            document.getElementById('previewModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closePreviewModal();
                }
            });

            // Initialize
            updateSummary();
        });

        // Form validation
        document.getElementById('vmForm').addEventListener('submit', function(e) {
            // Add any additional client-side validation here
            const requiredFields = ['name', 'hostname', 'category_id', 'vm_specification_id'];
            let isValid = true;

            requiredFields.forEach(field => {
                const element = document.getElementById(field);
                if (!element.value) {
                    isValid = false;
                    element.classList.add('border-red-500');
                } else {
                    element.classList.remove('border-red-500');
                }
            });

            const osSelected = document.querySelector('input[name="os"]:checked');
            if (!osSelected) {
                isValid = false;
                // Highlight OS section
            }

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields');
            }
        });
    </script>
</x-app-layout>
                                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                               placeholder="e.g., Web Server 01">
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Hostname -->
                                    <div>
                                        <label for="hostname" class="block text-sm font-medium text-gray-700 mb-2">
                                            Hostname <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="hostname" id="hostname" value="{{ old('hostname') }}" required
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                               placeholder="e.g., web-server-01">
                                        @error('hostname')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">Must be unique and contain only lowercase letters, numbers, and hyphens</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Category & Specification -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Category & Specifications</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Category -->
                                    <div>
                                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            Category <span class="text-red-500">*</span>
                                        </label>
                                        <select name="category_id" id="category_id" required
                                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- VM Specification -->
                                    <div>
                                        <label for="vm_specification_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            Specification <span class="text-red-500">*</span>
                                        </label>
                                        <select name="vm_specification_id" id="vm_specification_id" required
                                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select Specification</option>
                                            @foreach($specifications as $spec)
                                                <option value="{{ $spec->id }}" data-cpu="{{ $spec->cpu_cores }}" data-ram="{{ $spec->ram_gb }}" data-storage="{{ $spec->storage_gb }}" data-price="{{ $spec->price_per_hour }}" {{ old('vm_specification_id') == $spec->id ? 'selected' : '' }}>
                                                    {{ $spec->name }} - {{ $spec->cpu_cores }}CPU, {{ $spec->ram_gb }}GB RAM, {{ $spec->storage_gb }}GB Storage (${{ $spec->price_per_hour }}/hr)
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('vm_specification_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Specification Preview -->
                                <div id="specPreview" class="mt-4 p-4 bg-gray-50 rounded-lg hidden">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Selected Specification:</h4>
                                    <div class="grid grid-cols-4 gap-4 text-center">
                                        <div>
                                            <div class="text-lg font-semibold text-gray-900" id="previewCPU">-</div>
                                            <div class="text-xs text-gray-500">CPU Cores</div>
                                        </div>
                                        <div>
                                            <div class="text-lg font-semibold text-gray-900" id="previewRAM">-</div>
                                            <div class="text-xs text-gray-500">RAM (GB)</div>
                                        </div>
                                        <div>
                                            <div class="text-lg font-semibold text-gray-900" id="previewStorage">-</div>
                                            <div class="text-xs text-gray-500">Storage (GB)</div>
                                        </div>
                                        <div>
                                            <div class="text-lg font-semibold text-green-600" id="previewPrice">-</div>
                                            <div class="text-xs text-gray-500">Price/Hour</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Operating System -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Operating System</h3>
                                
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="relative">
                                        <input type="radio" name="os" value="ubuntu" id="os_ubuntu" {{ old('os') == 'ubuntu' ? 'checked' : '' }} class="sr-only">
                                        <label for="os_ubuntu" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 peer-checked:border-indigo-500 peer-checked:bg-indigo-50">
                                            <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center mb-2">
                                                <span class="text-white font-bold text-sm">U</span>
                                            </div>
                                            <span class="text-sm font-medium">Ubuntu</span>
                                        </label>
                                    </div>
                                    
                                    <div class="relative">
                                        <input type="radio" name="os" value="centos" id="os_centos" {{ old('os') == 'centos' ? 'checked' : '' }} class="sr-only">
                                        <label for="os_centos" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 peer-checked:border-indigo-500 peer-checked:bg-indigo-50">
                                            <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mb-2">
                                                <span class="text-white font-bold text-sm">C</span>
                                            </div>
                                            <span class="text-sm font-medium">CentOS</span>
                                        </label>