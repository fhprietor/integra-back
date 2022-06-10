<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class CustomerController extends Controller
{
    public function show() {
        if (request('id')) {
            $id = (string)request('id');
            $customer = Customer::where('idecli','=',$id)
                ->withSum('loans','saldo')
                ->withSum('sales','vrtotal')
                ->with(['person','zone','loans'])
                ->first();

            return $customer;
        }
        return null;
}
    public function index() {
//        $customers = Customer::with('person')
//            ->sortField()
//            ->getOrpaginate();
        /*
        $customers = Customer::join('tbltrc','tblcli.idecli','=','tbltrc.idetrc')
            ->select('tbltrc.nombre')
            ->sortField()
            ->getOrpaginate();
        */
        $perPage = 15;
        if (request('perPage')) {
            $perPage = (int)request('perPage');
        }
        if (request('sortOrder')) {
            if (request('sortOrder') === '1')
                { $sortOrder = 'asc'; }
            else
                { $sortOrder = 'desc'; }
        }
        else
            { $sortOrder = 'asc'; }
        if (request('sortField')) {
            if (request('sortField') === 'name') {
                $customers = Customer::
                joinRelations('person')
                    ->orderByJoin('person.nombre', $sortOrder)
                    ->with('person')
                    ->paginate($perPage);
            } else {
                $customers = Customer::
                joinRelations('person')
                    ->orderBy(request('sortField'), $sortOrder)
                    ->with('person')
                    ->paginate($perPage);
            }
        } else {
            if (request('filterByName')) {
                $customers = Customer::joinRelations('person', 'loans')
                    ->where('tbltrc.nombre', 'ilike', '%'.request('filterByName').'%')
                    ->orderBy('fuccli', 'desc')
                    ->withSum('loans', 'saldo')
                    ->with(['person', 'zone'])
                    ->withLastSale()
                    ->paginate($perPage);
            } else {
                $customers = Customer::joinRelations('person', 'loans')
                    ->where('salcli', '>', 0)
                    ->orderBy('fuccli', 'desc')
                    ->withSum('loans', 'saldo')
                    ->with(['person', 'zone'])
                    ->withLastSale()
                    ->paginate($perPage);
            }
            /*
            $customers = Customer::where('salcli','>',0)
                ->with('person','loans')
                ->selectRaw('sum(tblmca.saldo) as saldocreditos, tblcli.idecli, fincli')
                ->join('tblmca','tblmca.idecli','=','tblcli.idecli')
                ->groupBy('tblcli.idecli')
                ->withLastSale()
                ->paginate($perPage);
            */
/*
            $customers = Customer::where('salcli','>',0)
                ->select('vrpagototal','idecli','zonaid')
                ->with('person','zone','loans')
                ->orderBy('fincli','desc')
                ->WithLastSale()
                ->WithLoanBalance()
                ->paginate($perPage);
*/
/*
            $customers = Customer::
            joinRelations(['person','zone'])
                ->orderBy('fincli','desc')
                ->with(['person','zone','lastSale'])
                ->with('person.operations',)
                ->paginate($perPage);
*/
        }
        return $customers;
    }
}
