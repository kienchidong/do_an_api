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
     /*return Excel::download(new SimpleQuestionsExport(), 'simpleQuestion.xlsx');*/
        /*$html = file_get_contents('https://www.youtube.com/watch?v=EvK4xyQNVR0');
        dd($html);
        $meta = $html->find('meta[property=og:image]', 0);*/

       /* $url = "https://kienchidong.github.io/kien/";
        $headers = file_get_contents($url);

        echo $headers;*/
        /*if(strpos($headers[0],'404') === false)
        {
            echo "URL Exists";
        }
        else
        {
            echo "URL Not Exists";
        }*/
        //echo $meta->content;

        $group = QuestionGroupModel::paginate(10);

        return view('Excel.GroupQuestions', compact('group'));
    }
}
