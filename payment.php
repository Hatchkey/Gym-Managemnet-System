<?php
include('includes/config.php');
include('phpqrcode/qrlib.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
global $conn;

// $selectQuery = "SELECT payment.id, fullname, reference, date, mode, total_amount FROM payment
//                 INNER JOIN members ON payment.member = members.id
//                 INNER JOIN renew ON renew.payment_id = payment.id
//                 ORDER BY payment.created_at DESC";


    $selectQuery = "SELECT payment.id, fullname, type, reference, date, mode, total_amount FROM payment
                INNER JOIN members ON payment.member = members.id
                INNER JOIN renew ON renew.payment_id = payment.id
                INNER JOIN membership_types ON membership_types.id = renew.membership_type
                ORDER BY payment.created_at DESC";
$result = $conn->query($selectQuery);

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
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <div class="card bg-[#ececec]">
                                <div class="card-header  bg-[#aeb3b3]">
                                    <h3 class="card-title">Payment Transaction DataTable</h3>

                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class=''>Fullname</th>
                                                <th class=''>Amount</th>
                                                <th class=' '>Mode </th>
                                                <th>Membership Type</th>
                                                <th>Paid Date</th>


                                                <th class=''>Reference</th>

                                                <?php if ($_SESSION['role'] == 'admin') { ?>
                                                    <!-- <th>Actions</th> -->
                                                <?php } ?>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $counter = 1;
                                            while ($row = $result->fetch_assoc()) {
                                                // echo "<tr>";


                                                echo "<tr>";
                                                echo "<td>{$row['fullname']}</td>";
                                                echo "<td>{$row['total_amount']}</td>";
                                                echo "<td>{$row['mode']}</td>";
                                                echo "<td>{$row['type']}</td>";
                                                echo "<td>{$row['date']}</td>";
                                                echo "<td>{$row['reference']}</td>";
                                                // echo "<td>";
                                                // if ($_SESSION['role'] == 'admin') {
                                                //     echo "
                                                // <td>";
                                                // }
                                                // Only show edit and delete buttons for admin
                                                //                                     if ($_SESSION['role'] == 'admin') {
                                                //                                         echo "
                                                //                                         <div class='flex gap-x-2'>
                                                //       <a href='edit_inventory.php?id={$row['id']}' class='btn btn-primary'><i class='fas fa-edit'></i></a>
                                                //                     <button class='btn btn-danger' onclick='deleteMember({$row['id']})'><i class='fas fa-trash'></i></button>
                                                //      </div>
                                                // ";
                                                //                                     }

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
        <footer class="main-footer bg-[#364a53]">
            <strong> &copy; <?php echo date('Y'); ?>Camalig Fitness Gym</a> </strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Developed By</b> <a href="https://www.facebook.com/camaligfitnessgym">CFG</a>
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <?php include('includes/footer.php'); ?>

    <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,

      });
    });
  </script>

</body>

</html>