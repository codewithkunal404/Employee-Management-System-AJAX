<?php
namespace App\Services;
require_once 'EmployeeModel.php';
use App\Schema\EmployeeModel;
use Exception;
class EmployeeManager
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
   public function saveEmployee(EmployeeModel $model)
{
    try {
        // ✅ Ensure DB connection is defined
        $conn = $this->db;

        // ✅ Sanitize and cast input data
        $id = intval($model->getId());
        $name = trim($model->name);
        $email = trim($model->email);
        $dob = trim($model->dob);
        $department = trim($model->department);
        $position = trim($model->position);
        $salary = floatval($model->getSalary());

        // ✅ Check if email already exists (prepared statement)
        $checkSql = "SELECT id FROM employees WHERE email = ? AND id != ? LIMIT 1";
        $stmtCheck = $conn->prepare($checkSql);
        $stmtCheck->bind_param("si", $email, $id);
        $stmtCheck->execute();
        $checkRes = $stmtCheck->get_result();

        if ($checkRes && $checkRes->num_rows > 0) {
            return [
                'status' => false,
                'msg' => 'Email already exists'
            ];
        }

        // ✅ UPDATE or INSERT logic
        if ($id > 0) {
            // 🔁 Update existing employee
            $sql = "UPDATE employees 
                    SET name=?, email=?, dob=?, department=?, position=?, salary=? 
                    WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $name, $email, $dob, $department, $position, $salary, $id);

            if ($stmt->execute()) {
                return [
                    'status' => true,
                    'msg' => 'Data updated successfully'
                ];
            } else {
                throw new Exception("Failed to update data: " . $stmt->error);
            }
        } else {
            // ➕ Insert new employee
            $sql = "INSERT INTO employees (name, email, dob, department, position, salary)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssd", $name, $email, $dob, $department, $position, $salary);

            if ($stmt->execute()) {
                return [
                    'status' => true,
                    'msg' => 'Data inserted successfully',
                    'insert_id' => $stmt->insert_id
                ];
            } else {
                throw new Exception("Failed to insert data: " . $stmt->error);
            }
        }
    } catch (Exception $e) {
        // 🧠 Catch runtime or SQL errors safely
        return [
            'status' => false,
            'msg' => 'Error: ' . $e->getMessage()
        ];
    }
}


  public function getAll()
    {
        $query = "SELECT * from employees ORDER BY id DESC";
        $result = mysqli_query($this->db, $query);

        if (! $result) {
            return array();
        }

        $employees = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $employees[] = $row;
        }

        return $employees;
    }


}


?>