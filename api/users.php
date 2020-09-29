<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/Signup-form/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include "../Database/db.php";
include "../Model/user.php";
include "../Validation/validation.php";
include_once 'config/core.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

/**
 * Get header Authorization
 * */
function getAuthorizationHeader()
{
    $headers = null;
    if (isset($_SERVER['Authorization'])) {
        $headers = trim($_SERVER["Authorization"]);
    } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } elseif (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
        $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
        if (isset($requestHeaders['Authorization'])) {
            $headers = trim($requestHeaders['Authorization']);
        }
    }
    return $headers;
}
/**
 * get access token from header
 * */
function getBearerToken()
{
    $headers = getAuthorizationHeader();
// HEADER: Get the access token from the header
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
    }
    return null;
}

function validateJWT($dataJWT, $key)
{
    // get jwt
    $jwt = isset($dataJWT) ? $dataJWT : "";

    if ($jwt) {

        // if decode succeed, show user details
        try {
            // decode jwt
            $decoded = JWT::decode($jwt, $key, array('HS256'));

            // set response code
            http_response_code(200);
            return true;
        }

        // catch will be here
        // if decode fails, it means jwt is invalid
         catch (Exception $e) {

            // set response code
            http_response_code(401);

            // tell the user access denied  & show error message
            echo json_encode(array(
                "message" => "Access denied.",
                "error" => $e->getMessage(),
            ));
            return false;
        }
    }

    // error if jwt is empty will be here
    // show error message if jwt is empty
    else {

        // set response code
        http_response_code(401);

        // tell the user access denied
        echo json_encode(array("message" => "Access denied."));
        return false;
    }
}

$token = getBearerToken();
$result = validateJWT($token, $key);
if (!empty($result)) {
    $db = new database_helper();
    $sql = $db->getUsers();
    $arr = array();
    while ($row = mysqli_fetch_assoc($sql)) {
        array_push($arr, $row['username']);
    }
    echo json_encode(
        array(
            "users" => $arr,
        )
    );
}
