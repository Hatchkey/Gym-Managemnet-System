<?php
include('includes/config.php');
include('phpqrcode/qrlib.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$response = array('success' => false, 'message' => '');

$membershipTypesQuery = "SELECT id, type, amount FROM membership_types";
$membershipTypesResult = $conn->query($membershipTypesQuery);

// function generateUniqueFileName($originalName)
// {
//     $timestamp = time();
//     $extension = pathinfo($originalName, PATHINFO_EXTENSION);
//     $uniqueName = $timestamp . '_' . uniqid() . '.' . $extension;
//     return $uniqueName;
// }


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentDate = date('Y-m-d');
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $contactNumber = $_POST['contactNumber'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $membershipType = $_POST['membershipType'];
    $password = $_POST['password'];
    $qrText = $_POST['fullname'] . (string)time() . (string)microtime(true);
    $qrCodeImage = 'qrcode/generated_qrcode.png';
    $defaultUserRole = 'user';
    QRcode::png($qrText, $qrCodeImage);
    $hashedPassword = md5($password);
    $membershipNumber = 'CA-' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);

    $checkQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param('s', $email); // 's' indicates the type is string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response['success'] = false;
        $response['message'] = 'Email is already exist: ' . $email;
    } else {
        // Use prepared statements for inserting into the users table first
        $insertUserQuery = "INSERT INTO users (email, password) VALUES (?, ?)";

        $stmtUser = $conn->prepare($insertUserQuery);
        $stmtUser->bind_param("ss", $email, $hashedPassword);

        // Execute the insertion into users table
        if ($stmtUser->execute()) {
            $lastInsertedUserId = $conn->insert_id; // Get the last inserted ID from the users table

            $extendDays = (int)$_POST['extend']; //Convert into int
            if ($_POST['extend'] == '111') {
                $expiryDate = date('Y-m-d', strtotime("+1 day"));
            } else {
                $expiryDate = date('Y-m-d', strtotime("+$extendDays month"));
            }
     
            $insertMemberQuery = "INSERT INTO members (fullname, dob, gender, contact_number, email, address,  
            membership_type, membership_number, qrcode, created_at, role, expiry_date) 
            VALUES (?, ?,  ?, ?, ?, ?, ?, ?, ?,  NOW(), ?, ?)";

            $stmtMember = $conn->prepare($insertMemberQuery);
            $stmtMember->bind_param(
                "sssssssssss",
                $fullname,
                $dob,
                $gender,
                $contactNumber,
                $email,
                $address,
                $membershipType,
                $membershipNumber,
                $qrText,
                $defaultUserRole,
                $expiryDate
            );

            if ($stmtMember->execute()) {
                $lastInsertedMemberId = $conn->insert_id;
                $mode = $_POST['modepayment'];
                $reference = $_POST['reference'];
                $insertPaymentQuery = "INSERT INTO payment (member, date, mode, reference, created_at) VALUES (?, ?, '$mode', '$reference', NOW())";
                $stmtPayment = $conn->prepare($insertPaymentQuery);
                $stmtPayment->bind_param("is", $lastInsertedMemberId, $currentDate);

                if ($stmtPayment->execute()) {
                    // echo "Record inserted into payment successfully.";
                    $response['success'] = true;
                    $response['message'] = 'Member added successfully! Membership Number: ' . $membershipNumber;
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Error inserting into payment: ' . $stmtPayment->error;
                }
                $lastInsertedPaymentId = $conn->insert_id;
                $totalAmount = $_POST['totalAmount'];
                $membership_type = $_POST['membershipType'];
                $upto = $_POST['extend'];
                $insertRenew = "INSERT INTO renew (member_id, total_amount, membership_type, upto, payment_id, renew_date) 
                        VALUES ('$lastInsertedMemberId', '$totalAmount', '$membership_type', '$upto', '$lastInsertedPaymentId', '$currentDate')";
                if ($conn->query($insertRenew) === TRUE) {
                    $response['success'] = true;
                }
            } else {
                $response['success'] = false;
                $response['message'] = 'Error inserting into members: ' . $stmtMember->error;
            }

            // Close member statement
            $stmtMember->close();
        } else {
            $response['success'] = false;
            $response['message'] = 'Error inserting into users: ' . $stmtUser->error;
        }

        // Close user and payment statements
        $stmtUser->close();
        $stmtPayment->close();
    }
}
?>



