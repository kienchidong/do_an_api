<?php

namespace App\Http\Controllers\Feedback;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeedBack\FeedbackCollection;
use App\Model\FeedbackModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    //
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'bail|required',
        ]);

        $request->request->set('user_id', Auth::id());

        FeedbackModel::create($request->only('user_id', 'content'));
        return response()->json($request->all());
    }

    public function getList(Request $request)
    {
        $size = $request->get('size', 10);
        $feedback = FeedbackModel::orderBy('created_at')->paginate($size);

        return response()->json(new FeedbackCollection($feedback));
    }
}
