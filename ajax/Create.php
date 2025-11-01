<?php
header('Content-Type: application/json');

require_once '../controller/EmployeeManager.php';
require_once '../controller/EmployeeModel.php';
require_once '../controller/Database.php';


use App\DB\Database;
use App\Services\EmployeeManager;
use App\Schema\EmployeeModel;

$db=(new Database())->getConn();
$candidate=new EmployeeManager($db);

$id=$_POST['id']??0;
$name=$_POST['name']??null;
$dob=$_POST['dob']??null;
$email=$_POST['email']??null;
$department=$_POST['department']??null;
$position=$_POST['position']??null;
$salary=$_POST['salary']??null;


$errors = [];
/* ----------------------------
   ✅ NAME VALIDATION
----------------------------- */
if (empty($name)) {
    $errors['name'] = "Name is required";
} 
elseif (strlen($name) > 20) {
    $errors['name'] = "Name length must be less than 20 characters";
} 
elseif (is_numeric($name)) {
    $errors['name'] = "Name cannot be only numbers";
} 
elseif (!preg_match("/^[a-zA-Z ]*$/", $name)) {
    $errors['name'] = "Name must contain only letters and spaces";
}

/* ----------------------------
   ✅ DOB VALIDATION
----------------------------- */
if (empty($dob)) {
    $errors['dob'] = "Date of Birth is required";
} 
else {
    $dobTimestamp = strtotime($dob);

    if ($dobTimestamp === false) {
        $errors['dob'] = "Invalid date format";
    } 
    elseif ($dobTimestamp > time()) {
        $errors['dob'] = "Date of Birth cannot be in the future";
    }
}

/* ----------------------------
   ✅ EMAIL VALIDATION
----------------------------- */
if (empty($email)) {
    $errors['email'] = "Email is required";
} 
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Invalid email format";
}
elseif (strlen($email) > 50) {
    $errors['email'] = "Email should be less than 50 characters";
}

/* ----------------------------
   ✅ DEPARTMENT VALIDATION (Text Input)
----------------------------- */
if (empty($department)) {
    $errors['department'] = "Department is required";
} 
elseif (!preg_match("/^[a-zA-Z ]*$/", $department)) {
    $errors['department'] = "Department must contain only letters and spaces";
} 
elseif (strlen($department) > 30) {
    $errors['department'] = "Department name must be less than 30 characters";
}

/* ----------------------------
   ✅ POSITION VALIDATION (Select Input)
----------------------------- */

$validDepartments = ['junior developer', 'software developer', 'senior executive', 'team leader' , 'manager'];

if (empty($position)) {
    $errors['position'] = "Please select a position";
} 
elseif (!in_array($position, $validDepartments)) {
    $errors['position'] = "Invalid position selected";
}

/* ----------------------------
   ✅ SALARY VALIDATION
----------------------------- */
if (empty($salary)) {
    $errors['salary'] = "Salary is required";
} 
elseif (!is_numeric($salary)) {
    $errors['salary'] = "Salary must be a numeric value";
} 
elseif ($salary < 5000) {
    $errors['salary'] = "Salary must be at least ₹5,000";
} 
elseif ($salary > 1000000) {
    $errors['salary'] = "Salary must not exceed ₹10,00,000";
}

$model=new EmployeeModel($id,$name,$dob,$email,$department,$position,$salary);


if($errors){
    echo json_encode(['status'=>false,'msg'=>$errors]);
    exit;
}
else{
    $add=$candidate->saveEmployee($model);
    echo json_encode($add);

}


?>