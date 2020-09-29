<?php
    // required headers
    header("Access-Control-Allow-Origin: http://localhost/Signup-form/");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    include("../Database/db.php");
    include("../Model/user.php");
    include("getToken.php");

    
    $db = new database_helper();
    $user = new user();
    // submitted data will be here
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    // set product property values
    $user->name = $data->name;
    $user->email = $data->email;
    $user->password =  password_hash($data->password, PASSWORD_DEFAULT); 
    $user->phone = $data->phone;
    $user->activationcode = md5($user->email.time());
    $user->verified = 0;

    // use the create() method here
if(
    !empty($user->name) &&
    !empty($user->email) &&
    !empty($user->password) &&
    !empty($user->phone) &&
    //$username, $myemail, $mypassword, $myphone, $activationcode, $verified
    $db->insert($user->name, $user->email, $user->password, $user->phone, $user->activationcode, $user->verified)
){
 
    // set response code
    http_response_code(200);
    $token = getToken($user);
    // display message: user was created
    echo json_encode(array("message" => "User was created.",
    "token" => $token));
}
else{
 
    // set response code
    http_response_code(400);
 
    // display message: unable to create user
    echo json_encode(array("message" => "Unable to create user."));
}
?>