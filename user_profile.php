<?php
include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$response = array('success' => false, 'message' => '');

$membershipTypesQuery = "SELECT id, type, amount FROM membership_types";
$membershipTypesResult = $conn->query($membershipTypesQuery);

function generateUniqueFileName($originalName)
{
    $timestamp = time();
    $extension = pathinfo($originalName, PATHINFO_EXTENSION);
    $uniqueName = $timestamp . '_' . uniqid() . '.' . $extension;
    return $uniqueName;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['workout_name'];
    $equipment_type = $_POST['equipment_type'];
    $target_muscle = $_POST['target_muscle'];
    $sets = $_POST['sets'];
    $reps = $_POST['reps'];
    $duration_time = $_POST['duration_time'];
    

    // $membershipNumber = 'CA-' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);

    $insertQuery = "INSERT INTO workout_list (workout_name,  equipment_type, target_muscle_group,sets,reps,duration_time) 
                    VALUES ( '$fullname', '$equipment_type', '$target_muscle', '$sets', '$reps', '$duration_time')";

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
        <!-- TODO: To be implemented -->

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
                                    <h3 class="card-title"><i class="fas fa-keyboard"></i> Edit User Profile </h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="fullname">Full Name</label>
                                                <input type="text" class="form-control" id="fullname" name="fullname"
                                                    placeholder="Enter full name" required>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="dob">Date of Birth</label>
                                                <input type="date" class="form-control" id="dob" name="dob" required>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="gender">Gender</label>
                                                <select class="form-control" id="gender" name="gender" required>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="row mt-3">
                                            <div class="col-sm-6">
                                                <label for="contactNumber">Contact Number</label>
                                                <input type="tel" class="form-control" id="contactNumber"
                                                    name="contactNumber" placeholder="Enter contact number" required>
                                            </div>

                                            <div class="col-sm-6">
                                                <label for="address">Address</label>
                                                <input type="text" class="form-control" id="address" name="address"
                                                    placeholder="Enter address" required>
                                            </div>
                                        </div>

                                        <div class="row mt-3">

                                            <div class="col-sm-6">
                                                <label for="country">Country</label>
                                                <input type="text" class="form-control" id="country" name="country"
                                                    placeholder="Enter country" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="postcode">Postcode</label>
                                                <input type="text" class="form-control" id="postcode" name="postcode"
                                                    placeholder="Enter postcode" required>
                                            </div>
                                        </div>


                                        <div class="row mt-3">

                                            <div class="col-sm-6">
                                                <label for="occupation">Occupation</label>
                                                <input type="text" class="form-control" id="occupation" name="occupation"
                                                    placeholder="Enter occupation" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="membershipType">Membership Type</label>
                                                <!-- Replace with a dynamic select box populated from the database -->
                                                <select class="form-control" id="membershipType" name="membershipType" required>
                                                    <?php
                                                    if ($membershipTypesResult) {
                                                        while ($row = $membershipTypesResult->fetch_assoc()) {
                                                            $currencyQuery = "SELECT currency FROM settings";
                                                            $currencyResult = $conn->query($currencyQuery);

                                                            if ($currencyResult->num_rows > 0) {
                                                                $currencyRow = $currencyResult->fetch_assoc();
                                                                $currencySymbol = $currencyRow['currency'];
                                                            } else {
                                                                $currencySymbol = '$';
                                                            }

                                                            echo "<option value='{$row['id']}'>{$row['type']} - {$currencySymbol}{$row['amount']}</option>";
                                                        }
                                                    } else {
                                                        echo "Error: " . $conn->error;
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="row mt-3">

                                            <!-- <div class="col-sm-6">
                                                <label for="photo">Member Photo</label>
                                                <input type="file" class="form-control-file" id="photo" name="photo">
                                            </div> -->
                                        </div>
                                        <div class="row mt-3">

                                            <div class="col-sm-6">
                                                <label for="email">Email</label>
                                                <input type="emai   l" class="form-control" id="email" name="email"
                                                    placeholder="Enter email" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" id="password" name="password"
                                                    placeholder="Enter password" required>
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