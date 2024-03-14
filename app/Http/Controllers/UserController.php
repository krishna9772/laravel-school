<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grade;
use App\Models\Classes;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\UserGradeClass;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function index()
    {
        $users = User::whereIn('user_type', ['teacher', 'student'])
         ->with(['userGradeClasses.grade', 'userGradeClasses.class'])
         ->get();

        return view('registrations.all_registrations',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grades = Grade::get();

        return view('registrations.new_registration',compact('grades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        Log::info($request->all());

        // Get the highest user ID from the database
        $highestId = intval(User::max('user_id')) ?? 0;

        // Increment the highest user ID and pad it with leading zeros
        $user_id = str_pad($highestId + 1, 5, '0', STR_PAD_LEFT);

        $data = $this->getUserData($request,$user_id);

        User::create($data);

        UserGradeClass::create([
            'user_id' => $user_id,
            'grade_id' => $request->grade_select,
            'class_id' => $request->class_select
        ]);

        // update capacity
        if ($request->user_type == 'student') {
            Classes::where('id', $request->class_select)->update(['capacity' => DB::raw('IFNULL(capacity, 0) + 1')]);
        }


        return response()->json('success');
    }

    public function filterUser($filterType){
        if($filterType == 'student'){

            $users = User::where('user_type', 'student')
                ->with(['userGradeClasses.grade', 'userGradeClasses.class'])
                ->get();
            // Log::info($users);

            return response()->json($users);
        }

        if($filterType == 'teacher'){
            // $users = User::where('user_type', 'student')->get();

            $users = User::where('user_type', 'teacher')
                ->with(['userGradeClasses.grade', 'userGradeClasses.class'])
                ->get();

            return response()->json($users);
        }

        if($filterType == 'all'){

            $users = User::whereIn('user_type', ['teacher', 'student'])
             ->with(['userGradeClasses.grade', 'userGradeClasses.class'])
             ->get();

            return response()->json($users);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $data = User::where('user_id',$id)->with('userGradeClasses')->first();

        // dd($data->toArray());

        $grades = Grade::with('classes')->get();

        return view('registrations.edit',compact('data','grades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {

        Log::info($request->all());
        $data = $this->getUserData($request,$id);

        User::where('user_id',$id)->update($data);

        UserGradeClass::where('user_id',$id)->updateOrCreate(
            [
                'user_id' => $id
            ],
            [
            'grade_id' => $request->grade_select,
            'class_id' => $request->class_select
            ]);

        return response()->json('success');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $user = User::where('id',$id)->first();

        $classId = UserGradeClass::where('user_id',$user->user_id)->value('class_id');
        // Log::info($classId);

        // decrease capcity in users table
        if ($user->user_type == 'student') {
            Classes::where('id', $classId)->update(['capacity' => DB::raw('IFNULL(capacity, 0) - 1')]);
        }

        User::where('id',$id)->delete();

        return response()->json('success');
    }

    private function getUserData($request,$user_id){

        return [
            'user_id' => $user_id,
            'user_name' => $request->user_name,
            'gender' => $request->gender,
            'user_type' => $request->user_type,
            'nrc' => $request->nrc,
            'admission_date' => $request->admission_date,
            'date_of_birth' => $request->date_of_birth,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'former_school' => $request->former_school
        ];
    }
}
