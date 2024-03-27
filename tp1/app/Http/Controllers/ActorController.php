<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActorResource;
use App\Models\Actor;
use Exception;
use Illuminate\Database\QueryException;

class ActorController extends Controller
{
/**
 * @OA\Get(
 *     path="/actors",
 *     operationId="getActorsList",
 *     tags={"Actors"},
 *     summary="Get list of actors",
 *     description="Returns list of all actors",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Actor")
 *         )
 *     )
 * )
 */
    public function index()
    {
        return Actor::all();
    }

/**
 * @OA\Get(
 *     path="/actors/{id}",
 *     operationId="getActorById",
 *     tags={"Actors"},
 *     summary="Get actor by ID",
 *     description="Returns a single actor",
 *     @OA\Parameter(
 *         name="id",
 *         description="Actor id",
 *         required=true,
 *         in="path",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(ref="#/components/schemas/Actor")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Actor not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error"
 *     )
 * )
 */

     public function show(int $id)
    {
        try{
            return(new ActorResource(Actor::findOrFail($id)))->response()->setStatusCode(OK);
        }
        catch(QueryException $ex){
            abort(NOT_FOUND, "invalid id");
        }
        catch(Exception $ex){
            abort(SERVER_ERROR, "server error");
        }
    }
}
