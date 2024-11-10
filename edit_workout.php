<?php
include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$response = array('success' => false, 'message' => '');

$workOutListQuery = "SELECT id FROM workout_list";
$workOutListResult = $conn->query($workOutListQuery);

if (isset($_GET['id'])) {
    $workOutId = $_GET['id'];

    $fetchWorkOutListQuery = "SELECT * FROM workout_list WHERE id = $workOutId";
    $fetchWorkoutListResult = $conn->query($fetchWorkOutListQuery);

    if ($fetchWorkoutListResult->num_rows > 0) {
        $workOutDetails = $fetchWorkoutListResult->fetch_assoc();
    } else {
        // header("Location: members_list.php");
        // exit();
    }
}

function generateUniqueFileName($filename)
{
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $basename = pathinfo($filename, PATHINFO_FILENAME);
    $uniqueName = $basename . '_' . time() . '.' . $ext;
    return $uniqueName;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['workout_name'];
    $equipment_type = $_POST['equipment_type'];
    $target_muscle = $_POST['target_muscle'];
    $sets = $_POST['sets'];
    $reps = $_POST['reps'];
    $duration_time = $_POST['duration_time'];



    $updateQuery = "UPDATE workout_list SET workout_name='$fullname',  equipment_type='$equipment_type', target_muscle_group='$target_muscle', sets='$sets', reps='$reps', duration_time='$duration_time'
                    WHERE id = $workOutId";

    if ($conn->query($updateQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = 'Workout program updated successfully!';

        header("Location: manage_workout.php");
        exit();
    } else {
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
                                <div class="alert alert-success alert-dismissible">
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
                                    <h3 class="card-title"><i class="fas fa-keyboard"></i> Edit Workout Program Details</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="workout_name">Workout Name</label>
                                                <input type="text" class="form-control" id="workout_name" name="workout_name"
                                                    placeholder="Enter workout name" required value="<?php echo $workOutDetails['workout_name']; ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="equipment_type">Equipment Type</label>
                                                <input type="text" class="form-control" id="equipment_type" name="equipment_type"
                                                    placeholder="Enter equipment type" required value="<?php echo $workOutDetails['equipment_type']; ?>">
                                            </div>

                                        </div>


                                        <div class="row mt-3">
                                            <div class="col-sm-6">
                                                <label for="target_muscle">Target Muscle Group</label>
                                                <input type="text" class="form-control" id="target_muscle"
                                                    name="target_muscle" placeholder="Enter target muscle group" required value="<?php echo $workOutDetails['target_muscle_group']; ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="sets">Set</label>
                                                <input type="number" class="form-control" id="sets" name="sets"
                                                    placeholder="Enter sets" required value="<?php echo $workOutDetails['sets']; ?>">
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-sm-6">
                                                <label for="reps">Reps</label>
                                                <input type="string" class="form-control" id="reps" name="reps"
                                                    placeholder="Enter reps" required value="<?php echo $workOutDetails['reps']; ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="duration_time">Duration Time</label>
                                                <input type="number" class="form-control" id="duration_time" name="duration_time"
                                                    placeholder="Enter duration time (minutes)" value="<?php echo $workOutDetails['duration_time']; ?>">
                                            </div>
                                        </div>




                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
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
            <strong> &copy; <?php echo date('Y'); ?> Camalig Fitness Gym</a> </strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Developed By</b> <a href="https://www.facebook.com/camaligfitnessgym">CFG</a>
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <?php include('includes/footer.php'); ?>
</body>

</html>