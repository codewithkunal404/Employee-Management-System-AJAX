<?php

namespace App\Schema;

class EmployeeModel {
    private $id;
    public $name;
    public $dob;
    public $email;
    public $department;
    public $position;
    private $salary;

    public function __construct($id = '', $name = '', $dob = '', $email = '', $department = '', $position = '', $salary = '') {
        $this->id = $id;
        $this->name = $name;
        $this->dob = $dob;
        $this->email = $email;
        $this->department = $department;
        $this->position = $position;
        $this->salary = $salary;
    }

      public function getId() { return $this->id; }
    public function getSalary() { return $this->salary; }
}
