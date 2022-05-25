<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationLog extends Model
{
    use HasFactory;
    protected $table = 'secLog';
    protected $primaryKey = 'idelog';
    public $timestamps = false;

    protected $fillable = [
        'ideusu',
        'relevancia',
        'descripcion',
        'ipaddress'
    ];
    /**
     * @var mixed|string
     */
    private $ideusu;
}
