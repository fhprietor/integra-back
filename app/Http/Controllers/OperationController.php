<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use Illuminate\Http\Request;

class OperationController extends Controller
{
    public function salesByCustomer($id) {
        if ($id) {
            $id = (string)request('id');
            $perPage = 15;
            return Operation::orderBy('fechahora', 'desc')
                ->where('idetrc','=',$id)
                ->where('estado','=',1)
                ->whereIn('tipooperacion', [1, 2])
                ->with('numeration')
                ->paginate($perPage);
        }
        return null;
    }
}
