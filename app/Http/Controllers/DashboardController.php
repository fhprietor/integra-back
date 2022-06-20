<?php

namespace App\Http\Controllers;

use App\Models\ApplicationLog;
use App\Models\Operation;
use App\Models\Customer\Tracking;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function overview(): Response
    {
        $salesCountLastYear = salesCount(
            Carbon::now()->subYear(1)->startOfMonth(),
            Carbon::now()->subYear());
        $salesCountThisMonth = salesCount(
            Carbon::now()->startOfMonth(),
            Carbon::now());
        if ($salesCountLastYear == 0)
            $percentSalesCount = 0;
        else
            $percentSalesCount = round(($salesCountThisMonth-$salesCountLastYear)/$salesCountLastYear*100,0);

        // Datos del periodo anterior
        $itemSalesCountLastMonth = itemSalesCount(
            Carbon::now()->subYear(1)->startOfMonth(),
            Carbon::now()->subYear(1),
            true); // Solo hacemos el llamado al stored procedure la consulta una vez
        $salesAmountLastMonth = salesAmount(
            Carbon::now()->subYear(1)->startOfMonth(),
            Carbon::now()->subYear(1),
            false);

        // Datos del periodo actual
        $itemSalesCountThisMonth = itemSalesCount(
            Carbon::now()->startOfMonth(),
            Carbon::now(),
            true);
        $salesAmountThisMonth = salesAmount(
            Carbon::now()->startOfMonth(),
            Carbon::now(),
            false);

        if ($itemSalesCountLastMonth === 0) {
            $itemPercentSales = 0;
        }
        else {
            $itemPercentSales = round(($itemSalesCountThisMonth - $itemSalesCountLastMonth) / $itemSalesCountLastMonth * 100, 0);
        }

        $totalStock = totalStock();

        $customerCountLastMonth = customerCount(
            Carbon::now()->subYear(1)->startOfMonth(),
            Carbon::now()->subYear(1));
        $customerCountThisMonth = customerCount(
            Carbon::now()->startOfMonth(),
            Carbon::now());
        if ($customerCountLastMonth === 0) {
            $customerPercent = 0;
        }
        else {
            $customerPercent = round(($customerCountThisMonth - $customerCountLastMonth) / $customerCountLastMonth * 100, 0);
        }


        $salesByAgent = agentSales(
            Carbon::now()->startOfMonth(),
            Carbon::now());

        $bestSellerProduct = bestSellerProduct(
            Carbon::now()->subWeek(4),
            Carbon::now());

        $lastOperations = Operation::orderBy('fechahora','desc')
            ->whereIn('tipooperacion',[1,2,9])
            ->limit(10)
            ->with('numeration')
            ->get()->toArray();
        $lastSales = Operation::orderBy('fechahora','desc')
            ->whereIn('tipooperacion',[1,2])
            ->limit(30)
            ->with('numeration')
            ->with('customer')
            ->get()->toArray();

        $lastTracking = Tracking::orderBy('Fecha','desc')
            ->limit(10)
            ->with('customer')
            ->with('user')
            ->get()->toArray();

        return response([
                'lastSales'                 => $lastSales,
                'bestSellerProduct'         =>$bestSellerProduct,
            'salesCountThisMonth' => $salesCountThisMonth,
                'percentSalesCount'=> $percentSalesCount,
                'itemSalesCountThisMonth'=> $itemSalesCountThisMonth,
                'itemPercentSales' => $itemPercentSales,
                'totalStock' => $totalStock,
                'customerCountThisMonth'=>$customerCountThisMonth,
                'customerPercent'=>$customerPercent,
                'salesAmountLastMonth'=>$salesAmountLastMonth,
                'salesAmountThisMonth'=>$salesAmountThisMonth,
                'salesByAgent'=>$salesByAgent,
                'lastOperations'=>$lastOperations,
                'lastTracking'=>$lastTracking,
                ]
        );
    }

}
