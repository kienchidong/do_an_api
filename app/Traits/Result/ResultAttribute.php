<?php

namespace App\Traits\Result;

trait ResultAttribute
{
    public function getPointNumberAttribute()
    {
        $point = explode('(',$this->point);
        return $point[0];
    }
    public function getPercentAttribute()
    {
        $percent = trim(strstr($this->point, '('), '(');
        $percent = rtrim($percent, '%)');
        return $percent;
    }
}
