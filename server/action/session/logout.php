<?php
/**
 * Created by PhpStorm.
 * User: PIX
 * Date: 25/04/2016
 * Time: 04:26 PM
 */
require_once('../../autoloader.php');

$session = new Session();
$session->logout();
respondWithSuccess();