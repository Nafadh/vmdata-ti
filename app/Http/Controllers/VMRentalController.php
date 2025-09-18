<?php

namespace App\Http\Controllers;

use App\Models\VMRental;
use Illuminate\Http\Request;
use App\Http\Requests\StoreVMRentalRequest;
use App\Models\VM;
use Illuminate\Support\Facades\Auth;

class VMRentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $rentals = VMRental::with(['user','vm'])->latest()->paginate(15);
        } else {
            $rentals = VMRental::with('vm')->where('user_id', $user->id)->latest()->paginate(15);
        }

        return view('vmrentals.index', compact('rentals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    $vms = VM::where('status', 'available')->get();
    return view('vmrentals.create', compact('vms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVMRentalRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';

        // optional cost calculation if vm has price
        $vm = VM::find($data['vm_id']);
        if ($vm && isset($vm->specification->price_per_hour) && isset($data['end_time'])) {
            $start = \Carbon\Carbon::parse($data['start_time']);
            $end = \Carbon\Carbon::parse($data['end_time']);
            $hours = max(1, $start->diffInHours($end));
            $data['total_cost'] = $hours * ($vm->specification->price_per_hour ?? 0);
        }

        VMRental::create($data);

        return redirect()->route('vmrentals.index')->with('success', 'Permintaan sewa VM berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(VMRental $vMRental)
    {
    $vMRental->load(['vm','user']);
    return view('vmrentals.show', ['rental' => $vMRental]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VMRental $vMRental)
    {
    $this->authorize('update', $vMRental);
    $vms = VM::all();
    return view('vmrentals.edit', ['rental' => $vMRental, 'vms' => $vms]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreVMRentalRequest $request, VMRental $vMRental)
    {
        $this->authorize('update', $vMRental);
        $data = $request->validated();
        // recalc cost if possible
        $vm = VM::find($data['vm_id']);
        if ($vm && isset($vm->specification->price_per_hour) && isset($data['end_time'])) {
            $start = \Carbon\Carbon::parse($data['start_time']);
            $end = \Carbon\Carbon::parse($data['end_time']);
            $hours = max(1, $start->diffInHours($end));
            $data['total_cost'] = $hours * ($vm->specification->price_per_hour ?? 0);
        }

        $vMRental->update($data);
        return redirect()->route('vmrentals.index')->with('success', 'Permintaan sewa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VMRental $vMRental)
    {
    $this->authorize('delete', $vMRental);
    $vMRental->delete();
    return redirect()->route('vmrentals.index')->with('success', 'Permintaan sewa dihapus.');
    }
}
