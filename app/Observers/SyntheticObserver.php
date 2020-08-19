<?php

namespace App\Observers;

use App\Model\Question\QuestionGroupModel;
use App\Model\SyntheticModel;

class SyntheticObserver
{
    /**
     * Handle the synthetic model "created" event.
     *
     * @param  \App\SyntheticModel  $syntheticModel
     * @return void
     */
    public function created(SyntheticModel $syntheticModel)
    {
        $reading = json_decode($syntheticModel->reading);
        $listening = json_decode($syntheticModel->listening);

        $question = array_merge($reading, $listening);
            $count = 0;
        foreach ($question as $id){
            $count += QuestionGroupModel::find($id)->questions->count();
        }
        $syntheticModel::find($syntheticModel->id)->update([
            'number_question' => $count,
            'time' => $count,
        ]);
    }

    /**
     * Handle the synthetic model "updated" event.
     *
     * @param  \App\SyntheticModel  $syntheticModel
     * @return void
     */
    public function updated(SyntheticModel $syntheticModel)
    {
        //
    }

    /**
     * Handle the synthetic model "deleted" event.
     *
     * @param  \App\SyntheticModel  $syntheticModel
     * @return void
     */
    public function deleted(SyntheticModel $syntheticModel)
    {
        //
    }

    /**
     * Handle the synthetic model "restored" event.
     *
     * @param  \App\SyntheticModel  $syntheticModel
     * @return void
     */
    public function restored(SyntheticModel $syntheticModel)
    {
        //
    }

    /**
     * Handle the synthetic model "force deleted" event.
     *
     * @param  \App\SyntheticModel  $syntheticModel
     * @return void
     */
    public function forceDeleted(SyntheticModel $syntheticModel)
    {
        //
    }
}
