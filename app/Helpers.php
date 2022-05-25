<?php

use App\Models\BestSellerProduct;
use App\Models\Operation;
use App\Models\StockItem;

function ago($datetime){
    $time=strtotime($datetime);
    $diff=time()-$time;
    $diff/=60;
    $var1=floor($diff);
    $var=$var1<=1 ? 'min' : 'mins';
    if($diff>=60){
        $diff/=60;
        $var1=floor($diff);
        $var=$var1<=1 ? 'hr' : 'hrs';
        if($diff>=24){$diff/=24;$var1=floor($diff);$var=$var1<=1 ? 'dia' : 'dias';
            if($diff>=30.4375){$diff/=30.4375;$var1=floor($diff);$var=$var1<=1 ? 'mes' : 'meses';
                if($diff>=12){$diff/=12;$var1=floor($diff);$var=$var1<=1 ? 'año' : 'años';}}}}
    echo 'Hace ',$var1,' ',$var;
}
function  bestSellerProduct($dateFrom, $dateTo)
{
    DB::select("select best_seller_products('" . $dateFrom . "','" . $dateTo . "')");
    return BestSellerProduct::all()->toArray();
}

function agentSales($dateFrom, $dateTo, $refresh=false)
{
    if ($refresh) {
        DB::select("select sales_by_agent('" . $dateFrom . "','" . $dateTo . "')");
    }
    return \App\Models\SalesByAgent::all()->toArray();
}

function totalStock()
{
    return StockItem::select('ideexi')
        ->where('cntexi','>',0)
        ->where('idebod','<>',20)
        ->sum('cntexi');
}
function customerCount($dateFrom, $dateTo)
{
    return Operation::select("idetrc")
        ->whereBetween('fechacontable', [
            $dateFrom,
            $dateTo])
        ->where("tipooperacion","=", 1)
        ->distinct('idetrc')
        ->count('idetrc');
}

function salesCount($dateFrom, $dateTo)
{
    return Operation::select('id')
        ->whereBetween('fechacontable', [
            $dateFrom,
            $dateTo])
        ->where("tipooperacion","=", 1)
        ->count();
}
//function agentSales2($dateFrom, $dateTo)
//{
//    $sales = Operation::select('agente')
//        ->whereBetween('fechacontable', [
//            $dateFrom,
//            $dateTo])
//        ->where("tipooperacion","=", 1)
//        ->with('agent')
//        ->where('agente','<>', '80803101')
//        ->where('agente','<>', '91226941')
//        ->where('agente','<>', '63295634')
//        ->selectRaw("COUNT(id) as operaciones")
//        ->selectRaw("SUM(vrsubtotal) as total")
//        ->groupBy('agente')
//        ->orderBy('total','desc')
//        ->get()
//        ->toArray();
//    $agentSales = [];
//    foreach (array_slice($sales,0,5) as $agent) {
//        $agentSales[] = [
//            'nombre' => $agent['agent']['nombrepila'],
//            'operaciones' => $agent['operaciones'],
//            'total' => $agent['total'],
//        ];
//    }
//    return $agentSales;
//}

function salesAmount($dateFrom, $dateTo, $refresh=false)
{
    if ($refresh) {
        DB::select("select sales_by_agent('" . $dateFrom . "','" . $dateTo . "')");
    }
    return \App\Models\SalesByAgent::all()
        ->sum('netsaleamount');

//    $sales = Operation::select("id")
//        ->whereBetween('fechacontable', [
//            $dateFrom,
//            $dateTo])
//        ->where("tipooperacion","=", 1)
//        ->sum('vrsubtotal');
//    $returns = Operation::select("id")
//        ->whereBetween('fechacontable', [
//            $dateFrom,
//            $dateTo])
//        ->where("tipooperacion","=", 2)
//        ->sum('vrsubtotal');
//    return $sales-$returns;
}
function itemSalesCount($dateFrom=null, $dateTo=null, $refresh=false)
{
    if ($refresh) {
        DB::select("select sales_by_agent('" . $dateFrom . "','" . $dateTo . "')");
    }
    return \App\Models\SalesByAgent::all()
        ->sum('netsalecount');
//    $dd = Operation::select('id')
//        ->whereBetween('fechacontable', [
//            $dateFrom,
//            $dateTo])
//        ->where("tipooperacion","=", 1)
//        ->withSum('salesDetails','canvdt')
//        ->withSum('salesDetails','candev')
//        ->get()
//        ->toArray()
//    ;
//    return array_reduce($dd, function($a, $x) {
//        return $a+$x['sales_details_sum_canvdt']-$x['sales_details_sum_candev'];
//    },0);
}
