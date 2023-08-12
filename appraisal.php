<?php include'db_connect.php' ?>
<?php
ob_start();
$my_class = 'block';
include('decisionTreeMain.php');
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['SubmitButton'])){
        $employee = $_POST['employee'];
        $date_from = $_POST['startDatePicker'];
        $date_to = $_POST['endDatePicker'];
        
        $efficiency = 0;
        $quality = 0;
        $timeliness = 0;
        $accuracy = 0;
        
        $query = $conn->query("SELECT * FROM ratings WHERE employee_id = '$employee' AND date_created >= '$date_from' AND date_created <= '$date_to'");
        while ($row = $query->fetch_assoc()) {
            $efficiency += $row['efficiency'];
            $quality += $row['quality'];
            $timeliness += $row['timeliness'];
            $accuracy += $row['accuracy'];
        }
        $total_tasks = $query->num_rows;
        if($total_tasks > 0){
            $ind_total = 5*$total_tasks;

            $converted_efficiency = ($efficiency/$ind_total)*5;
            $converted_quality = ($quality/$ind_total)*5;
            $converted_timeliness = ($timeliness/$ind_total)*5;
            $converted_accuracy = ($accuracy/$ind_total)*5;
            include('decisionTree.php');
    
            echo $prediction;

            
            $my_class = 'none';

            $sql = "INSERT INTO appraisal (employee_id, date_from, date_to, prediction)
            VALUES ('$employee', '$date_from', '$date_to', '$prediction')";

            // Execute the query
            if ($conn->query($sql) === TRUE) {
                // Redirect after successful insertion
                header("Location: ./index.php?page=appraisal_list");
                ob_end_flush();
                exit();
            } else {
                echo "Error: " . $conn->error;
            }

            // Close the connection
            $conn->close();
                }
        
    }
}
?>

<div class="col-lg-12">
	<div class="card card-outline card-success" style='display:<?php echo $my_class; ?>'>
		<div class="card-header">
			<?php if($_SESSION['login_type'] == 2): ?>
			<div class="card-tools">
				<button class="btn btn-block btn-sm btn-default btn-flat border-primary" id="new_task"><i class="fa fa-plus"></i> Add New Task</button>
			</div>
			<?php endif; ?>
		</div>
		<div class="card-body">
        <form id="appraisalForm" action="" method="POST">
            
            <div class="row inline col-md-12" style="display:inline-flex;">
                <div class="form-group col-md-5">
                    <select id="employeeDropdown" name="employee"  class="form-control">
                        <option value="">Select Employee</option>
                        <?php
                            $query = $conn->query('SELECT * FROM employee_list');
                            while ($row = $query->fetch_assoc()) {
                                echo '<option value="' . $row['id'] . '">' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'] . '</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <input type="date" id="startDatePicker" name="startDatePicker" class="form-control" placeholder="Start Date">
                </div>
                <div class="form-group col-md-3">
                    <input type="date" id="endDatePicker" name="endDatePicker" class="form-control" placeholder="End Date">
                </div>

                <div class="form-group col-md-12" style="text-align-last:right;">
                    <input type="submit" name="SubmitButton" value="Proceed for Appraisal...">
                </div>
            </div>
            <?php echo $message; ?>
        </form>
	</div>
</div>
<style>
	table p{
		margin: unset !important;
	}
	table td{
		vertical-align: middle !important
	}
</style>

