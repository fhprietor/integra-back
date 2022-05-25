<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;
    protected $table = 'Seguimiento';
    public function customer()
    {
        return $this->belongsTo(Person::class, 'idecli', 'idetrc');
    }
    public function user()
    {
        return $this->belongsTo(Person::class, 'ideusu', 'idetrc');
    }
}
