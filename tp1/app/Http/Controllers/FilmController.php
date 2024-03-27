<?php

namespace App\Http\Controllers;

use App\Http\Resources\FilmResource;
use Illuminate\Http\Request;
use App\Models\Film;
use Dflydev\DotAccessData\Exception\DataException;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Routing\Exception\NoConfigurationException;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     /**
 * @OA\Get(
 *     path="/api/films",
 *     operationId="getFilmsList",
 *     tags={"Films"},
 *     summary="Get list of films",
 *     description="Returns list of all films",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Film"))
 *     )
 * )
 */
    public function index()
    {
        return Film::all();
    }

    
/**
 * @OA\Get(
 *     path="/api/films/show",
 *     operationId="searchFilms",
 *     tags={"Films"},
 *     summary="Search films",
 *     description="Search films based on criteria",
 *     @OA\Parameter(
 *         name="keyword",
 *         in="query",
 *         description="Keyword to search in film titles",
 *         required=false,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="rating",
 *         in="query",
 *         description="Film rating to filter",
 *         required=false,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="minLength",
 *         in="query",
 *         description="Minimum length of film",
 *         required=false,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="maxLength",
 *         in="query",
 *         description="Maximum length of film",
 *         required=false,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Film"))
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid query"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error"
 *     )
 * )
 */
    public function show(Request $request)
    {
        try {
            $query = DB::table('films');

            
            if ($request->has('keyword')) {
                $keyword = $request->keyword;
                $query->where('title', 'like', "%{$keyword}%");
            }

            if ($request->has('rating')) {
                $rating = $request->rating;
                $query->where('rating', $rating);
            }

            if ($request->has('minLength')) {
                $minLength = $request->minLength;
                $query->where('length', '>=', $minLength);
            }

            if ($request->has('maxLength')) {
                $maxLength = $request->maxLength;
                $query->where('length', '<=', $maxLength);
            }

            $films = $query->paginate(20);

            return response()->json($films);
        } catch (QueryException $ex) {
            abort(NOT_FOUND, 'Invalid query');
        } catch (\Exception $ex) {
            abort(SERVER_ERROR, 'An unexpected error occurred');
        }
    }
    /**
 * @OA\Get(
 *     path="/api/films/{id}/calculateAvg",
 *     operationId="calculateFilmAverageScore",
 *     tags={"Films"},
 *     summary="Calculate average score of a film",
 *     description="Calculates and returns the average score of a film by its ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the film",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="number",
 *             format="float"
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
    
    public function calculateAvg(int $id){
        try{
            $film= Film::findOrFail($id);
            return round($film->critics()->avg('score'),2);
        }
        catch(QueryException $ex){
            abort(NOT_FOUND, "invalid id");
        }
        catch(Exception $ex){
            abort(SERVER_ERROR, "server error");
        }
    }
/**
 * @OA\Post(
 *     path="/api/films",
 *     operationId="storeFilm",
 *     tags={"Films"},
 *     summary="Store a new film",
 *     description="Stores a new film and returns film data",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Pass film data",
 *         @OA\JsonContent(ref="#/components/schemas/Film")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Successful operation",
 *         @OA\JsonContent(ref="#/components/schemas/Film")
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Data validation failed"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error"
 *     )
 * )
 */
    public function store(Request $request){
       try{
        $film= Film::create($request->validated());
        return (new FilmResource($film));
       }
       catch(DataException $ex){
            abort(NO_CONTENT,"empty data");
        }
       catch(QueryException $ex){
        abort(NOT_FOUND,"One or more items are rong");
        }
        catch(Exception $ex){
            abort(SERVER_ERROR, "server error");
        }
    }


}
