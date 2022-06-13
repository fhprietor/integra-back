<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;
    protected $table = 'tbltel';
    protected $primaryKey = 'idetel';

    public function site() {
        return $this->hasOne(Site::class,'idsitio','sittel');
    }
}
