<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VMSpecification extends Model
{
    protected $table = 'vm_specifications';

    protected $fillable = [
        'name',
        'cpu_cores',
        'ram_gb',
        'storage_gb',
        'price_per_hour',
        'description',
    ];
}

