<?php

function routes()
{
    return [
        '/' => 'Home@index',
        '/user/create' => 'User@create',
        '/user/[0-9]+' => "User@index",
        '/user/[0-9]+/name/[a-z]+' => "User@show",
        
    ];
}

function exactMatchUriInArrayRoutes($uri, $routes)
{
    if(array_key_exists($uri, $routes))
    {
        return [$uri => $routes[$uri]];
    }
    return [];
}

function regularExpressionMatchArrayRoutes($uri, $routes)
{
    return array_filter(
        $routes,
        function ($value) use ($uri)
        {
            $regex = str_replace('/', '\/', ltrim($value, '/' ));
            return preg_match("/^$regex$/", ltrim($uri, '/'));
        },ARRAY_FILTER_USE_KEY
    );
}

function params($uri,$matchedUri)
{
    if(!empty($matchedUri))
    {
        $matchedToGetParams = array_keys($matchedUri)[0];
        return array_diff(
            explode('/', ltrim($uri , '/')),
            explode('/', ltrim($matchedToGetParams , '/'))
        );           
    }
    return [];
}

function router()
{
    $url = str_replace('/Combustivel.online/public', '',$_SERVER['REQUEST_URI']);
    $uri = parse_url($url, PHP_URL_PATH);
    $routes = routes();

    //Verificar se Existe a Rota
    $matchedUri = exactMatchUriInArrayRoutes($uri, $routes);

    if(empty($matchedUri))
    {
        $matchedUri = regularExpressionMatchArrayRoutes($uri, $routes);
        $params = params($uri, $matchedUri);
        var_dump($params);
        die();
    }

    var_dump($matchedUri);
    die();
}