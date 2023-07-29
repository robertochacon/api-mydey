<?php

namespace App\Http\Controllers;

use App\Models\Bills;
use App\Models\EmployeeExpense;
use App\Models\Employee;
use App\Models\InvoiceQuote;
use App\Models\EquipmentRental;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

     /**
     * @OA\Get (
     *     path="/api/dashboard",
     *      operationId="dashboard",
     *     tags={"Dashboard"},
     *     security={{ "apiAuth": {} }},
     *     summary="All dashboard",
     *     description="All dashboard",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent()
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="NOT FOUND",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Cliente] #id"),
     *          )
     *      )
     * )
     */
    public function index()
    {
        try{
            $data[] = 0;

            //invoice
            // $data['invoice'][] = DB::select("SELECT SUM(total) as day, COUNT(id) as total_day FROM invoice_quote WHERE DATE(created_at) = CURDATE() AND type = 'invoice'");
            // $data['invoice'][] = DB::select("SELECT SUM(total) as week, COUNT(id) as total_week FROM invoice_quote WHERE YEARWEEK(`created_at`, 1) = YEARWEEK(CURDATE(), 1) AND type = 'invoice'");
            // $data['invoice'][] = DB::select("SELECT SUM(total) as month, COUNT(id) as total_month FROM invoice_quote WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND type = 'invoice'");
            //quote
            // $data['quote'][] = DB::select("SELECT SUM(total) as day, COUNT(id) as total_day FROM invoice_quote WHERE DATE(created_at) = CURDATE() AND type = 'quote'");
            // $data['quote'][] = DB::select("SELECT SUM(total) as week, COUNT(id) as total_week FROM invoice_quote WHERE YEARWEEK(`created_at`, 1) = YEARWEEK(CURDATE(), 1) AND type = 'quote'");
            // $data['quote'][] = DB::select("SELECT SUM(total) as month, COUNT(id) as total_month FROM invoice_quote WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND type = 'quote'");

            return response()->json(["data"=>$data],200);
        }catch (Exception $e) {
            return response()->json(["data"=>[]],200);
        }

    }

}
