<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassworkSearchRequest;
use App\Models\Grade;
use Illuminate\Http\Request;

class ClassworkController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function search() {

        $grades = Grade::all();

        return view('classworks.search_classwork',compact('grades'));
    }

    public function searchResults(ClassworkSearchRequest $request){

        return response()->json('success');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
