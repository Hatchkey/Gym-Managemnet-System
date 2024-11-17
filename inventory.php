<?php
include('includes/config.php');
include('phpqrcode/qrlib.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$response = array('success' => false, 'message' => '');

$selectQuery = "SELECT * FROM inventory ORDER BY created_at DESC";
$result = $conn->query($selectQuery);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipment = $_POST['equipment'];
    $purchase = $_POST['purchase'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $insertQuery = "INSERT INTO inventory (equipment, quantity, purchase_date, price) 
                    VALUES ('$equipment', '$quantity', '$purchase', '$price')";

    if ($conn->query($insertQuery) === TRUE) {
        $response['success'] = true;
    }
}
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
                                    <h3 class="card-title">Equipment List DataTable</h3>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th class=''>Equipment</th>
                                                <th class=''>Price</th>
                                                <th class=' '>Quantity </th>
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
                                                echo "<td>{$row['equipment']}</td>";
                                                echo "<td>{$row['quantity']}</td>";
                                                echo "<td>{$row['price']}</td>";
                                                echo "<td>{$row['purchase_date']}</td>";
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
</body>
<script>
    function deleteMember(id) {
        if (confirm("Are you sure you want to delete this member?")) {
            window.location.href = 'delete_inventory.php?id=' + id;
        }
    }
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,

        });
    });
</script>

</html>