<?php
include('includes/config.php');
require_once('phpqrcode/qrlib.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

function processData($data)
{
    global $conn;
    $memberQr = "SELECT id, qrcode FROM members WHERE qrcode = '$data'";
    $memberQrResult = $conn->query($memberQr);
    if ($memberQrResult->num_rows == 1) {
        $row = $memberQrResult->fetch_assoc();
        $memberId = $row['id'];
        $currentDate = date('m/d/Y');

        $attendance = "SELECT * FROM attendance WHERE member = '$memberId' AND date = '$currentDate'";
        $attendanceResult = $conn->query($attendance);
        if ($attendanceResult->num_rows == 1) {
            // ADD ALERT IF EXIST THEN IT SHOULD NOT INSERT AGAIN
            // I.E. ATTENDANCE IS ALREADY RECORDED
        } else {
            $insertUserQuery = "INSERT INTO attendance (member, date) 
                            VALUES ('$memberId', '$currentDate')";
            if ($conn->query($insertUserQuery) === TRUE) {
                $response['success'] = true;
            }
        }

        return "Processed: " . htmlspecialchars($data);
    }
}

// Handle the AJAX request if it is a POST request with data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data'])) {
    $data = $_POST['data'];
    echo processData($data);  // Call the function and return the result
    exit;  // Stop further script execution after sending the response
}

$selectQuery = "SELECT * FROM members INNER JOIN attendance ON attendance.member = members.id ORDER BY attendance.created_at DESC";
$result = $conn->query($selectQuery);

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
                                <div class="flex justify-center py-2">
                                    <video id="my_camera" width="320" height="240" autoplay></video>
                                </div>

                                <input type="text" id="qr_code_text" class="hidden" />
                                <div class="flex justify-center py-2">
                                    <button onclick="startScanning()" class="btn btn-primary">Scan</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div><!--/. container-fluid -->
            </section>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Membership #</th>
                        <th>Fullname</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $counter = 1;
                    while ($row = $result->fetch_assoc()) {

                        $expiryDate = strtotime($row['expiry_date']);
                        $currentDate = time();
                        $daysDifference = floor(($expiryDate - $currentDate) / (60 * 60 * 24));

                        $membershipStatus = ($daysDifference < 0) ? 'Expired' : 'Active';

                        $membershipTypeId = $row['membership_type'];
                        $membershipTypeQuery = "SELECT type FROM membership_types WHERE id = $membershipTypeId";
                        $membershipTypeResult = $conn->query($membershipTypeQuery);
                        $membershipTypeRow = $membershipTypeResult->fetch_assoc();
                        $membershipTypeName = ($membershipTypeRow) ? $membershipTypeRow['type'] : 'Unknown';

                        echo "<tr>";
                        echo "<td>{$row['membership_number']}</td>";
                        echo "<td>{$row['fullname']}</td>";
                        echo "<td>{$row['date']}</td>";



                        echo "</tr>";

                        $counter++;
                    }
                    ?>
                </tbody>

            </table>
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
<script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>
<script type="text/javascript">
    let video = document.getElementById('my_camera');
    let canvasElement = document.createElement('canvas');
    let canvas = canvasElement.getContext('2d');
    let isScanning = false;

    // Start scanning when the button is clicked
    function startScanning() {
        if (navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'environment'
                    }
                })
                .then(function(stream) {
                    // Attach the webcam stream to the video element
                    video.srcObject = stream;
                    video.setAttribute('playsinline', true); // Required for iOS
                    video.play();

                    // Set canvas size to match video
                    video.onloadedmetadata = function() {
                        canvasElement.width = video.videoWidth;
                        canvasElement.height = video.videoHeight;
                        isScanning = true;
                        scanQRCode();
                    };
                })
                .catch(function(err) {
                    console.log("Error: " + err);
                });
        } else {
            alert("Webcam not supported on this device.");
        }
    }

    // Scan QR code in the video stream
    function scanQRCode() {
        if (isScanning) {
            // Draw the video frame to the canvas
            canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
            let imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
            let code = jsQR(imageData.data, canvasElement.width, canvasElement.height);

            if (code) {
                // If a QR code is found, set the text to the textbox
                document.getElementById('qr_code_text').value = code.data;

                fetch('', { // Send to the current PHP page
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'data=' + encodeURIComponent(code.data)
                    })
                    .then(response => response.text())
                    .then(result => {
                        alert("Attendance recorded successfully");
                        location.reload();
                        console.log("Response from PHP:", result);

                    })
                    .catch(error => {
                        console.error("AJAX Error:", error);
                    });

                stopScanning(); // Stop scanning after finding the QR code
            } else {
                // Keep scanning
                requestAnimationFrame(scanQRCode);
            }
        }
    }

    // Stop scanning
    function stopScanning() {
        isScanning = false;
        video.srcObject.getTracks().forEach(track => track.stop());
    }
</script>

</html>