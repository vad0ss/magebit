<?php
/**
 * Author: Vadims Prilepisevs
 * Date: 13.12.2020
 * Time: 20:55
 */

if(isset($_POST['gmailfilter'])) {
    return header('Location: http://' . $_SERVER['HTTP_HOST'].'/backend/index.php?filter='.$_POST['gmailfilter']);
}

if(isset($_POST['yahoofilter'])) {
    return header('Location: http://' . $_SERVER['HTTP_HOST'].'/backend/index.php?filter='.$_POST['yahoofilter']);
}

if(isset($_POST['outlookfilter'])) {
    return header('Location: http://' . $_SERVER['HTTP_HOST'].'/backend/index.php?filter='.$_POST['outlookfilter']);
}

if(isset($_POST['wpfilter'])) {
    return header('Location: http://' . $_SERVER['HTTP_HOST'].'/backend/index.php?wpfilter='.$_POST['wpfilter']);
}

if(isset($_POST['search'])) {
    return header('Location: http://' . $_SERVER['HTTP_HOST'].'/backend/index.php?search='.$_POST['search']);
}

if(isset($_POST['sortbydateorname'])) {
    return header('Location: http://' . $_SERVER['HTTP_HOST'].'/backend/index.php?sort='.$_POST['sortbydateorname']);
}