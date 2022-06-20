<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Numeration extends Model
{
    use HasFactory;
    protected $table = 'tblcbt';

    public function type() {
        return $this->hasOne(NumerationType::class,'tipocbt','tipocbt');
    }
}
