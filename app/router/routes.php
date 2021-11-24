
<?php
$routesarray = [
    '/' => 'home@index',
    '/user/create' => 'user@create',
    '/user/[0-9]+' => "user@show"/*,
    '/user/[0-9]+/name/[a-z]+' => "User@show",*/
    
];
