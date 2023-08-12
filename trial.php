<?php include 'db_connect.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <!-- Include your CSS and other head elements here -->
    <link rel="stylesheet" href="your_styles.css">
</head>
<body>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="dropdown">
        <!-- ...Existing code... -->
    </div>
    <div class="sidebar pb-4 mb-4">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- ...Other sidebar items... -->

                <!-- Appraisal Section -->
                <li class="nav-item">
                    <a href="#" class="nav-link nav-appraisal" id="appraisalToggle">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            Appraisal
                            <i class="right fas fa-angle-down"></i>
                        </p>
                    </a>
                    <div id="appraisalForm" style="display: none;">
                        <div class="dropdown-item">
                            <select id="employeeDropdown" class="form-control">
                                <option value="">Select Employee</option>
                                <?php
                                // Retrieve employee names from the employee_list table
                                $query = "SELECT id, firstname, middlename, lastname FROM employee_list";
                                $result = mysqli_query($connection, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . $row['id'] . '">' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="dropdown-item">
                            <input type="date" id="startDatePicker" class="form-control" placeholder="Start Date">
                        </div>
                        <div class="dropdown-item">
                            <input type="date" id="endDatePicker" class="form-control" placeholder="End Date">
                        </div>
                        <!-- Additional content for the Appraisal section -->
                        <!-- ... -->
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Add JavaScript/jQuery for toggling the form -->
<script>
    $(document).ready(function () {
        $('#appraisalToggle').click(function () {
            $('#appraisalForm').toggle();
        });

        // ...Existing code...

        // Handle dropdown and date pickers
        $('#employeeDropdown').change(function () {
            var selectedEmployee = $(this).val();
            // Do something with the selected employee
            console.log('Selected Employee ID: ' + selectedEmployee);
        });

        $('#startDatePicker, #endDatePicker').change(function () {
            var startDate = $('#startDatePicker').val();
            var endDate = $('#endDatePicker').val();
            // Do something with the selected date range
            console.log('Start Date: ' + startDate);
            console.log('End Date: ' + endDate);
        });
    });
</script>

</body>
</html>
