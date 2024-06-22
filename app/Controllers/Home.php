<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {

        if (isset(session()->userId)) {
            return $this->docs();
        }
        return view('login');
    }

    public function docs(): string
    {
        return view('docs');
    }
}
