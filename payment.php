<?php
include('includes/config.php');
include('phpqrcode/qrlib.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
global $conn;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paymentSql = "SELECT date FROM payment WHERE member = '" . $_SESSION['user_id'] . "' ORDER BY created_at DESC LIMIT 1";
    $resultPayment = $conn->query($paymentSql);
    $rowPayment = $resultPayment->fetch_assoc();

    $memberId = $_SESSION['user_id'];
    $currentDate = date('m/d/Y');

    $paymentDate = new DateTime($rowPayment['date']);
    $currentDateCompare = new DateTime();

    $interval = $paymentDate->diff($currentDateCompare);
    if ($interval->m >= 1 || $interval->y > 0) {
        $insertQuery = "INSERT INTO payment (member, date) 
                    VALUES ('$memberId', '$currentDate')";

        if ($conn->query($insertQuery) === TRUE) {
            echo "<script>
            alert('Payment successful! Thank you for your payment.');
            window.location.href = 'dashboard.php'; // Redirect after showing alert
          </script>";
            exit();

            // header("Location: dashboard.php");

        }
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
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-keyboard"></i> Members Payment Form</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="number">Card Number</label>
                                                <input type="text" class="form-control" id="number" name="number"
                                                    placeholder="Enter Card Number" required>
                                            </div>



                                            <div class="col-sm-6">
                                                <label for="cvv">Cvv</label>
                                                <input type="text" class="form-control" id="cvv" name="cvv"
                                                    placeholder="Enter cvv" required>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-6">
                                                <label for="month">Expiry month</label>
                                                <input type="text" class="form-control" id="month"
                                                    name="month" placeholder="Enter Expiry month" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="year">Expiry year</label>
                                                <input type="text" class="form-control" id="year" name="year"
                                                    placeholder="Enter Expiry year" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Pay</button>
                                    </div>
                                </form>
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

</html>