<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    // Kolom yang bisa diisi mass-assignment
    protected $fillable = [
        'user_id',
        'vm_id',
        'admin_id',
        'start_date',
        'end_date',
        'status',
    ];

    /**
     * Relasi ke User (penyewa)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke VM
     */
    public function vm()
    {
        return $this->belongsTo(VM::class);
    }

    /**
     * Relasi ke Admin (penanggung jawab rental)
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
