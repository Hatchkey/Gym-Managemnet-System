<?php
include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$response = array('success' => false, 'message' => '');
//get the workout list from the database
$workout_list_query = "SELECT * FROM workout_lists";
$workout_list_result = $conn->query($workout_list_query);

//get all the members from the database
$members_query = "SELECT * FROM members";
$members_result = $conn->query($members_query);
//Old codes
//TODO: remove if done
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $fullname = $_POST['workout_name'];
//     $equipment_type = $_POST['equipment_type'];
//     $target_muscle = $_POST['target_muscle'];
//     $sets = $_POST['sets'];
//     $reps = $_POST['reps'];
//     $duration_time = $_POST['duration_time'];


//     // $membershipNumber = 'CA-' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);

//     $insertQuery = "INSERT INTO workout_list (workout_name,  equipment_type, target_muscle_group,sets,reps,duration_time) 
//                     VALUES ( '$fullname', '$equipment_type', '$target_muscle', '$sets', '$reps', '$duration_time')";

//     if ($conn->query($insertQuery) === TRUE) {
//         $response['success'] = true;
//         $response['message'] = 'Workout list added successfully! 
//          ';
//     } else {
//         $response['success'] = false;
//         $response['message'] = 'Error: ' . $conn->error;
//     }
// }
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $workout_id = $_POST['workout_id']; //so is this correct?`x
    $assign_to = $_POST['assign_to'];
    $sets = $_POST['sets'];
    $reps = $_POST['reps'];
    $day = $_POST['day'];
    $workout_split = $_POST['workout_split'];
    $insertQuery = "INSERT INTO workout_program (workout_id, member_id, sets, reps, day, workout_split)
     VALUES ( '$workout_id', '$assign_to', '$sets', '$reps', '$day', '$workout_split' )";
    if ($conn->query($insertQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = 'Workout out added successfully! 
         ';
    } else {
        $response['success'] = false;
        $response['message'] = 'Error: ' . $conn->error;
    }
}
?>



<?php include('includes/header.php'); ?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <?php include('includes/nav.php'); ?>

        <?php include('includes/sidebar.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <?php include('includes/pagetitle.php'); ?>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Info boxes -->
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">

                            <?php if ($response['success']): ?>
                                <div class="alert alert-success alert-dismissible" id="success-message">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h5><i class="icon fas fa-check"></i> Success</h5>
                                    <?php echo $response['message']; ?>
                                </div>
                            <?php elseif (!empty($response['message'])): ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h5><i class="icon fas fa-ban"></i> Error</h5>
                                    <?php echo $response['message']; ?>
                                </div>
                            <?php endif; ?>

                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-keyboard"></i> Assign Workout Program Form</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="workout_name">Workout Name</label>

                                                <select name="workout_id" id="workout_id" class="form-control" required>
                                                    <option value="">Select Workout</option>
                                                    <?php
                                                    if ($workout_list_result->num_rows > 0) {
                                                        // Loop through the results and create an <option> for each row
                                                        while ($row = $workout_list_result->fetch_assoc()) {
                                                            echo '<option value="' . htmlspecialchars($row['workout_id']) . '">' . htmlspecialchars($row['workout_name']) . '</option>';
                                                        }
                                                    } else {
                                                        echo '<option value="">No Workouts Available</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="reps">Reps</label>
                                                <input type="string" class="form-control" id="reps" name="reps"
                                                    placeholder="Enter reps" required>
                                            </div>
                                        </div>
                                        <div class="row mt-3">

                                            <div class="col-sm-6">
                                                <label for="day">Day</label>
                                                <input type="number" class="form-control" id="day" name="day"
                                                    placeholder="Enter day" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="sets">Sets</label>
                                                <input type="number" class="form-control" id="sets" name="sets"
                                                    placeholder="Enter sets" required>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-6">
                                                <label for="assign_to">Assign To</label>
                                                <!-- <input type="text" class="form-control" id="workout_name" name="workout_name"
                                                    placeholder="Enter workout name" required> -->
                                                <select name="assign_to" id="assign_to" class="form-control" required>
                                                    <option value="">Assign to member</option>
                                                    <?php
                                                    if ($members_result->num_rows > 0) {
                                                        // Loop through the results and create an <option> for each row
                                                        while ($row = $members_result->fetch_assoc()) {
                                                            echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['fullname']) . '</option>';
                                                        }
                                                    } else {
                                                        echo '<option value="">No Workouts Available</option>';
                                                    }
                                                    ?>

                                                </select>
                                            </div>

                                            <div class="col-sm-6">
                                                <label for="workout_split">Workout Split</label>

                                                <select name="workout_split" id="workout_split" class="form-control" required>
                                                    <option value="">Select Workout Split</option>
                                                    <option value="Push">Push</option>
                                                    <option value="Upper">Upper</option>
                                                    <option value="Full Body">Full Body</option>
                                                    <option value="Chest">Chest</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                    <!-- /.card-body -->


                                </form>
                            </div>

                        </div>
                        <!-- /.card -->

                    </div>
                    <!--/.col (left) -->

                </div>
                <!-- /.row -->

        </div><!--/. container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <strong> &copy; <?php echo date('Y'); ?>Camalig Fitness Gym</a> </strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Developed By</b> <a href="https://www.facebook.com/camaligfitnessgym">CFG</a>
        </div>
    </footer>
    </div>
    <!-- ./wrapper -->

    <?php include('includes/footer.php'); ?>
</body>
<script type="text/javascript">
    // Check if the success message is present
    window.onload = function() {
        var successMessage = document.getElementById("success-message");

        if (successMessage) {
            // Hide the success message after 2000 milliseconds (2 seconds)
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 1500);
        }
    }
</script>

</html>