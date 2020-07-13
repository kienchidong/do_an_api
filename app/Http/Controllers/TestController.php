<?php

namespace App\Http\Controllers;

use App\AdminModel;
use App\Exports\SimpleQuestionsExport;
use App\Http\Resources\Questions\GroupQuestionsCollection;
use App\Http\Resources\Questions\QuestionsCollection;
use App\Model\Question\QuestionGroupModel;
use App\Model\Question\QuestionModel;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TestController extends Controller
{
    //
    use ApiResponser;

    public $label =['A', 'B', 'C', 'D'];
    public function test(){
        //$list = QuestionModel::whereNull('group_id')->paginate(10);

        //return response()->json(new QuestionsCollection($list));
     /*   $group = QuestionGroupModel::paginate(10);
        return $this->successResponseMessage(new GroupQuestionsCollection($group), 200, 'get success');*/
     return Excel::download(new SimpleQuestionsExport(1), 'simpleQuestion.xlsx');
        /*$html = file_get_html('https://www.youtube.com/watch?v=2cblKNffVPg');

        $meta = $html->find('meta[property=og:title]', 0);

        dd($meta->content); */
       /* $url = "https://www.youtube.com/watch?v=2cblKNffVPg";
        $headers = file_get_contents($url);

        dd($headers->find('meta[property=og:title]',0));
        if(strpos($headers[0],'404') === false)
        {
            echo "URL Exists";
        }
        else
        {
            echo "URL Not Exists";
        }
        die();*/
        //echo $meta->content;

        $question = QuestionModel::whereNull('group_id')->get();
        $array = [];
        foreach ($question as $key =>$value){
            $array[$key]['question']= $value->question;
            foreach ($value->answers as $answerKey => $answer){
                $array[$key][$this->label[$answerKey]]= $answer->answer;
                if($answer->status){
                    $array[$key]['right']= $this->label[$answerKey];
                }
                $array[$key]['explain']= $answer->explain;
            }
        }

        return view('Excel.SimpleQuestion', compact('array'));
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file;

            $file->move('upload', $file->getClientOriginalName());
            return response()->json(['ok' => 'ok']);
        }
        return response()->json(['ok' => 'ok1']);
        return response()->json($request->all());
    }
}
