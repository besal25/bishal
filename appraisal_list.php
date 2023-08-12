<?php include 'db_connect.php'; ?>

<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <?php if ($_SESSION['login_type'] == 2): ?>
                <div class="card-tools">
                    <button class="btn btn-block btn-sm btn-default btn-flat border-primary" id="new_task"><i class="fa fa-plus"></i> <a href="./index.php?page=appraisal">Add New Task</a></button>
                </div>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <table class="table tabe-hover table-condensed" id="list">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th width="30%">Employee</th>
                        <th>Date From/To</th>
                        <th>Status</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $sql = "SELECT *
                    FROM appraisal a
                    JOIN employee_list e ON a.employee_id = e.id";


                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if($row["prediction"] == 'Excellent'){
                                $increment =  'Increment by 10%';
                            }
                            elseif($row["prediction"] == 'Good'){
                                $increment =  'Increment by 5%';
                            }
                            else{
                                $increment = 'No change';
                            }
                            echo "<tr>";
                            echo "<td>" . $i . "</td>";
                            echo "<td>" . $row["firstname"] ." ". $row['middlename'] ." ". $row['lastname'] ."</td>";
                            echo "<td>" . $row["date_from"] . " / " . $row["date_to"] . "</td>";
                            echo "<td>" . $row["prediction"] . "</td>";

                            echo "<td>". $increment ."</td>";
                            echo "</tr>";
                            $i++;
                        }
                    } else {
                        echo "<tr><td colspan='4'>No data available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
    table p {
        margin: unset !important;
    }

    table td {
        vertical-align: middle !important
    }
</style>
