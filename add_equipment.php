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
                                    <h3 class="card-title"><i class="fas fa-keyboard"></i> Add Equipment</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="equipment">Equipment</label>
                                                <input type="text" class="form-control" id="equipment" name="equipment"
                                                    placeholder="Enter equipment name" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="purchase">Purchase Date</label>
                                                <input type="date" class="form-control" id="purchase" name="purchase" required>
                                            </div>
                                        </div>


                                        <div class="row mt-3">
                                            <div class="col-sm-6">
                                                <label for="quantity">Quantity</label>
                                                <input type="tel" class="form-control" id="quantity"
                                                    name="quantity" placeholder="Enter quantity" required>
                                            </div>

                                            <div class="col-sm-6">
                                                <label for="price">Price</label>
                                                <input type="text" class="form-control" id="price" name="price"
                                                    placeholder="Enter price" required>
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
<script>
    function deleteMember(id) {
        if (confirm("Are you sure you want to delete this member?")) {
            window.location.href = 'delete_inventory.php?id=' + id;
        }
    }
</script>

</html>