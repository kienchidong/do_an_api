<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class LanguageController extends Controller
{
    public function changeLanguage($language)
    {
        \Session::put('lang', $language);
    }
}
