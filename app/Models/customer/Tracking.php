<?php

namespace App\Models\Customer;

use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;
    protected $table = 'Seguimiento';
    protected $primaryKey = 'ideSeg';
    public function customer()
    {
        return $this->belongsTo(Person::class, 'idecli', 'idetrc');
    }
    public function user()
    {
        return $this->belongsTo(Person::class, 'ideusu', 'idetrc');
    }
}
