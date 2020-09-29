<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../Database/db.php";
include "../Model/user.php";
include "getToken.php";
// files for jwt will be here
// generate json web token
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

$db = new database_helper();
$user = new user();
// submitted data will be here
// get posted data
$data = json_decode(file_get_contents("php://input"));
// set product property values
$user->email = $data->email;
$email_exists = $db->getUserbyEmail($data->email);
if (empty($email_exists)) {
    echo "Check your email";
    return;
}
$row = mysqli_fetch_array($email_exists, MYSQLI_ASSOC);
$user->password = $row["password"];
$user->phone = $row["phone"];
$user->email = $row["email"];
$user->name = $row["username"];
if(empty(password_verify($data->password, $user->password))){
    echo "no";
}
// generate jwt will be here// check if email exists and if password is correct
if (!empty($email_exists) && password_verify($data->password, $user->password)) {
    $token = getToken($user);
    echo json_encode(
        array(
            "message" => "Successful login.",
            "token" => $token
        )
    );
}
// login failed will be here
// login failed
else {

    // set response code
    http_response_code(401);

    // tell the user login failed
    echo json_encode(array("message" => "Login failed."));
}
