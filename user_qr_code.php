<?php
include('includes/config.php');
require_once('phpqrcode/qrlib.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
function generateQrCodeForMember($conn)
{
    // Fetch member email and ID from session
    $memberEmail = $_SESSION['email'];
    $memberId = $_SESSION['user_id'];

    // Query to fetch member details
    $memberQrCodeQuery = "SELECT email, id, qrcode FROM members WHERE email = '$memberEmail'";
    $memberQrCodeResult = $conn->query($memberQrCodeQuery);
    // var_dump($memberQrCodeResult->fetch_assoc());
    // exit();
    if ($memberQrCodeResult->num_rows > 0) {
        // Fetch the data
        $memberQrCodeRow = $memberQrCodeResult->fetch_assoc();

        // Ensure 'qrcode' key exists
        if (!empty($memberQrCodeRow['qrcode'])) {
            // The QR code text fetched from the database
            $text = $memberQrCodeRow['qrcode'];

            // Set the file path where the QR code will be saved
            $filePath = 'qrcode/' . $text . '.png';

            // Generate and save the QR code as a PNG image
            QRcode::png($text, $filePath);
            return $filePath;
        } else {
            return "No QR code text found for User $memberId.";
        }
    } else {
        return "No user found with the provided email and ID.";
    }
}

// Call the function
$qrCodePath = generateQrCodeForMember($conn);

?>

<?php include('includes/header.php'); ?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <?php include('includes/nav.php'); ?>

        <?php include('includes/sidebar.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper bg-[#364a53]">
            <?php include('includes/pagetitle.php'); ?>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Info boxes -->
                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row ">
                        <div class="col-md-12">
                            <!-- Member LIST -->
                            <div class="card ">
                                <!-- /.card-header -->
                                <!-- <div class="card-body p-0 flex justify-center ">
                                    <img src="uploads/cfg-logo.png" alt="..." class="img-thumbnail" width="40%" height="300">
                                </div> -->

                                <div class="card-body p-0 flex justify-center">
                                    <?php if (file_exists($qrCodePath)) : ?>
                                        <!-- Display the QR code if it was generated -->
                                        <img src="<?php echo htmlspecialchars($qrCodePath); ?>" alt="Generated QR Code" class="img-thumbnail" width="40%" height="300">
                                    <?php else : ?>
                                        <!-- Fallback image or message -->
                                        <img src="uploads/cfg-logo.png" alt="Default Logo" class="img-thumbnail" width="40%" height="300">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
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
        <footer class="main-footer bg-[#364a53]">
            <strong> &copy; <?php echo date('Y'); ?> Camalig Fitness Gym</a> -</strong>
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