<?php

namespace App\Models\loan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;
    protected $table = 'tblcta';
    protected $primaryKey = 'ide';

}
