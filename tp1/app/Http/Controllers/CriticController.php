<?php

namespace App\Http\Controllers;

use App\Http\Resources\CriticResource;
use App\Models\Critic;
use App\Models\Film;
use Exception;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CriticController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/films/{filmId}/critics",
 *     operationId="getCriticsByFilm",
 *     tags={"Critics"},
 *     summary="Get list of critics by film ID",
 *     description="Returns a list of critics for a specific film",
 *     @OA\Parameter(
 *         name="filmId",
 *         description="ID of the film to retrieve critics for",
 *         required=true,
 *         in="path",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/CriticResource")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Film not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error"
 *     )
 * )
 */
    public function index($filmId)
    {
        try {
            $film = Film::findOrFail($filmId);
            $critics = $film->critics;
            return CriticResource::collection($critics)->response()->setStatusCode(200);;
        }  catch(QueryException $ex){
            abort(404, "invalid id");
        }
        catch(Exception $ex){
            abort(500, "server error");
        }
    }
/**
 * @OA\Delete(
 *     path="/api/films/{filmId}/critics/{criticId}",
 *     operationId="deleteCritic",
 *     tags={"Critics"},
 *     summary="Delete a critic by ID for a specific film",
 *     description="Deletes a critic for a specific film",
 *     @OA\Parameter(
 *         name="filmId",
 *         description="ID of the film",
 *         required=true,
 *         in="path",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="criticId",
 *         description="ID of the critic to delete",
 *         required=true,
 *         in="path",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Critic deleted successfully"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Invalid ID or Critic/Film not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error"
 *     )
 * )
 */
    public function delete($filmId,$criticId){
        try{
        $film = Film::findOrFail($filmId);
        $critic= $film->critics()->findOrFail($criticId);
        return $critic::delete()->response()->setStatusCode(OK);
    }
    catch(QueryException $ex){
        abort(NOT_FOUND, "invalid id");
    }
    catch(Exception $ex){
        abort(SERVER_ERROR, "server error");
    }
        
    }
}

