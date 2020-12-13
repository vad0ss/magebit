<?php

   header('Access-Control-Allow-Origin: *');
   header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
   header('Access-Control-Allow-Credentials: true');
   header('Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Accept, X-PINGOTHER, Content-Type');
   header('Content-Type: application/json');

   include '../vendor/autoload.php';
   use App\Models\Email;
   use App\Classes\MailValidator;

   $request = json_decode(file_get_contents('php://input'));

   if (isset($request->email)) {

       $email = new Email();
       $validator = new MailValidator();

       if($validator->isEmpty($request->email)) {
           $result = json_encode(array("message" => "Please enter your email address."));
           echo $result;
           exit();
       } elseif($validator->existsMail($request->email)) {
           $result = json_encode(array("message" => "This address is already registered."));
           echo $result;
           exit();
       } elseif (!$validator->isMail($request->email)){
           $result = json_encode(array("message" => "Please provide a valid e-mail address."));
           echo $result;
           exit();
       } elseif($validator->isColumbia($request->email)){
           $result = json_encode(array("message" => "We are not accepting subscriptions from Columbia."));
           echo $result;
           exit();
       } elseif(!$request->checked) {
           $result = json_encode(array("message" => "You must accept the terms and conditions."));
           echo $result;
           exit();
       }

       if($email->create($request)) {
           http_response_code(201);
           $result = json_encode(array("message" => "Email is added.", "mail" => $request->email));
       } else {
           http_response_code(503);
           $result = json_encode(array("message" => "Server error."));
       }

   } else {
       $result = json_encode(array("message" => "Post error."));
   }

   echo $result;

