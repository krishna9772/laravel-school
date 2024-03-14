<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassworkSearchRequest;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClassworkController extends Controller
{

    public function index()
    {

        $grades = Grade::with('classes')->get();

        return view('classworks.search_classwork',compact('grades'));
    }

    public function create()
    {
        $grades = Grade::with(['classes', 'curricula' => function($query) {
            $query->where('status', '1');
        }])
        ->get();

        // dd($grades->toArray());

        // foreach ($grades as $grade) {
        //     // Loop only through curriculums with status 1
        //     foreach ($grade->curricula as $curriculum) {

        //         echo $curriculum->status;

        //       if ($curriculum->status == '1') {
        //         echo 'status is ' . $curriculum->curriculum_name . '<br>';
        //       }else{
        //         echo 'status is 0';
        //       }
        //     }
        //   }



        // $grades = Grade::all();

        // dd($grades->toArray());

        return view('classworks.new_classwork',compact('grades'));
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

        Log::info($request->all());

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
