<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Operation extends Model
{
    use HasFactory;
    protected $table = 'oprmaestro';

    public function salesDetails(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SalesDetail::class,'idoperacion');
    }
    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Person::class,'idetrc', 'idetrc');
    }
    public function agent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Person::class,'agente', 'idetrc');
    }
    public function numeration()
    {
        return $this->belongsTo(Numeration::class, 'idecbt', 'idecbt');
    }
}
