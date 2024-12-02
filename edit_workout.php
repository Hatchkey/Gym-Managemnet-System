<?php
include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$response = array('success' => false, 'message' => '');

// $workOutListQuery = "SELECT id FROM workout_list";
// $workOutListResult = $conn->query($workOutListQuery);
$workout_list_query = "SELECT * FROM workout_lists";
$workout_list_result = $conn->query($workout_list_query);
$members_query = "SELECT * FROM members";
$members_result = $conn->query($members_query);
if (isset($_GET['id'])) {
    $workOutId = $_GET['id'];

    $fetchWorkOutListQuery = "SELECT * FROM workout_program WHERE id = $workOutId";
    $fetchWorkoutListResult = $conn->query($fetchWorkOutListQuery);

    if ($fetchWorkoutListResult->num_rows > 0) {
        $workOutDetails = $fetchWorkoutListResult->fetch_assoc();

        $workout_id = $workOutDetails['workout_id'];

        $reps = $workOutDetails['reps'];
        $sets = $workOutDetails['sets'];
        $day = $workOutDetails['day'];
        $workout_split = $workOutDetails['workout_split'];
    }
}

function generateUniqueFileName($filename)
{
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $basename = pathinfo($filename, PATHINFO_FILENAME);
    $uniqueName = $basename . '_' . time() . '.' . $ext;
    return $uniqueName;
}

$idToEdit = $_GET['id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $workout_id = $_POST['workout_id']; // Correctly fetching the workout_id
    $assign_to = $_POST['assign_to']; // Member to assign the workout to
    $sets = $_POST['sets'];
    $reps = $_POST['reps'];
    $day = $_POST['day'];
    $workout_split = $_POST['workout_split'];
    // Update query for workout_program table
    $updateWorkoutProgramQuery = "UPDATE workout_program SET 
        workout_id = '$workout_id',
        day = '$day', 
        sets = '$sets', 
        reps = '$reps', 
        workout_split = '$workout_split',
        member_id = '$assign_to'  
        WHERE id ='$idToEdit' ";



    // Execute the update query for workout_program
    if ($conn->query($updateWorkoutProgramQuery) === TRUE) {
        // If successful
        $response['success'] = true;
        $response['message'] = 'Workout program updated successfully!';
        header("Location: manage_workout.php");
        exit();
    } else {
        // If the update fails
        $response['message'] = 'Error updating workout program: ' . $conn->error;
    }
}

?>

<?php include('includes/header.php'); ?>

<head>

    <style>
        .parent-card {
            background-color: #ececec !important;
        }

        .card-header {
            background-color: #aeb3b3 !important;
        }

        .btn-submit {
            background-color: #20333c !important;
            color: #fff !important;
        }

        .body-container,
        .footer-container {
            background-color: #364a53 !important;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <?php include('includes/nav.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper body-container">
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
                            <div class="card  parent-card ">
                                <div class="card-header  bg-[#aeb3b3]">
                                    <h3 class="card-title"><i class="fas fa-keyboard"></i> Edit Workout Program Details</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="workout_name">Workout Name</label>
                                                <?php


                                                ?>
                                                <select name="workout_id" id="workout_id" class="form-control" required>
                                                    <option value="">Select Workout</option>
                                                    <?php
                                                    if ($workout_list_result->num_rows > 0) {

                                                        while ($row = $workout_list_result->fetch_assoc()) {

                                                            // $selected = ($row['workout_id'] == $row['workout_id']) ? 'selected' : '';
                                                            $selected = ($row['workout_id'] == $workout_id) ? 'selected' : '';
                                                            echo '<option value="' . htmlspecialchars($row['workout_id']) . '" ' . $selected . '>' . htmlspecialchars($row['workout_name']) . '</option>';
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
                                                    placeholder="Enter reps" required value="<?= htmlspecialchars($reps) ?>">
                                            </div>
                                        </div>
                                        <div class="row mt-3">

                                            <div class="col-sm-6">
                                                <label for="day">Day</label>
                                                <input type="number" class="form-control" id="day" name="day"
                                                    placeholder="Enter day" required value="<?= htmlspecialchars($day) ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="sets">Sets</label>
                                                <input type="number" class="form-control" id="sets" name="sets"
                                                    placeholder="Enter sets" required value="<?= htmlspecialchars($sets) ?>">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-6">
                                                <label for="assign_to">Assign To</label>
                                                <select name="assign_to" id="assign_to" class="form-control" required>
                                                    <option value="">Assign to member</option>
                                                    <?php
                                                    if ($members_result->num_rows > 0) {
                                                        while ($row = $members_result->fetch_assoc()) {
                                                            // Check if the current row's member ID matches the assigned member's ID
                                                            $selected = ($row['id'] == $workOutDetails['member_id']) ? 'selected' : '';
                                                            echo '<option value="' . htmlspecialchars($row['id']) . '" ' . $selected . '>' . htmlspecialchars($row['fullname']) . '</option>';
                                                        }
                                                    } else {
                                                        echo '<option value="">No Members Available</option>';
                                                    }
                                                    ?>

                                                </select>
                                            </div>

                                            <div class="col-sm-6 w-full">
                                                <label for="workout_split">Workout Split</label>

                                                <div class="w-full">

                                                    <select name="workout_split" id="workout_split" class="form-control " required>
                                                        <option value="">Select Workout Split</option>
                                                        <option value="Push" <?= ($workout_split == 'Push') ? 'selected' : '' ?>>Push</option>
                                                        <option value="Upper" <?= ($workout_split == 'Upper') ? 'selected' : '' ?>>Upper</option>
                                                        <option value="Full Body" <?= ($workout_split == 'Full Body') ? 'selected' : '' ?>>Full Body</option>
                                                        <option value="Chest" <?= ($workout_split == 'Chest') ? 'selected' : '' ?>>Chest</option>
                                                        <option value="Lower" <?= ($workout_split == 'Lower') ? 'selected' : '' ?>>Lower</option>
                                                        <option value="Legs" <?= ($workout_split == 'Legs') ? 'selected' : '' ?>>Legs</option>
                                                        <option value="Shoulder" <?= ($workout_split == 'Shoulder') ? 'selected' : '' ?>>Shoulder</option>
                                                        <option value="Back" <?= ($workout_split == 'Back') ? 'selected' : '' ?>>Back</option>
                                                        <option value="Arms" <?= ($workout_split == 'Arms') ? 'selected' : '' ?>>Arms</option>
                                                        <option value="Pull" <?= ($workout_split == 'Pull') ? 'selected' : '' ?>>Pull</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-submit">Submit</button>
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

        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer footer-container">
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