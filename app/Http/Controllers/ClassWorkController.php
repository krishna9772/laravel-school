<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Grade;
use App\Models\Classes;
use App\Models\ClassWork;
use App\Models\Curriculum;
use Illuminate\Http\Request;
use PhpParser\Builder\Class_;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ClassworkRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ClassworkSearchRequest;
use App\Models\UserGradeClass;
use Illuminate\Support\Facades\Session as FacadesSession;

class ClassworkController extends Controller
{

    // function __construct()
    // {
    //     $this->middleware(['permission:manage classworks'], ['only' => ['index', 'create','searchResults','store','search','show','edit','destory','deleteWithSubTopicName','updateData','getMaxId']]);
    //     $this->middleware(['permission:edit classworks'], ['only' => ['index', 'create','searchResults','store','search','show','edit','destory','deleteWithSubTopicName','updateData','getMaxId']]);
    // }

    public function index()
    {

        if(Auth::user()->user_type != 'teacher' && Auth::user()->user_type != 'student'){
            $grades = Grade::with('classes')->get();

            return view('classworks.search_classwork',compact('grades'));
        }
        elseif(Auth::user()->user_type == 'teacher' && Auth::user()->teacher_type == 'subject'){

            $teacherGradeClass = User::where('user_id',Auth::user()->user_id)->with('userGradeClasses')->first();
            // dd($teacherGradeClass->toArray());
            $gradeId = $teacherGradeClass->userGradeClasses[0]->grade_id;
            $classId = $teacherGradeClass->userGradeClasses[0]->class_id;
            // dd($gradeId);
            // $gradeName = Grade::where('id',)

            $gradeName = Grade::where('id',$gradeId)->value('grade_name');
            $className = Classes::where('id',$classId)->value('class_name');

            $classworks = ClassWork::where('grade_id',$gradeId)
                          ->where('class_id',$classId)
                          ->where('status','1')
                          ->get();

            $groupedClasswork = $classworks->groupBy('topic_name');

            // dd($groupedClasswork);
            // Log::info($groupedClasswork);

            return view('classworks.search_results',compact('groupedClasswork','gradeName','className'));

        }

    }

    public function create()
    {
        $grades = Grade::with(['classes', 'curricula' => function($query) {
            $query->where('status', '1');
        }])
        ->get();

        $teacherGradeClass = User::where('user_id',Auth::user()->user_id)->with('userGradeClasses')->first();
        // dd($teacherGradeClass->toArray());
        // $curriculumId = Curriculum::where('user_id',Auth::user()->user_id)->pluck('id');
        // dd($teacherGradeClass->userGradeClasses[0]->grade_id);

        $curriculums  = Curriculum::where('user_id',Auth::user()->id)->get();
        // dd($curriculumIds);



        return view('classworks.new_classwork',compact('grades','teacherGradeClass','curriculums'));
    }

    public function store(Request $request)
    {
        Log::info($request->all());





        foreach ($request->source_type as $index => $sourceType) {

            $classwork = new Classwork();

            $classwork->grade_id = $request->gradeSelect;
            $classwork->class_id = $request->classSelect;
            $classwork->curriculum_id = $request->curriculumSelect;
            $classwork->topic_name = $request->topic_name;
            $classwork->file_type = $sourceType;
            $classwork->source_title = $request->source_title[$index];
            $classwork->sub_topic_name = $request->sub_topic_name[$index];
            $classwork->url = $request->url[$index];
            $classwork->file = $request->file[$index];

            $classwork->save();



            // if ($type == 'url') {
            //     $classwork->url = $request->url[$index];

            //     $classwork->file = null;
            // } elseif ($type == 'file') {

            //     $file = $request->file[$index];

                // $classwork->file = $file;

                // $fileName = uniqid() . '_' . $file->getClientOriginalName();

                // $classwork->file = $file;

                // $file->storeAs('public/classwork_files',$file);

                // $fileName = $request->file[]->getClientOriginalName();
                // Log::info("file name is " . $fileName);



                // $classwork->file = $request->file[$index]->getClientOriginalExtension();
                // $source['file'] = $request->file[$index]->store('classwork_files');
            //     $classwork->url = null;
            // }


        }

        // Save the classwork
        // $classwork->save();

        // Optionally, log the saved data
        // Log::info('Classwork saved:', $classwork->toArray());

        Session::put('message','Successfully added !');
        Session::put('alert-type','success');



        return response()->json('success');
    }


