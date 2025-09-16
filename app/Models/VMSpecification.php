<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VMSpecification extends Model
{
    protected $table = 'v_m_specifications';

    protected $fillable = [
        'name',
        'cpu_cores',
        'ram_gb',
        'storage_gb',
        'price_per_hour',
        'description',
    ];

    public function vms()
    {
        return $this->hasMany(VM::class, 'v_m_specification_id');
    }
}

