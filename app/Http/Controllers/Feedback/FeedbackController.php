<?php

namespace App\Http\Controllers\Feedback;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeedBack\FeedbackCollection;
use App\Model\FeedbackModel;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    //
    use ApiResponser;
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'bail|required',
        ]);

        $user_id = (Auth::id())? Auth::id() : 0;
        $request->request->set('user_id', $user_id);

        FeedbackModel::create($request->only('user_id', 'content', 'name'));
        return $this->successResponseMessage([], 200, 'create feedback success');
    }

    public function getList(Request $request)
    {
        $size = $request->get('size', 10);
        $feedback = FeedbackModel::orderBy('created_at')->paginate($size);

        return response()->json(new FeedbackCollection($feedback));
    }
}
