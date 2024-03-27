<?php

namespace App\Http\Controllers;

use App\Http\Resources\Actor_FilmResource;
use App\Http\Resources\ActorResource;
use App\Models\Film;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class Actor_FilmController extends Controller

/**
 * @OA\Get(
 *     path="/actor_film/{filmId}",
 *     summary="Retrieves actors associated with a given film",
 *     tags={"ActorFilm"},
 *     @OA\Parameter(
 *         name="filmId",
 *         in="path",
 *         required=true,
 *         description="The ID of the film to retrieve actors for",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/ActorResource")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Not Found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server Error"
 *     )
 * )
 */
{
    public function index($filmId)
    {
        try {
            $film = Film::findOrFail($filmId);
            $actors = $film->actors;
            return ActorResource::collection($actors)->response()->setStatusCode(OK);
        }
        catch(QueryException $ex){
            abort(NOT_FOUND, "invalid id");
        }
        catch(Exception $ex){
            abort(SERVER_ERROR, "server error");
        }
    }
}
