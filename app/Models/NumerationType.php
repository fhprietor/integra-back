<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumerationType extends Model
{
    use HasFactory;
    protected $table = 'tblcbttipos';
    protected $primaryKey = 'tipocbt';
}
