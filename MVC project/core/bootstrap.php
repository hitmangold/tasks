<?php
session_start();
require_once 'configs/database.php';
require_once 'configs/db_queries.php';
require_once 'model.php';
require_once 'view.php';
require_once 'controller.php';
require_once 'route.php';
Route::start();