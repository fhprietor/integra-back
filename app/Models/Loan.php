<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $table = 'tblmca';
    protected $primaryKey = 'ide';

    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Customer::class,'idecli', 'idecli');
    }

    public function numeration() {
        return $this->belongsTo(Numeration::class,'idecbt','idecbt');
    }
}
