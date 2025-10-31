<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\User;
use App\Models\Vm;
use App\Models\VMRental;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with(['user','vm','admin'])->paginate(10);

        // If admin, also include pending VM rental requests so admin can respond
        $pendingVmrentals = [];
        $vmrentals = collect();
        if (auth()->check() && auth()->user()->role === 'admin') {
            $pendingVmrentals = \App\Models\VMRental::with(['user','vm'])->where('status', 'pending')->latest()->get();
            // Also fetch processed VM rentals (non-pending) so we can show users who rented VMs
            $vmrentals = \App\Models\VMRental::with(['user','vm'])->where('status', '!=', 'pending')->latest()->get();
        }

        return view('rentals.index', compact('rentals','pendingVmrentals','vmrentals'));
    }

    public function create()
    {
        // Only include users who already have at least one rental (either in rentals or vm_rentals)
        $rentalUserIds = Rental::select('user_id')->distinct();
        $vmRentalUserIds = VMRental::select('user_id')->distinct();

        $users = User::whereIn('id', $rentalUserIds)
                     ->orWhereIn('id', $vmRentalUserIds)
                     ->get();

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
        // Only include users who already have at least one rental (either in rentals or vm_rentals)
        $rentalUserIds = Rental::select('user_id')->distinct();
        $vmRentalUserIds = VMRental::select('user_id')->distinct();

        $users = User::whereIn('id', $rentalUserIds)
                     ->orWhereIn('id', $vmRentalUserIds)
                     ->get();

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

        $data = $request->all();

        // Recalculate status based on edited dates when admin updates
        try {
            $start = \Carbon\Carbon::parse($data['start_date']);
            $end = \Carbon\Carbon::parse($data['end_date']);
            $now = \Carbon\Carbon::now();

            if ($end->lessThan($now->startOfDay())) {
                // already past -> expired
                $data['status'] = 'expired';
            } elseif ($start->greaterThan($now)) {
                // start is in future -> pending/scheduled
                $data['status'] = 'pending';
            } else {
                // between start and end -> active
                $data['status'] = 'active';
            }
        } catch (\Exception $e) {
            // If parsing fails, fall back to provided status
        }

        $rental->update($data);

        return redirect()->route('rentals.index')->with('success','Rental berhasil diperbarui.');
    }

    public function destroy(Rental $rental)
    {
        $rental->delete();
        return redirect()->route('rentals.index')->with('success','Rental berhasil dihapus.');
    }

    /**
     * Update rental status via AJAX (admin only)
     */
    public function updateStatus(Request $request, Rental $rental)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'status' => ['required', Rule::in(['active','inactive','expired','pending','cancelled'])],
        ]);

        $old = $rental->status;
        $rental->status = $validated['status'];
        $rental->save();

        return response()->json([
            'success' => true,
            'old' => $old,
            'status' => $rental->status,
            'message' => 'Status updated to ' . $rental->status,
        ]);
    }
}
