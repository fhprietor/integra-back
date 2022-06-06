<?php

namespace App\Models;

use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    use EloquentJoin;

    protected $table = 'tblcli';
    protected $primaryKey = 'idecli';
    protected $keyType = 'string';

    public function person(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Person::class,'idecli', 'idetrc');
    }
    public function zone(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Zone::class,'zonaid', 'id');
    }

    public function lastSale(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Operation::class);
    }

    public function sales()
    {
        return $this->hasMany(Operation::class,'idetrc','idecli')
            ->where('tipooperacion','=',1);
    }
    public function loans(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Loan::class,'idecli','idecli')->where('saldo','>',0);
    }
/*
    public function loanBalance()
    {
        return $this->loans()->sum('saldo');
    }
*/
    public function scopeGetOrpaginate(Builder $query) {
        $perPage = 15;
        if (request('perPage')) {
            $perPage = (int)request('perPage');
        }
        return $query->paginate($perPage);
    }

    public function scopeSortField(Builder $query) {
        if (request('sortField')) {
            return $query->orderBy(request('sortField'),'asc');
        }
        return $query->orderBy('fuccli','desc');
    }

    public function scopeWithLastSale(Builder $query) {
        $subselect = Operation::
            where('tipooperacion','=',1)
            ->select('oprmaestro.id')
            ->whereColumn('oprmaestro.idetrc', 'tblcli.idecli')
            ->orderByDesc('fechacontable')
            ->limit(1);

        $query->addSelect([
            'last_sale_id' => $subselect,
        ]);

        $query->with('lastSale');
    }

    public function scopeWithSalesTotal(Builder $query) {
        $subselect = Operation::
        where('tipooperacion','=',1)
            ->select('oprmaestro.id')
            ->whereColumn('oprmaestro.idetrc', 'tblcli.idecli')
            ->orderByDesc('fechacontable')
            ->sum('vrtotal');

        $query->addSelect([
            'last_sale_id' => $subselect,
        ]);

      //  $query->with('lastSale');
    }
    public function scopeWithLoanBalance(Builder $query) {
        $subselect = Loan::selectRaw('SUM(saldo) as saldototal');
        $query->addSelect([
            'loan_balance' => $subselect,
        ]);
    }
}
