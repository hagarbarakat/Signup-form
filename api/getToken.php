<?php
    // required headers
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    // files for jwt will be here
    // generate json web token
    include_once 'config/core.php';
    include_once 'libs/php-jwt-master/src/BeforeValidException.php';
    include_once 'libs/php-jwt-master/src/ExpiredException.php';
    include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
    include_once 'libs/php-jwt-master/src/JWT.php';
    use \Firebase\JWT\JWT;

    function getToken($user){
        global $iss, $aud, $iat, $nbf, $key;
        $token = array(
            "iss" => $iss,
            "aud" => $aud,
            "iat" => $iat,
            "nbf" => $nbf,
            "data" => array(
                "name" => $user->name,
                "phone" => $user->phone,
                "email" => $user->email,
            ),
        );
        // set response code
        http_response_code(200);
    
        // generate jwt
        $jwt = JWT::encode($token, $key);
        return $jwt;
    }
?>