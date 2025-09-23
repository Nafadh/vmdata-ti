<?php
//app/Models/VM.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VM extends Model
{
    use HasFactory;
    protected $table = 'vms';

    protected $fillable = [
        'name', 'category_id', 'vm_specification_id', 
        'server_id', 'ram', 'storage', 'backup_disk', 'status', 'description'
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
    return $this->rentals()->where('status', 'available')->first();
}

    public function isAvailable()
    {
        return $this->status === 'available';
    }
}