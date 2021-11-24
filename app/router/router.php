<?php

function routes()
{
    require 'routes.php';
    return $routesarray;
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
            $uri,
            explode('/', ltrim($matchedToGetParams , '/'))
        );           
    }
    return [];
}

function formatParams($uri, $params)
{
    
    $paramsData = [];
    foreach($params as $index => $param)
    {
        $paramsData[$uri[$index - 1]] = $param;
    }

    return $paramsData;
}

function router()
{
    $url = str_replace('/Combustivel.online/public', '',$_SERVER['REQUEST_URI']);
    $uri = parse_url($url, PHP_URL_PATH);
    $routes = routes();

    //Verificar se Existe a Rota
    $matchedUri = exactMatchUriInArrayRoutes($uri, $routes);

    $params = [];
    if(empty($matchedUri))
    {
        $matchedUri = regularExpressionMatchArrayRoutes($uri, $routes);
        $uri = explode('/',ltrim($uri,'/'));
        $params = params($uri, $matchedUri);
        $params = formatParams($uri,$params);
        controller($matchedUri, $params);
        //var_dump($params);
        die();
    }

    if(!empty($matchedUri))
    {
        return controller($matchedUri, $params);
        
    }

    throw new Exception("Algo deu Errado");
}