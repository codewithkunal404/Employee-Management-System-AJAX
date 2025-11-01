<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Employee Registration + List</title>
  <style>
    /* 🌈 Base Styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      background: linear-gradient(135deg, #e3f2fd, #e1bee7);
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
      padding: 1.5rem;
    }

    h2.form-title {
      text-align: center;
      color: #333;
      margin-bottom: 1.5rem;
      font-size: 1.5rem;
    }

    /* 🌟 Form Styling */
    form {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(8px);
      padding: 2rem;
      border-radius: 16px;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    form:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
    }

    label {
      font-weight: 600;
      display: block;
      margin-bottom: 0.3rem;
      color: #333;
    }

    input,
    select {
      width: 100%;
      padding: 0.8rem;
      margin-bottom: 0.8rem;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
      background: #fafafa;
      transition: all 0.3s ease;
    }

    input:focus,
    select:focus {
      outline: none;
      border-color: #7e57c2;
      background: #fff;
      box-shadow: 0 0 6px rgba(126, 87, 194, 0.3);
    }

    .error {
      display: block;
      color: #e53935;
      font-size: 0.85rem;
      margin-top: -0.4rem;
      margin-bottom: 0.8rem;
    }

    button {
      width: 100%;
      padding: 0.9rem;
      background: linear-gradient(135deg, #7e57c2, #4c8bf5);
      border: none;
      color: white;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
      transition: transform 0.2s ease, background 0.3s ease;
    }

    button:hover {
      background: linear-gradient(135deg, #5e35b1, #3672e4);
      transform: translateY(-2px);
    }

    #viewEmployeesBtn {
      margin-top: 1rem;
      max-width: 420px;
      background: #00bfa6;
    }

    #viewEmployeesBtn:hover {
      background: #009e8b;
    }

    /* 💫 Modal Styling */
    .modal {
      display: none;
      position: fixed;
      z-index: 10;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
      padding: 1rem;
    }

    .modal-content {
      background: #fff;
      border-radius: 12px;
      width: 95%;
      max-width: 1200px;
      max-height: 80vh;
      overflow-y: auto;
      padding: 1rem 1.5rem;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
      animation: fadeInUp 0.4s ease;
    }

    @keyframes fadeInUp {
      from {
        transform: translateY(40px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .close {
      float: right;
      font-size: 1.8rem;
      cursor: pointer;
      color: #888;
    }

    .close:hover {
      color: #e53935;
    }

    /* 📊 Table Styling */
    .table-container {
      overflow-x: auto;
      max-height: 60vh;
      border: 1px solid #ddd;
      border-radius: 8px;
      margin-top: 1rem;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.95rem;
      min-width: 700px;
    }

    thead th {
      position: sticky;
      top: 0;
      background: #f3f3f3;
      z-index: 5;
      font-weight: 600;
    }

    th, td {
      padding: 0.8rem;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }

    tr:hover {
      background: #f9f9ff;
    }

    .action-btn {
      border: none;
      background: none;
      cursor: pointer;
      font-size: 1.2rem;
      margin-right: 0.5rem;
    }

    .edit {
      color: #4caf50;
    }

    .delete {
      color: #e53935;
    }

    /* 📱 Responsive Design */
    @media (max-width: 768px) {
      form {
        padding: 1.2rem;
      }

      .modal-content {
        padding: 1rem;
        width: 100%;
        max-height: 85vh;
      }

      table {
        font-size: 0.85rem;
        min-width: 600px;
      }
    }

    @media (max-width: 480px) {
      h2.form-title {
        font-size: 1.3rem;
      }

      button, input, select {
        font-size: 0.9rem;
      }

      table {
        font-size: 0.8rem;
      }
    }
  </style>
</head>

<body>
  <form id="userForm" method="post">
    <h2 class="form-title">Employee Registration</h2>

    <label for="name">Name:</label>
    <input type="text" name="name" id="name">
    <span class="error" id="error_name"></span>

    <label for="dob">DOB:</label>
    <input type="date" name="dob" id="dob">
    <span class="error" id="error_dob"></span>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email">
    <span class="error" id="error_email"></span>

    <label for="department">Department:</label>
    <input type="text" name="department" id="department">
    <span class="error" id="error_department"></span>

    <label for="position">Position:</label>
    <select name="position" id="position">
      <option value="">Select Position</option>
      <option value="junior developer">Junior Developer</option>
      <option value="software developer">Software Developer</option>
      <option value="senior executive">Senior Executive</option>
      <option value="team leader">Team Leader</option>
      <option value="manager">Manager</option>
    </select>
    <span class="error" id="error_position"></span>

    <label for="salary">Salary:</label>
    <input type="number" name="salary" id="salary">
    <span class="error" id="error_salary"></span>

    <button type="submit">Submit</button>
  </form>

  <button id="viewEmployeesBtn">👀 View Employee List</button>

  <!-- Modal -->
  <div id="employeeModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h3>Employee List</h3>

      <div class="table-container">
        <table id="employeeTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Dept</th>
              <th>Position</th>
              <th>Salary</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="7" style="text-align:center;">No Employees Found</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="jquery-3.7.1.min.js"></script>
  <script>
    $(document).ready(function () {
      let url = window.location.origin + window.location.pathname;

      // FORM SUBMIT
      $("#userForm").submit(function (e) {
        e.preventDefault();
        $(".error").text("");
        let formData = $(this).serialize();

        $.ajax({
          url: url + "ajax/Create.php",
          type: "POST",
          data: formData,
          dataType: "json",
          success: function (response) {
            if (response.status === false) {
              if (typeof response.msg === "object") {
                $.each(response.msg, function (key, value) {
                  $("#error_" + key).text(value);
                });
              } else {
                alert(response.msg);
              }
            } else {
              alert(response.msg);
              $("#userForm")[0].reset();
              loadEmployees();
            }
          },
          error: function () {
            alert("Something went wrong. Please try again.");
          }
        });
      });

      // MODAL CONTROL
      const modal = $("#employeeModal");
      const closeModal = $(".close");

      $("#viewEmployeesBtn").click(function () {
        loadEmployees();
        modal.fadeIn();
      });

      closeModal.click(function () {
        modal.fadeOut();
      });

      $(window).click(function (e) {
        if ($(e.target).is(modal)) {
          modal.fadeOut();
        }
      });

      // LOAD EMPLOYEE DATA
      function loadEmployees() {
        $.ajax({
          url: url + "ajax/fetchEmployees.php",
          type: "GET",
          dataType: "json",
          success: function (data) {
            let rows = "";
            if (data.length > 0) {
              $.each(data, function (index, emp) {
                rows += `<tr>
                  <td>${emp.id}</td>
                  <td>${emp.name}</td>
                  <td>${emp.email}</td>
                  <td>${emp.department}</td>
                  <td>${emp.position}</td>
                  <td>${emp.salary}</td>
                  <td>
                    <button class="action-btn edit" data-id="${emp.id}">✏️</button>
                    <button class="action-btn delete" data-id="${emp.id}">🗑️</button>
                  </td>
                </tr>`;
              });
            } else {
              rows = `<tr><td colspan="7" style="text-align:center;">No Employees Found</td></tr>`;
            }
            $("#employeeTable tbody").html(rows);
          },
          error: function () {
            alert("Failed to load employee data.");
          }
        });
      }
    });
  </script>
</body>
</html>
