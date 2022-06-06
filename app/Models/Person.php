<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Person extends Model
{
    use HasFactory;
    protected $table = 'tbltrc';
    protected $primaryKey = 'idetrc';
    protected $keyType = 'string';

    public function agentOperations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Operation::class,'agente', 'idetrc');
    }

    public function operations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Operation::class,'idetrc', 'idetrc');
    }
    public function sales()
    {
        return $this->operations()->select(DB::raw('SUM(vrtotal) AS sum_vrtotal'));
//        return $this->operations()->sum('vrtotal');
    }
}
