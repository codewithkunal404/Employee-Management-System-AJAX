<?php
header('Content-Type: application/json');
require_once '../controller/EmployeeManager.php';
require_once '../controller/Database.php';

use App\DB\Database;
use App\Services\EmployeeManager;
$db=(new Database())->getConn();
$candidate=new EmployeeManager($db);
echo json_encode($candidate->getAll());


?>