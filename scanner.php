<?php
include('includes/config.php');
require_once('phpqrcode/qrlib.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// $pageTitle = 'Dashboard';

//counter parts
function getTotalMembersCount()
{
    global $conn;

    $totalMembersQuery = "SELECT COUNT(*) AS totalMembers FROM members";
    $totalMembersResult = $conn->query($totalMembersQuery);

    if ($totalMembersResult->num_rows > 0) {
        $totalMembersRow = $totalMembersResult->fetch_assoc();
        return $totalMembersRow['totalMembers'];
    } else {
        return 0;
    }
}

function getTotalMembershipTypesCount()
{
    global $conn;

    $totalMembershipTypesQuery = "SELECT COUNT(*) AS totalMembershipTypes FROM membership_types";
    $totalMembershipTypesResult = $conn->query($totalMembershipTypesQuery);

    if ($totalMembershipTypesResult->num_rows > 0) {
        $totalMembershipTypesRow = $totalMembershipTypesResult->fetch_assoc();
        return $totalMembershipTypesRow['totalMembershipTypes'];
    } else {
        return 0;
    }
}

function getExpiringSoonCount()
{
    global $conn;

    $expiringSoonQuery = "SELECT COUNT(*) AS expiringSoon FROM members WHERE expiry_date BETWEEN CURDATE() AND CURDATE() + INTERVAL 7 DAY";
    $expiringSoonResult = $conn->query($expiringSoonQuery);

    if ($expiringSoonResult->num_rows > 0) {
        $expiringSoonRow = $expiringSoonResult->fetch_assoc();
        return $expiringSoonRow['expiringSoon'];
    } else {
        return 0;
    }
}

// function getTotalRevenue()
// {
//     global $conn;

//     $totalRevenueQuery = "SELECT SUM(total_amount) AS totalRevenue FROM renew";
//     $totalRevenueResult = $conn->query($totalRevenueQuery);

//     if ($totalRevenueResult->num_rows > 0) {
//         $totalRevenueRow = $totalRevenueResult->fetch_assoc();
//         return $totalRevenueRow['totalRevenue'];
//     } else {
//         return 0;
//     }
// }

function getTotalRevenueWithCurrency()
{
    global $conn;

    $currencyQuery = "SELECT currency FROM settings LIMIT 1";
    $currencyResult = $conn->query($currencyQuery);

    if ($currencyResult->num_rows > 0) {
        $currencyRow = $currencyResult->fetch_assoc();
        $currencySymbol = $currencyRow['currency'];
    } else {
        $currencySymbol = '$'; // Default currency symbol (you can change this as needed)
    }

    $totalRevenueQuery = "SELECT SUM(total_amount) AS totalRevenue FROM renew";
    $totalRevenueResult = $conn->query($totalRevenueQuery);

    if ($totalRevenueResult->num_rows > 0) {
        $totalRevenueRow = $totalRevenueResult->fetch_assoc();
        $totalRevenue = $totalRevenueRow['totalRevenue'];
    } else {
        $totalRevenue = 0;
    }

    return $currencySymbol . number_format($totalRevenue, 2);
}

function getNewMembersCount()
{
    global $conn;

    $twentyFourHoursAgo = time() - (24 * 60 * 60);

    $newMembersQuery = "SELECT COUNT(*) AS newMembersCount FROM members WHERE created_at >= FROM_UNIXTIME($twentyFourHoursAgo)";
    $newMembersResult = $conn->query($newMembersQuery);

    if ($newMembersResult) {
        $row = $newMembersResult->fetch_assoc();
        return $row['newMembersCount'];
    } else {
        return 0;
    }
}

// Function to display the total count of new members with HTML markup
function displayNewMembersCount()
{
    $newMembersCount = getNewMembersCount();
    echo "<span class='info-box-number'>$newMembersCount</span>";
}


function getExpiredMembersCount()
{
    global $conn;

    $expiredMembersQuery = "SELECT COUNT(*) AS expiredMembersCount FROM members WHERE (expiry_date IS NULL OR expiry_date < NOW())";
    $expiredMembersResult = $conn->query($expiredMembersQuery);

    if ($expiredMembersResult) {
        $row = $expiredMembersResult->fetch_assoc();
        return $row['expiredMembersCount'];
    } else {
        return 0;
    }
}

function displayExpiredMembersCount()
{
    $expiredMembersCount = getExpiredMembersCount();
    echo "<span class='info-box-number'>$expiredMembersCount</span>";
}

$fetchLogoQuery = "SELECT logo FROM settings WHERE id = 1";
$fetchLogoResult = $conn->query($fetchLogoQuery);

if ($fetchLogoResult->num_rows > 0) {
    $settings = $fetchLogoResult->fetch_assoc();
    $logoPath = $settings['logo'];
} else {
    $logoPath = 'dist/img/default-logo.png';
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


                    <!-- Main row -->
                    <div class="row ">

                        <div class="col-md-12">
                            <!-- Member LIST -->
                            <?php
                            // Fetch recently joined members
                            $recentMembersQuery = "SELECT * FROM members ORDER BY created_at DESC LIMIT 4";
                            $recentMembersResult = $conn->query($recentMembersQuery);
                            ?>

                            <div class="card p-2">


                                <div class="card-header">
                                    <h3 class="card-title">Scan QR Code</h3>
                                </div>

                                <div class="card-body p-0 flex justify-center py-1">
                                    <img src="uploads/cfg-logo.png" alt="..." class="img-thumbnail" width="35%" height="350">
                                </div>
                                <div class=" flex justify-center py-2">
                                    <button type="button" class="btn btn-primary">
                                        Scan
                                    </button>
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
        <footer class="main-footer">
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