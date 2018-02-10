<?php
require_once __DIR__ . '/vendor/autoload.php';

//router must be implemented here to impement properly through controllers


$index = new \PropertyFinder\controllers\indexController();
$index->index();
?>
