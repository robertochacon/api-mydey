<?php

namespace App\Http\Controllers;

use App\Models\Entities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntitiesController extends Controller
{

     /**
     * @OA\Get (
     *     path="/api/entities/all/{id}/",
     *      operationId="all_entities",
     *     tags={"Entities"},
     *     security={{ "apiAuth": {} }},
     *     summary="All entities",
     *     description="All entities",
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="Process"),
     *              @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
     *         )
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
    public function index(Request $request, $id_user)
    {
        $entities = Entities::where('id_user',$id_user)->get();
        $data = [];
        foreach ($entities as $key => $value) {
            $quotes = [];

            //process quotes
            $quotes['process'][] = DB::select("SELECT COUNT(*) as total_day FROM quotes WHERE id_entity = {$value->id} AND DATE(created_at) = CURDATE() AND status = 'process'")[0];
            $quotes['process'][] = DB::select("SELECT COUNT(*) as total_week FROM quotes WHERE id_entity = {$value->id} AND YEARWEEK(`created_at`, 1) = YEARWEEK(CURDATE(), 1) AND status = 'process'")[0];
            $quotes['process'][] = DB::select("SELECT COUNT(*) as total_month FROM quotes WHERE id_entity = {$value->id} AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND status = 'process'")[0];
            
            //process active
            $quotes['active'][] = DB::select("SELECT COUNT(*) as total_day FROM quotes WHERE id_entity = {$value->id} AND DATE(created_at) = CURDATE() AND status = 'active'")[0];
            $quotes['active'][] = DB::select("SELECT COUNT(*) as total_week FROM quotes WHERE id_entity = {$value->id} AND YEARWEEK(`created_at`, 1) = YEARWEEK(CURDATE(), 1) AND status = 'active'")[0];
            $quotes['active'][] = DB::select("SELECT COUNT(*) as total_month FROM quotes WHERE id_entity = {$value->id} AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND status = 'active'")[0];
            
            //process inactive
            $quotes['inactive'][] = DB::select("SELECT COUNT(*) as total_day FROM quotes WHERE id_entity = {$value->id} AND DATE(created_at) = CURDATE() AND status = 'inactive'")[0];
            $quotes['inactive'][] = DB::select("SELECT COUNT(*) as total_week FROM quotes WHERE id_entity = {$value->id} AND YEARWEEK(`created_at`, 1) = YEARWEEK(CURDATE(), 1) AND status = 'inactive'")[0];
            $quotes['inactive'][] = DB::select("SELECT COUNT(*) as total_month FROM quotes WHERE id_entity = {$value->id} AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND status = 'inactive'")[0];
            
            $value["quotes"] = $quotes;
            $data[] = $value;
        }
        return response()->json(["data"=>$data],200);
    }

     /**
     * @OA\Get (
     *     path="/api/entities/{id}",
     *     operationId="watch_entities",
     *     tags={"Entities"},
     *     security={{ "apiAuth": {} }},
     *     summary="See entity",
     *     description="See entity",
     *    @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="Process"),
     *              @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
     *         )
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
    public function watch($id){
        try{
            $service = Entities::find($id);
            return response()->json(["data"=>$service],200);
        }catch (Exception $e) {
            return response()->json(["data"=>"fail"],200);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/entities",
     *      operationId="store_entities",
     *      tags={"Entities"},
     *     security={{ "apiAuth": {} }},
     *      summary="Store entity",
     *      description="Store entity",
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"id_employee","description"},
     *            @OA\Property(property="id_employee", type="number", format="number", example="1"),
     *            @OA\Property(property="description", type="string", format="string", example="Description"),
     *            @OA\Property(property="total", type="number", format="number", example="100"),
     *            @OA\Property(property="type", type="string", format="string", example="commissions"),
     *         ),
     *      ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=""),
     *             @OA\Property(property="data",type="object")
     *          )
     *       )
     *  )
     */
    public function register(Request $request)
    {        
        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $uploadFile = $request->file('image');
            $file_name = $uploadFile->hashName();
            $uploadFile->storeAs('public/entities', $file_name);
            $data['image'] = request()->getSchemeAndHttpHost().'/storage/entities/'.$file_name;
        }
        $entities = new Entities($data);
        $entities->save();
        return response()->json(["data"=>$entities],200);
    }

    /**
     * @OA\Post(
     *      path="/api/entities/{id}",
     *      operationId="update_entities",
     *      tags={"Entities"},
     *     security={{ "apiAuth": {} }},
     *      summary="Update entity",
     *      description="Update entity",
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"id_employee","description"},
     *            @OA\Property(property="id_employee", type="number", format="number", example="1"),
     *            @OA\Property(property="description", type="string", format="string", example="Description"),
     *            @OA\Property(property="total", type="number", format="number", example="100"),
     *            @OA\Property(property="type", type="string", format="string", example="commissions"),
     *         ),
     *      ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=""),
     *             @OA\Property(property="data",type="object")
     *          )
     *       )
     *  )
     */

    public function update(Request $request, $id){
        try{
            $entities = Entities::where('id',$id)->first();
            $data = $request->all();

            if ($request->hasFile('image')) {
                $uploadFile = $request->file('image');
                $file_name = $uploadFile->hashName();
                $uploadFile->storeAs('public/entities', $file_name);
                $data['image'] = request()->getSchemeAndHttpHost().'/storage/entities/'.$file_name;
            }

            $entities->update($data);
            return response()->json(["data"=>$entities],200);
        }catch (Exception $e) {
            return response()->json(["data"=>"fail"],200);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/entities/{id}",
     *      operationId="delete_entities",
     *      tags={"Entities"},
     *     security={{ "apiAuth": {} }},
     *      summary="Delete entity",
     *      description="Delete entity",
     *    @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=""),
     *             @OA\Property(property="data",type="object")
     *          )
     *       )
     *  )
     */

    public function delete($id){
        try{
            $entities = Entities::destroy($id);
            return response()->json(["data"=>"ok"],200);
        }catch (Exception $e) {
            return response()->json(["data"=>"fail"],200);
        }
    }

}
