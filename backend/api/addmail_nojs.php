<?php

include '../vendor/autoload.php';
use App\Models\Email;
use App\Classes\MailValidator;

    $email = new Email();
    $validator = new MailValidator();

    if($validator->isEmpty($_POST['email'])) {
       header('Location: http://' . $_SERVER['HTTP_HOST'].'/noscript.php?message=empty');
       exit();
    } elseif ($_POST['email']) {
        if ($validator->existsMail($_POST['email'])) {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/noscript.php?message=exists');
            exit();
        } elseif (!$validator->isMail($_POST['email'])) {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/noscript.php?message=nomail');
            exit();
        } elseif ($validator->isColumbia($_POST['email'])) {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/noscript.php?message=columbia');
            exit();
        } elseif (!$_POST['checked']) {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/noscript.php?message=notchecked');
            exit();
        }

        if ($email->create($_POST['email'])) {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/thanks.php');
            exit();
        } else {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/noscript.php?message=servererror');
            exit();
        }

    }

