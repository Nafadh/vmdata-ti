<?php
namespace App\Http\Controllers;

use App\Models\VM;
use App\Models\Category;
use App\Models\VMSpecification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VMController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = VM::with(['category', 'specification']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('hostname', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%")
                  ->orWhereHas('category', function($categoryQuery) use ($search) {
                      $categoryQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $vms = $query->paginate(12)->appends($request->query());

        return view('vms.index', compact('vms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $specifications = VMSpecification::all();
        
        return view('vms.create', compact('categories', 'specifications'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'hostname' => [
                'required',
                'string',
                'max:255',
                'unique:vms,hostname',
                'regex:/^[a-z0-9-]+$/'
            ],
            'category_id' => 'required|exists:categories,id',
            'vm_specification_id' => 'required|exists:vm_specifications,id',
            'os' => 'required|in:ubuntu,centos,windows,debian',
            'ip_address' => 'nullable|ip|unique:vms,ip_address',
            'description' => 'nullable|string|max:1000',
            'ports' => 'nullable|string'
        ], [
            'hostname.regex' => 'Hostname can only contain lowercase letters, numbers, and hyphens.',
            'hostname.unique' => 'This hostname is already taken.',
            'ip_address.ip' => 'Please enter a valid IP address.',
            'ip_address.unique' => 'This IP address is already assigned to another VM.'
        ]);

        // Process ports
        $ports = null;
        if ($request->ports) {
            $portArray = array_map('trim', explode(',', $request->ports));
            $portArray = array_filter($portArray, function($port) {
                return is_numeric($port) && $port > 0 && $port <= 65535;
            });
            $ports = array_values($portArray);
        }

        // Auto-assign IP if not provided
        if (!$validated['ip_address']) {
            $validated['ip_address'] = $this->generateNextIP();
        }

        $vm = VM::create([
            'name' => $validated['name'],
            'hostname' => $validated['hostname'],
            'category_id' => $validated['category_id'],
            'vm_specification_id' => $validated['vm_specification_id'],
            'os' => $validated['os'],
            'ip_address' => $validated['ip_address'],
            'status' => 'available',
            'description' => $validated['description'],
            'ports' => $ports
        ]);

        return redirect()->route('vms.show', $vm)
                         ->with('success', 'Virtual Machine created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(VM $vm)
    {
        $vm->load(['category', 'specification', 'rentals.user']);
        
        return view('vms.show', compact('vm'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VM $vm)
    {
        $categories = Category::all();
        $specifications = VMSpecification::all();
        
        return view('vms.edit', compact('vm', 'categories', 'specifications'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VM $vm)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'hostname' => [
                'required',
                'string',
                'max:255',
                Rule::unique('vms', 'hostname')->ignore($vm->id),
                'regex:/^[a-z0-9-]+$/'
            ],
            'category_id' => 'required|exists:categories,id',
            'vm_specification_id' => 'required|exists:vm_specifications,id',
            'os' => 'required|in:ubuntu,centos,windows,debian',
            'ip_address' => [
                'nullable',
                'ip',
                Rule::unique('vms', 'ip_address')->ignore($vm->id)
            ],
            'status' => 'required|in:available,rented,maintenance,offline',
            'description' => 'nullable|string|max:1000',
            'ports' => 'nullable|string'
        ]);

        // Process ports
        $ports = null;
        if ($request->ports) {
            $portArray = array_map('trim', explode(',', $request->ports));
            $portArray = array_filter($portArray, function($port) {
                return is_numeric($port) && $port > 0 && $port <= 65535;
            });
            $ports = array_values($portArray);
        }

        $vm->update([
            'name' => $validated['name'],
            'hostname' => $validated['hostname'],
            'category_id' => $validated['category_id'],
            'vm_specification_id' => $validated['vm_specification_id'],
            'os' => $validated['os'],
            'ip_address' => $validated['ip_address'],
            'status' => $validated['status'],
            'description' => $validated['description'],
            'ports' => $ports
        ]);

        return redirect()->route('vms.show', $vm)
                         ->with('success', 'Virtual Machine updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VM $vm)
    {
        // Check if VM has active rentals
        if ($vm->rentals()->where('status', 'active')->exists()) {
            return redirect()->route('vms.index')
                           ->with('error', 'Cannot delete VM with active rentals.');
        }

        $vm->delete();

        return redirect()->route('vms.index')
                         ->with('success', 'Virtual Machine deleted successfully!');
    }

    /**
     * Toggle VM status (admin only)
     */
    public function toggleStatus(VM $vm)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $newStatus = $vm->status === 'available' ? 'maintenance' : 'available';
        $vm->update(['status' => $newStatus]);

        return redirect()->back()
    ->with('success', 'VM status changed to ' . $newStatus);
    }   

    /**
     * Generate the next available IP address
     */
    private function generateNextIP()
    {
        // Base IP range (contoh: 192.168.1.x)
        $baseIP = '192.168.1.';
        $startRange = 10;  // Mulai dari 192.168.1.10
        $endRange = 254;   // Sampai 192.168.1.254

        // Ambil semua IP yang sudah digunakan
        $usedIPs = VM::whereNotNull('ip_address')
                     ->where('ip_address', 'like', $baseIP . '%')
                     ->pluck('ip_address')
                     ->toArray();

        // Cari IP yang tersedia
        for ($i = $startRange; $i <= $endRange; $i++) {
            $candidateIP = $baseIP . $i;
            
            if (!in_array($candidateIP, $usedIPs)) {
                return $candidateIP;
            }
        }

        // Jika tidak ada IP yang tersedia dalam range, throw exception
        throw new \Exception('No available IP addresses in the range.');
    }
}
