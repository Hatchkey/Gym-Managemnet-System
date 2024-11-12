<?php
include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$response = array('success' => false, 'message' => '');


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
    $workout_name = $_POST['workout_name'];
    $description = $_POST['description'];
    $target_muscle_group = $_POST['target_muscle_group'];

    // $membershipNumber = 'CA-' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);

    $insertQuery = "INSERT INTO workout_lists (workout_name, description, target_muscle_group) 
                    VALUES ( '$workout_name', '$description', '$target_muscle_group' )";


    if ($conn->query($insertQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = 'Workout list added successfully! 
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
                                    <h3 class="card-title"><i class="fas fa-keyboard"></i> Add Workout List Form</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <!-- <div class="row">
                                            <div class="col-sm-6">
                                                <label for="workout_name">Workout Name</label>
                                                <input type="text" class="form-control" id="workout_name" name="workout_name"
                                                    placeholder="Enter workout name" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="equipment_type">Equipment Type</label>
                                                <input type="text" class="form-control" id="equipment_type" name="equipment_type"
                                                    placeholder="Enter equipment type" required>
                                            </div>

                                        </div>


                                        <div class="row mt-3">
                                            <div class="col-sm-6">
                                                <label for="target_muscle">Target Muscle Group</label>
                                                <input type="text" class="form-control" id="target_muscle"
                                                    name="target_muscle" placeholder="Enter target muscle group" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="sets">Set</label>
                                                <input type="number" class="form-control" id="sets" name="sets"
                                                    placeholder="Enter sets" required>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-sm-6">
                                                <label for="reps">Reps</label>
                                                <input type="string" class="form-control" id="reps" name="reps"
                                                    placeholder="Enter reps" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="duration_time">Duration Time</label>
                                                <input type="number" class="form-control" id="duration_time" name="duration_time"
                                                    placeholder="Enter duration time (minutes)"  >
                                            </div>
                                        </div> -->

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="workout_name">Workout Name</label>
                                                <input type="text" class="form-control" id="workout_name" name="workout_name"
                                                    placeholder="Enter workout name" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="workout_name">Description</label>
                                                <input type="text" class="form-control" id="description" name="description"
                                                    placeholder="Enter description" required>
                                            </div>

                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-sm-6">
                                                <label for="target_muscle_group">Target Muscle Group</label>
                                                <input type="text" class="form-control" id="target_muscle_group" name="target_muscle_group"
                                                    placeholder="Enter target muscle group" required>
                                            </div>


                                        </div>


                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>

                            </div>
                            <!-- /.card-body -->


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