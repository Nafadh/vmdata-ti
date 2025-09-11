<?php
namespace App\Http\Controllers;

use App\Models\VM;
use App\Models\Category;
use App\Models\VMSpecification;
use Illuminate\Http\Request;

class VMController extends Controller
{
    public function index()
    {
        $vms = VM::with(['category', 'specification'])->paginate(10);
        return view('vms.index', compact('vms'));
    }

    public function create()
    {
        $categories = Category::all();
        $specifications = VMSpecification::all();
        return view('vms.create', compact('categories', 'specifications'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'hostname' => 'required|string|unique:vms',
            'category_id' => 'required|exists:categories,id',
            'vm_specification_id' => 'required|exists:vm_specifications,id',
            'os' => 'required|in:ubuntu,centos,windows,debian',
            'ip_address' => 'nullable|ip',
            'description' => 'nullable|string',
        ]);

        VM::create($request->all());
        return redirect()->route('vms.index')->with('success', 'VM created successfully');
    }

    public function show(VM $vm)
    {
        $vm->load(['category', 'specification', 'rentals.user']);
        return view('vms.show', compact('vm'));
    }
}