<?php include('includes/header.php'); ?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <?php include('includes/nav.php'); ?>

        <?php include('includes/sidebar.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper  bg-[#364a53]">
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
                            <div class="card bg-[#ececec]">
                                <div class="card-header  bg-[#aeb3b3]">
                                    <h3 class="card-title"><i class="fas fa-keyboard"></i> Add Members Form</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="card-body">

                                        <div class="row">
                                            <h1 class="text-lg font-bold ml-1">Basic Information</h1>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-6">
                                                <label for="fullname">Name</label>
                                                <input type="text" class="form-control" id="fullname" name="fullname"
                                                    placeholder="Enter name" required>
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

                                        <div class="row">
                                            <h1 class="text-lg font-bold ml-1 mt-4">Payment </h1>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-6">
                                                <label for="extendate">Renew Up to</label>
                                                <select class="form-control" id="extend" name="extend" required>
                                                    <option value="111">One Day</option>
                                                    <option value="1">One Month</option>
                                                    <option value="3">Three Months</option>
                                                    <option value="6">Six Months</option>
                                                    <option value="12">One Year</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="totalAmount">Total Amount</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="currencySymbol"><?php echo getCurrencySymbol(); ?></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="totalAmount" name="totalAmount" placeholder="Total Amount" readonly>
                                                </div>
                                            </div>
                                            <?php
                                            function getCurrencySymbol()
                                            {
                                                global $conn;

                                                $currencyQuery = "SELECT currency FROM settings";
                                                $currencyResult = $conn->query($currencyQuery);

                                                if ($currencyResult->num_rows > 0) {
                                                    $currencyRow = $currencyResult->fetch_assoc();
                                                    return $currencyRow['currency'];
                                                } else {
                                                    return '$';
                                                }
                                            }
                                            ?>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-sm-6">
                                                <label for="membershipType">Membership Type</label>
                                                <!-- Replace with a dynamic select box populated from the database -->
                                                <select class="form-control" id="membershipType" name="membershipType" required>
                                                    <?php
                                                    if ($membershipTypesResult) {
                                                        while ($row = $membershipTypesResult->fetch_assoc()) {
                                                            echo "<option value='{$row['id']}'>{$row['type']} - {$row['amount']}</option>";
                                                        }
                                                    } else {
                                                        echo "Error: " . $conn->error;
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-sm-6">
                                                <label for="modepayment">Mode of payment</label>
                                                <input type="text" class="form-control" id="modepayment" name="modepayment"
                                                    placeholder="Enter mode of payment" required>
                                            </div>
                                        </div>
                                        <div class="row mt-3  mt-3">
                                            <div class="col-sm-6">
                                                <label for="reference">Reference Number</label>
                                                <input type="text" class="form-control" id="reference" name="reference"
                                                    placeholder="Enter reference number">
                                            </div>
                                        </div>


                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn bg-[#20333c] text-white">Submit</button>
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
    $(document).ready(function() {
        function updateTotalAmount() {
            var membershipTypeAmount = parseFloat($('#membershipType option:selected').text().split('-').pop());
 
            var renewDuration = parseFloat($('#extend').val());
            if (renewDuration === 111) {
                $('#totalAmount').val(100);

            } else {
                var totalAmount = membershipTypeAmount * renewDuration;
                console.log("totalAmount", renewDuration)

                $('#totalAmount').val(totalAmount.toFixed(2));
            }
            
        }

        $('#membershipType, #extend').change(updateTotalAmount);

        updateTotalAmount();
    });

</script>

</html>