<?php
namespace App\Http\Controllers;

use App\Models\VM;
use App\Models\VMRental;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_vms' => VM::count(),
            'available_vms' => VM::where('status', 'available')->count(),
            'active_rentals' => VMRental::where('status', 'active')->count(),
            'total_revenue' => VMRental::sum('total_cost'),
            'total_users' => User::count()
        ];

        $recentVMs = VM::latest()->take(5)->with(['category', 'specification'])->get();
        $activeRentals = VMRental::where('status', 'active')
            ->with(['vm', 'user'])
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard', compact('stats', 'recentVMs', 'activeRentals'));
    }
}

