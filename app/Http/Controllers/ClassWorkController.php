<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassworkRequest;
use App\Http\Requests\ClassworkSearchRequest;
use App\Models\Classes;
use App\Models\ClassWork;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpParser\Builder\Class_;

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

        return view('classworks.new_classwork',compact('grades'));
    }

    public function store(ClassworkRequest $request)
    {

        // dd($request->all());
        // Retrieve data from the request
        $gradeId = $request->gradeSelect;
        $classId = $request->classSelect;
        $curriculumId = $request->curriculumSelect;
        $topicName = $request->topic_name;
        $sourceTitles = $request->source_title;
        $urls = $request->url;
        $files = $request->file;
        $sourceTypes = $request->source_type;
        $subTopicNames = $request->sub_topic_name ?? []; // Default to empty array if null

        foreach ($sourceTitles as $index => $sourceTitle) {
            // Retrieve sub topic name if available
            $subTopicName = isset($subTopicNames[$index]) ? $subTopicNames[$index] : null;

            $classwork = Classwork::create([
                'grade_id' => $gradeId,
                'class_id' => $classId,
                'curriculum_id' => $curriculumId,
                'topic_name' => $topicName,
                'source_title' => $sourceTitle,
                'sub_topic_name' => $subTopicName
            ]);

            if ($sourceTypes[$index] == 'url') {
                $url = $urls[$index] ?? null;
                $classwork->update(['url' => $url]);
            } else {
                $file = $files[$index] ?? null;

                if($file != null){
                    $fileName = uniqid() . $file->getClientOriginalName();
                    // dd($filename);

                    $file->storeAs('classwork_files',$fileName);

                    $classwork->update(['file' => $fileName]);
                }
            }
        }

        return redirect()->route('classworks.search');
    }



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

        $classworks = ClassWork::where('topic_name', $topicName)->get();
        // dd($classworks->toArray());

        // $classworks = $classworks->groupBy('topic_name');
        $classworks = $classworks->groupBy('sub_topic_name');

        return view('classworks.view_classwork',compact('classworks','gradeName','className','topicName'));
    }

    public function edit(string $subTopicName)
    {


        $grades = Grade::with(['classes', 'curricula' => function($query) {
            $query->where('status', '1');
        }])
        ->get();

        $classworks = ClassWork::where('sub_topic_name',$subTopicName)->get();
        // dd($classworks->toArray());

        return view('classworks.edit',compact('classworks','grades'));
    }



    public function getMaxId(){

        $maxId = ClassWork::max('id');

        return $maxId;
    }


    public function updateData(Request $request){

        // dd($request->all());

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

                    $file->storeAs('classwork_files',$fileName);

                    $classwork->update(['file' => $fileName]);
                }
            }

        }


        return redirect()->route('classworks.index');

    }


    public function deleteWithSubTopicName($subTopicName){

        ClassWork::where('sub_topic_name',$subTopicName)->delete();

        return response()->json("success");

    }
}