    // public function store(Request $request)
    // {

    //     $classwork = new Classwork();

    //     // Assign request data to model attributes
    //     $classwork->grade = $request->gradeSelect;
    //     $classwork->class = $request->classSelect;
    //     $classwork->curriculum = $request->curriculumSelect;
    //     $classwork->topic_name = $request->topic_name;

    //     // Loop through source_type array to handle multiple sources
    //     foreach ($request->source_type as $index => $type) {
    //         $source = [
    //             'type' => $type,
    //             'title' => $request->source_title[$index],
    //         ];

    //         // Depending on source type, assign appropriate data
    //         if ($type === 'url') {
    //             $source['url'] = $request->url[$index];
    //         } elseif ($type === 'file') {
    //             // Here, you can handle file upload and storage logic
    //             // For now, I'm assuming you'll store the file path
    //             $source['file'] = $request->file[$index];
    //         }

    //         // Add source to classwork
    //         $classwork->sources()->create($source);
    //     }

    //     // Save the classwork
    //     $classwork->save();

    //     // Optionally, log the saved data
    //     Log::info('Classwork saved:', $classwork->toArray());

    //     // dd($request->all());

    //     // foreach ($request->input('source_type') as $key => $sourceType) {
    //     //     // dd($key);
    //     //     $classwork = new Classwork();
    //     //     $classwork->grade_id = $request->input('gradeSelect');
    //     //     $classwork->class_id = $request->input('classSelect');
    //     //     $classwork->curriculum_id = $request->input('curriculumSelect');
    //     //     $classwork->topic_name = $request->input('topic_name');
    //     //     // $classwork->source_type = $sourceType;
    //     //     $classwork->sub_topic_name = $request->input('sub_topic_name.'.$key);
    //     //     $classwork->source_title = $request->input('source_title.'.$key);

    //     //     // Handle URL or file based on source type
    //     //     if ($sourceType === 'url') {
    //     //         $classwork->url = $request->input('url.'.$key);
    //     //         $classwork->file = null; // Set file to null if URL is provided
    //     //     } else {
    //     //         // Handle file upload
    //     //         if ($request->hasFile('file.'.$key)) {
    //     //             $file = $request->file('file.'.$key);
    //     //             $fileName = $file->getClientOriginalName();
    //     //             $file->storeAs('uploads', $fileName); // Store the file
    //     //             $classwork->file = $fileName;
    //     //         }
    //     //         $classwork->url = null; // Set URL to null if file is provided
    //     //     }

    //     //     $classwork->save();
    //     // }

    //     Session::put('message','Successfully added !');
    //     Session::put('alert-type','success');

    //     return response()->json('success', 200);

    //     // return redirect()->route('classworks.search');
    // }

    public function search() {

        $grades = Grade::all();

        return view('classworks.search_classwork',compact('grades'));
    }

    public function searchResults(ClassworkSearchRequest $request){

        // Log::info($request->all());

        $gradeName = Grade::where('id',$request->grade_select)->value('grade_name');
        $className = Classes::where('id',$request->class_select)->value('class_name');

        $classworks = ClassWork::where('grade_id',$request->grade_select)
                      ->where('class_id',$request->class_select)
                      ->where('status','1')
                      ->get();

        $groupedClasswork = $classworks->groupBy('topic_name');

        // dd($groupedClasswork);
        Log::info($groupedClasswork);

        return view('classworks.search_results',compact('groupedClasswork','gradeName','className'));
    }

