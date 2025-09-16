<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// app/Models/Category.php

class Category extends Model
{
    protected $fillable = ['name', 'description'];
    
    public function vms()
    {
        return $this->hasMany(VM::class);
    }
}

// app/Models/VMSpecification.php  
class VMSpecification extends Model
{
    protected $fillable = [
        'name', 'cpu_cores', 'ram_gb', 'storage_gb', 'price_per_hour', 'description'
    ];
    
    public function vms()
    {
        return $this->hasMany(VM::class, 'vm_specification_id');
    }
}

