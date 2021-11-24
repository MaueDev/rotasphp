<?php 
namespace app\controllers;

class home
{
    public function index($params)
    {
        return [
            "view" => 'home.views.php',
            "data" => ['name' => '...']
        ];
    }
}