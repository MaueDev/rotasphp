<?php

function controller($matchedUri, $params)
{
    [$controller, $method] = explode('@', array_values($matchedUri)[0]);
    $ControllerWithNameSpace = CONTROLLER_PATH.$controller;
    
    if(!class_exists($ControllerWithNameSpace))
    {
        throw new Exception("Controller {$controller} não existe");
    }

    $controllerInstance = new $ControllerWithNameSpace;

    if(!method_exists($controllerInstance, $method))
    {
        throw new Exception("O método {$method} não existe no controller {$controller}");
    }

    $controllerInstance->$method($params);
}