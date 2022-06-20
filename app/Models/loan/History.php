<?php

namespace App\Models\loan;

use App\Models\Loan;
use App\Models\customer\Customer;
use App\Models\Numeration;
use Cassandra\Custom;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $table = 'tblcax';
    protected $primaryKey = 'ide';

    public function loan()
    {
        return $this->belongsTo(Loan::class,'idecarmaestro','ide');
    }
    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Customer::class,'idecli', 'idecli');
    }
    public function numeration()
    {
        return $this->belongsTo(Numeration::class,'idecbt','idecbt');
    }
}
