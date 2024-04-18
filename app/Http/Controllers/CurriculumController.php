<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Util\Str;
use App\Models\Grade;
use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

use App\Http\Requests\CurriculumRequest;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(){
        $curriculums = Curriculum::where('status','1')->with('grade')->with('user')->get();

        // Group the data by 'grade_id'
        $groupedCurriculums = $curriculums->groupBy('grade_id');

        // Paginate the grouped data
        $page = request()->get('page', 1); // Get the current page from the request, default to 1
        $perPage = 6; // Set the number of items per page
        $offset = ($page * $perPage) - $perPage;

        $paginatedData = new LengthAwarePaginator(
            $groupedCurriculums->forPage($page, $perPage), // Get items for current page
            $groupedCurriculums->count(), // Total items
            $perPage, // Items per page
            $page, // Current page
            ['path' => request()->url(), 'query' => request()->query()] // Additional options
        );
        

        return view('curriculums.all_curriculums',compact('paginatedData'));
    }



    public function create()
    {
        $grades = Grade::all();

        $teachers = User::with('userGradeClasses')->where('user_type','teacher')->where('teacher_type','subject')->get();
        // dd($teachers->toArray());

        return view('curriculums.new_curriculum',compact('grades','teachers'));
    }

    public function store(CurriculumRequest $request)
    {
        // Log::info($request->all());

        $curriculumNames = $request->curriculum_name;
        $teacherIds = $request->teacher_id;

        if (count($curriculumNames) !== count($teacherIds)) {
            return response()->json(['error' => 'Number of curriculum names does not match number of teacher IDs'], 400);
        }


        foreach ($curriculumNames as $index => $curriculumName) {
            Curriculum::create([
                'user_id' => $teacherIds[$index],
                'grade_id' => $request->grade_id,
                'curriculum_name' => $curriculumName,
            ]);
        }

        Session::put('message','Successfully added !');
        Session::put('alert-type','success');

        return response()->json('success');
    }


    public function modify(){
        return view('curriculums.update_delete');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    public function filterCurriculum($filter_type){

        if($filter_type == 'all'){
            $curriculums = Curriculum::where('status','1')->with('grade')->with('user')->get();
        }else{
            $curriculums = Curriculum::where('status','1')->with('grade')->with('user')->where('grade_id',$filter_type)->get();
        }

        // $curriculums = Curriculum::where('status','1')->with('grade')->with('user')->get();

        // Group the data by 'grade_id'
        $groupedCurriculums = $curriculums->groupBy('grade_id');

        // Paginate the grouped data
        $page = request()->get('page', 1); // Get the current page from the request, default to 1
        $perPage = 6; // Set the number of items per page
        $offset = ($page * $perPage) - $perPage;

        $paginatedData = new LengthAwarePaginator(
            $groupedCurriculums->forPage($page, $perPage),
            $groupedCurriculums->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $data = $paginatedData;

        return response()->json($data);
    }

    public function edit(string $id)
    {
        $curriculums = Curriculum::where('status','1')->with('grade')->with('user')->where('grade_id',$id)->get();

        $gradeId = $id;

        $gradeName = Grade::where('id',$id)->value('grade_name');

        $grades = Grade::all();

        $teachers = User::where('user_type','teacher')->get();

        return view('curriculums.edit',compact('curriculums','grades','gradeId','teachers','gradeName'));
    }


    public function updateData(CurriculumRequest $request){
        Log::info($request->all());

        $curriculumIds = $request->curriculum_id;
        $curriculumNames = $request->curriculum_name;
        $teacherIds = $request->teacher_id;

        foreach ($curriculumIds as $index => $curriculumId) {
            Curriculum::updateOrCreate(
                ['id' => $curriculumId],
                [
                    'user_id' => $teacherIds[$index],
                    'grade_id' => $request->grade_id,
                    'curriculum_name' => $curriculumNames[$index],
                    'status' => '1',
                    'deleted_at' => null
                ]
            );
        }

        Session::put('message','Successfully updated !');
        Session::put('alert-type','success');


        return response()->json('success');
    }

    public function curriculumDeleteWithGrade($gradeId){

        Curriculum::where('grade_id',$gradeId)->update([
            'status' => '0',
            'deleted_at' => Carbon::now()
        ]);

        return response()->json('success');
    }


    public function getMaxId()
    {
        $maxId = Curriculum::max('id');

        return $maxId;
    }


    public function destroy(string $id)
    {

        Curriculum::where('id',$id)->update([
            'status' => '0',
            'deleted_at' => Carbon::now()
        ]);

        Session::put('message','Successfully destroyed !');
        Session::put('alert-type','success');

        return response()->json('success');
    }
}
