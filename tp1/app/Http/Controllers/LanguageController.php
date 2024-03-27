<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Http\Request;
use App\Http\Resources\LanguageResouce;
use App\Http\Resources\LanguageResource;
use App\Models\Language;

class LanguageController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/languages",
 *     operationId="getLanguagesList",
 *     tags={"Languages"},
 *     summary="Get list of languages",
 *     description="Returns list of all languages",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Language")
 *         )
 *     )
 * )
 */
    public function index()
    {
        return Language::all();
    }
/**
 * @OA\Get(
 *     path="/api/languages/{id}",
 *     operationId="getLanguageById",
 *     tags={"Languages"},
 *     summary="Get language by ID",
 *     description="Returns a single language",
 *     @OA\Parameter(
 *         name="id",
 *         description="ID of the language to retrieve",
 *         required=true,
 *         in="path",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(ref="#/components/schemas/Language")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid ID supplied"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Language not found"
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
            return(new LanguageResource(Language::findOrFail($id)))->response()->setStatusCode(500);
        }
        catch(QueryException $ex){
            abort(INVALID_DATA, "invalid id");
        }
        catch(Exception $ex){
            abort(SERVER_ERROR, "server error");
        }
    }
}