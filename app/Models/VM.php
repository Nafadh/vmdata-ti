<?php
// app/Models/VM.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VM extends Model
{
    use HasFactory;
    protected $table = 'vms';

    protected $fillable = [
        'name', 'hostname', 'category_id', 'vm_specification_id', 
        'os', 'ip_address', 'status', 'description', 'ports'
    ];

    protected $casts = [
        'ports' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function specification()
    {
        return $this->belongsTo(VMSpecification::class, 'vm_specification_id');
    }

    public function rentals()
    {
        return $this->hasMany(VMRental::class, 'vm_id', 'id');
    }

    public function getCurrentRentalAttribute()
{
    return $this->rentals()->where('status', 'active')->first();
}

    public function isAvailable()
    {
        return $this->status === 'available';
    }
}