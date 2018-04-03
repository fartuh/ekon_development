<?php

use Controllers\Controller;

class HomeController extends Controller
{

    public function index($args)
    {
        $this->view("index", ['var' => 'hello world']);
    }
}
