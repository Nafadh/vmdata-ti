<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\User;
use App\Models\Vm;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with(['user','vm','admin'])->paginate(10);
;
        return view('rentals.index', compact('rentals'));
    }

    public function create()
    {
        $users = User::all();
        $vms   = Vm::all();
        $admins = User::where('role', 'admin')->get();
        return view('rentals.create', compact('users','vms','admins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'    => 'required',
            'vm_id'      => 'required',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'status'     => 'required',
            'admin_id'   => 'required',
        ]);

        Rental::create($request->all());

        return redirect()->route('rentals.index')->with('success','Rental berhasil ditambahkan.');
    }

    public function show(Rental $rental)
    {
        return view('rentals.show', compact('rental'));
    }

    public function edit(Rental $rental)
    {
        $users = User::all();
        $vms   = Vm::all();
        $admins = User::where('role', 'admin')->get();
        return view('rentals.edit', compact('rental','users','vms','admins'));
    }

    public function update(Request $request, Rental $rental)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'status'     => 'required',
            'admin_id'   => 'required',
        ]);

        $rental->update($request->all());

        return redirect()->route('rentals.index')->with('success','Rental berhasil diperbarui.');
    }

    public function destroy(Rental $rental)
    {
        $rental->delete();
        return redirect()->route('rentals.index')->with('success','Rental berhasil dihapus.');
    }
}
