<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDetail extends Model
{
    use HasFactory;
    protected $table = 'tblvdt';

    public function operation(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
      //  return $this->belongsTo(Operation::class, 'idoperacion');
    }
}
