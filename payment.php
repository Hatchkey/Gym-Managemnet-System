<?php
include('includes/config.php');
include('phpqrcode/qrlib.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
global $conn;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $memberId = $_POST['assign_to'];
    $paymentSql = "SELECT date FROM payment WHERE member = '" . $memberId . "' ORDER BY created_at DESC LIMIT 1";
    $resultPayment = $conn->query($paymentSql);
    $rowPayment = $resultPayment->fetch_assoc();
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

$members_query = "SELECT fullname, members.id as memberId, users.id as userId FROM members INNER JOIN users ON members.email = users.email";
$members_result = $conn->query($members_query);
$selectQuery = "SELECT * FROM payment ORDER BY created_at DESC";
$result = $conn->query($selectQuery);
 //
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

                            <div class="card">
                                <div class="card-header">


                                    <h3 class="card-title">Payment Transaction DataTable</h3>

                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th class=''>Name</th>
                                                <th class=''>Amount</th>
                                                <th class=' '>Mode </th>
                                                <th>Purchase Date</th>

                                                <?php if ($_SESSION['role'] == 'admin') { ?>
                                                    <th>Actions</th>
                                                <?php } ?>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $counter = 1;
                                            while ($row = $result->fetch_assoc()) {
                                                // echo "<tr>";


                                                echo "<tr>";
                                                echo "<td>{$row['id']}</td>";
                                                // echo "<td>{$row['equipment']}</td>";
                                                // echo "<td>{$row['quantity']}</td>";
                                                // echo "<td>{$row['price']}</td>";
                                                // echo "<td>{$row['purchase_date']}</td>";
                                                echo "<td>";
                                                // if ($_SESSION['role'] == 'admin') {
                                                //     echo "
                                                // <td>";
                                                // }
                                                // Only show edit and delete buttons for admin
                                                if ($_SESSION['role'] == 'admin') {
                                                    echo "
                                                    <div class='flex gap-x-2'>
                  <a href='edit_inventory.php?id={$row['id']}' class='btn btn-primary'><i class='fas fa-edit'></i></a>
                                <button class='btn btn-danger' onclick='deleteMember({$row['id']})'><i class='fas fa-trash'></i></button>
                 </div>
            ";
                                                }

                                                echo "</tr>";
                                                $counter++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
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

</html>