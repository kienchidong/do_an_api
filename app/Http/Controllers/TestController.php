<?php

namespace App\Http\Controllers;

use App\AdminModel;
use App\Exports\GroupQuestionExport;
use App\Exports\SimpleQuestionsExport;
use App\Http\Resources\Excel\GroupQuestions\ExcelGroupQuestionCollection;
use App\Http\Resources\Questions\GroupQuestionsCollection;
use App\Http\Resources\Questions\QuestionsCollection;
use App\Http\Resources\Result\ResultCollection;
use App\Http\Resources\Result\ResultResource;
use App\Imports\GroupQuestions\GroupQuestionsImport;
use App\Imports\SimpleQuestions\SimpleQuestionsImport;
use App\Model\Question\QuestionGroupModel;
use App\Model\Question\QuestionModel;
use App\Model\ResultModel;
use App\Traits\ApiResponser;
use App\Traits\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TestController extends Controller
{
    //
    use ApiResponser;
    use FileUpload;

    public $label = ['A', 'B', 'C', 'D'];

    public function test()
    {
        dd(Auth::user());
        //$list = QuestionModel::whereNull('group_id')->paginate(10);

        //return response()->json(new QuestionsCollection($list));
        /*   $group = QuestionGroupModel::paginate(10);
           return $this->successResponseMessage(new GroupQuestionsCollection($group), 200, 'get success');*/
        //return Excel::download(new SimpleQuestionsExport(1), 'simpleQuestion.xlsx');
       /* $html = file_get_html('https://www.youtube.com/watch?v=2cblKNffVPg');

        $meta = $html->find('meta[property=og:title]', 0);

        dd($meta->content);*/
         $url = "https://www.youtube.com/watch?v=2cblKNffVPg";
         $headers = str_get_html(file_get_contents($url));

         dd($headers);
         if(strpos($headers[0],'404') === false)
         {
             echo "URL Exists";
         }
         else
         {
             echo "URL Not Exists";
         }
         die();
        //echo $meta->content;

        $question = QuestionModel::whereNull('group_id')->get();
        $array = [];
        foreach ($question as $key => $value) {
            $array[$key]['question'] = $value->question;
            foreach ($value->answers as $answerKey => $answer) {
                $array[$key][$this->label[$answerKey]] = $answer->answer;
                if ($answer->status) {
                    $array[$key]['right'] = $this->label[$answerKey];
                }
                $array[$key]['explain'] = $answer->explain;
            }
        }

        return view('Excel.SimpleQuestion', compact('array'));
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file;

            $abc = $this->uploadFile('upload', $file);
            return response()->json(['ok' => $abc]);
        }
        return response()->json(['ok' => 'ok1']);
        return response()->json($request->all());
    }

    public function test2(Request $request)
    {
        //return Excel::download(new GroupQuestionExport(), 'group.xlsx');

       /* Excel::import(new GroupQuestionsImport(), $request->file);

        return response()->json(['ok' => 'ok']);*/

        $result = ResultModel::paginate(1)->sortBy('percent');
        return response()->json($result);
    }
}
