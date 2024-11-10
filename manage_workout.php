<?php
include('includes/config.php');

$selectQuery = "SELECT * FROM workout_list ORDER BY created_at DESC";
$result = $conn->query($selectQuery);


if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
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

                        <div class="col-12">

                            <div class="card">
                                <div class="card-header">


                                    <?php if ($_SESSION['role'] == 'admin') { ?>
                                        <h3 class="card-title">Workout Program List DataTable</h3>
                                    <?php } ?>
                                    <?php if ($_SESSION['role'] == 'user') { ?>
                                        <h3 class="card-title">Workout Program List DataTable</h3>
                                    <?php } ?>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Workout Name</th>
                                                <th>Equipment Type</th>
                                                <th>Target Muscle Group</th>
                                                <th>Sets</th>
                                                <th>Reps</th>
                                                <th>Duration Time </th>
                                                <?php if ($_SESSION['role'] == 'admin') { ?>
                                                    <th>Actions</th>
                                                <?php } ?>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $counter = 1;
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>{$row['id']}</td>";
                                                echo "<td>{$row['workout_name']}</td>";
                                                echo "<td>{$row['equipment_type']}</td>";
                                                echo "<td>{$row['target_muscle_group']}</td>";
                                                echo "<td>{$row['sets']}</td>";
                                                echo "<td>{$row['reps']}</td>";
                                                echo "<td>{$row['duration_time']}</td>";
                                                if ($_SESSION['role'] == 'admin') {
                                                    echo "
                                                <td>";
                                                }


                                                // Only show edit and delete buttons for admin
                                                if ($_SESSION['role'] == 'admin') {
                                                    echo "
                <a href='edit_workout.php?id={$row['id']}' class='btn btn-primary'><i class='fas fa-edit'></i></a>
                <button class='btn btn-danger' onclick='deleteMember({$row['id']})'><i class='fas fa-trash'></i></button>
            ";
                                                }
                                                echo "</td>";
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
            <strong> &copy; <?php echo date('Y'); ?> Camalig Fitness Gym</a> </strong>
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
                "width": "100%",
            });
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

    <script>
        function deleteMember(id) {
            if (confirm("Are you sure you want to delete this workout program?")) {
                window.location.href = 'delete_workout.php?id=' + id;
            }
        }
    </script>

</body>

</html>