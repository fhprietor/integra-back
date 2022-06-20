<?php

namespace App\Http\Controllers;

use App\Models\Customer\Tracking;

class CustomerTrackingController extends Controller
{
    public function index($id) {
        if ($id) {
            $id = (string)request('id');
            $perPage = 15;
            if (request('perPage')) {
                $perPage = (int)request('perPage');
            }
            $customerTracking =  Tracking::where('idecli','=',$id)
                ->with('user')
                ->orderBy('Fecha','desc')
                ->paginate($perPage);
            return $customerTracking;
        }
        return null;
    }
}
