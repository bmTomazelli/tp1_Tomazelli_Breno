<?php

namespace App\Http\Controllers;

use App\Http\Resources\CriticResource;
use App\Http\Resources\UserResource;
use App\Models\Language;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Exception;
use Facade\Ignition\Middleware\AddExceptionInformation;
use Illuminate\Auth\Events\Failed;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/users",
 *     summary="Get list of users",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/User")
 *         )
 *     )
 * )
 */
    public function index()
    {
        return User::all();
    }
/**
 * @OA\Get(
 *     path="/api/users/{id}",
 *     summary="Get user by ID",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User found",
 *         @OA\JsonContent(ref="#/components/schemas/User")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Invalid ID or user not found"
 *     )
 * )
 */
     public function show(int $id)
    {
        try{
            return(new UserResource(User::findOrFail($id)))->response()->setStatusCode(500);
        }
        catch(QueryException $ex){
            abort(404, "invalid id");
        }
        catch(Exception $ex){
            abort(500, "server error");
        }
    }
/**
 * @OA\Post(
 *     path="/api/users",
 *     summary="Create a new user",
 *     tags={"Users"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="User data",
 *         @OA\JsonContent(ref="#/components/schemas/User")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="User created",
 *         @OA\JsonContent(ref="#/components/schemas/User")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Validation failed or user already exists"
 *     )
 * )
 */
    public function store(Request $request){
        try{
         $user= User::create($request->validated());
         return (new UserResource($user))->response()->setStatusCode(201);
        }
        catch(Exception $ex){
            abort(404, "id already exists");
        }
    }
/**
 * @OA\Put(
 *     path="/api/users/{id}",
 *     operationId="updateUser",
 *     tags={"Users"},
 *     summary="Update an existing user",
 *     description="Updates an existing user with new data",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the user to update",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="User data that needs to be updated",
 *         @OA\JsonContent(
 *             required={"name","email"},
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
 *             @OA\Property(property="password", type="string", format="password", example="secret"),
 *             // Add other user properties here
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated successfully",
 *         @OA\JsonContent(ref="#/components/schemas/UserResource")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid ID supplied"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error"
 *     )
 * )
 */
    public function update(Request $request,$id){
        try{
        $user= User::findOrFail($id);
        $user->update($request->validated());
        return (new UserResource($user))->response()->setStatusCode(200);
       }
       catch(AddExceptionInformation $ex){
           abort(NO_CONTENT, "NO CONTENT");
       }
       catch(Exception $ex){
        
        abort(SERVER_ERROR, "SERVER ERROR");
       }
       catch(QueryException $ex){
           abort(NOT_FOUND, "user not found");
       }
    }
/**
 * @OA\Get(
 *     path="/api/users/{id}/favorite-language",
 *     operationId="getUserFavoriteLanguage",
 *     tags={"Users"},
 *     summary="Get user's favorite language",
 *     description="Returns the favorite language of a user based on the movies they've reviewed",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="The user ID to retrieve favorite language for",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="language_name", type="string", example="English"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found or no favorite language determined"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error"
 *     )
 * )
 */
    public function favoriteLanguage(int $id)
    {
        try {
            $user = User::findOrFail($id);
            $preferredLanguage = DB::table('critics')
                ->join('films', 'critics.film_id', '=', 'films.id')
                ->join('languages', 'films.language_id', '=', 'languages.id')
                ->where('critics.user_id', '=', $user->id)
                ->select('languages.name as language_name', DB::raw('count(*) as total'))
                ->groupBy('languages.name')
                ->orderBy('total', 'desc')
                ->orderBy('languages.name', 'asc')
                ->first();
    
            if (!$preferredLanguage) {
                return "No preferred language determined";
            }
            return $preferredLanguage->language_name;
        }  
        catch(Failed $ex){
            abort(INVALID_DATA, "Invalid data");
        }
        catch(QueryException $ex){
            abort(NOT_FOUND, "not found id");
        }
        catch(Exception $ex){
            abort(SERVER_ERROR, "server error");
        }
    }
}
