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
    public function index()
    {
        return Language::all();
    }

    public function show(int $id)
    {
        try{
            return(new LanguageResource(Language::findOrFail($id)))->response()->setStatusCode(500);
        }
        catch(QueryException $ex){
            abort(404, "invalid id");
        }
        catch(Exception $ex){
            abort(500, "server error");
        }
    }

    public function store(Request $request){
        
    }
}