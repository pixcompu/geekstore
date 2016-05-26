<?php
/**
 * Created by PhpStorm.
 * User: PIX
 * Date: 25/04/2016
 * Time: 04:26 PM
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/geekstore/server/autoloader.php');

$session = new Session();
$session->logout();
respondWithSuccess();