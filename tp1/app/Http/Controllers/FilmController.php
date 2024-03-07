<?php

namespace App\Http\Controllers;

use App\Http\Resources\FilmResource;
use Illuminate\Http\Request;
use App\Models\Film;
use Illuminate\Database\QueryException;
use Exception;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Film::all();
    }

    public function show(int $id)
    {
        try{
            return(new Film(Film::findOrFail($id)))->response()->setStatusCode(500);
        }
        catch(QueryException $ex){
            abort(404, "invalid id");
        }
        catch(Exception $ex){
            abort(500, "server error");
        }
    }
    public function store(Request $request){
       try{
        $film= Film::create($request->validated());
        return (new FilmResource($film));
       }
       catch(Exception $ex){

       }
    }


}