    public function show(string $topicName,Request $request)
    {

        // dd($request->all());
        // dd($topicName);

        $gradeName = $request->grade_name;
        $className = $request->class_name;

        $classworks = ClassWork::where('topic_name', $topicName)
                      ->where('status','1')
                      ->get();
        // dd($classworks->toArray());

        // $classworks = $classworks->groupBy('topic_name');
        $classworks = $classworks->groupBy('sub_topic_name');

        return view('classworks.view_classwork',compact('classworks','gradeName','className','topicName'));
    }

    public function edit(string $subTopicName)
    {

        $user = Auth::user();

        if($user->user_type == 'admin' || ($user->user_type == 'teacher' && $user->teacher_type == 'classroom')){
            $grades = Grade::with(['classes', 'curricula' => function($query) {
                $query->where('status', '1');
            }])
            ->get();

            $classworks = ClassWork::where('sub_topic_name',$subTopicName)->where('status','1')->get();
            // dd($classworks->toArray());

            $gradeId = $classworks[0]->grade_id;
            // dd($gradeId);

            $classId = $classworks[0]->class_id;
            // dd($classId);

            $curriculumId = $classworks[0]->curriculum_id;

        }elseif($user->user_type == 'teacher' && $user->teacher_type == 'subject'){

            $teacher_id = $user->user_id;

            $teacherData = UserGradeClass::where('user_id',$teacher_id)->first();

            $grades = Grade::where('grade_id',$teacherData->grade_id)
                ->with(['classes', 'curricula' => function($query) {
                $query->where('status', '1');
            }])
            ->get();

            // dd($grades);

            $classworks = ClassWork::where('sub_topic_name',$subTopicName)->where('status','1')->get();
            // dd($classworks->toArray());

            $gradeId = $classworks[0]->grade_id;
            // dd($gradeId);

            $classId = $classworks[0]->class_id;
            // dd($classId);

            $curriculumId = $classworks[0]->curriculum_id;


        }


        // dd($curriculumId);

        return view('classworks.edit',compact('classworks','grades','gradeId','classId','curriculumId'));
    }



    public function getMaxId(){

        $maxId = ClassWork::max('id');

        return $maxId;
    }


    public function updateData(Request $request){

        // dd($request->all());
        Log::info($request->all());

        $classworkIds = $request->classwork_id;
        $sourceTypes = $request->source_type;
        $topic_name = $request->topic_name;
        $subTopicNames = $request->sub_topic_name;
        $sourceTitles = $request->source_title;
        $urls = $request->url;
        $files = $request->file;

        foreach($classworkIds as $index => $classworkId){
            $classwork = ClassWork::updateOrCreate(
                ['id' => $classworkId],
                [
                    'grade_id' => $request->gradeSelect,
                    'class_id' => $request->classSelect,
                    'curriculum_id' => $request->curriculumSelect,
                    'topic_name' => $topic_name,
                    'sub_topic_name' => $subTopicNames[$index],
                    'source_title' => $sourceTitles[$index],
                    'status' => '1',
                    'deleted_at' => null
                ]
            );


            if ($sourceTypes[$index] == 'url') {
                $url = $urls[$index] ?? null;
                $classwork->update(['url' => $url]);
            } else {
                $file = $files[$index] ?? null;

                if($file != null){
                    $fileName = uniqid() . $file->getClientOriginalName();
                    // dd($filename);

                    $file->storeAs('public/classwork_files',$fileName);

                    $classwork->update(['file' => $fileName]);
                }
            }

        }

        Session::put('message','Successfully updated !');
        Session::put('alert-type','success');

        return redirect()->route('classworks.index');
    }


    public function deleteWithSubTopicName($subTopicName){

        ClassWork::where('sub_topic_name',$subTopicName)->delete();

        return response()->json("success");
    }

    public function destroy(String $classworkId){

        ClassWork::where('id',$classworkId)->update([
            'status' => '0',
            'deleted_at' => Carbon::now(),
        ]);

        return response()->json('success');
    }

}