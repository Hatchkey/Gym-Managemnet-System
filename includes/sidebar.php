<?php
// $pages = array(
//     'dashboard.php',
//     'members_list.php',
//     'add_type.php',
//     'view_type.php'
//     // Add other page names here
// );

$current_page = basename($_SERVER['PHP_SELF']);

$countQuery = "SELECT COUNT(*) as total_types FROM membership_types";
$countResult = $conn->query($countQuery);

if ($countResult && $countResult->num_rows > 0) {
  $totalCount = $countResult->fetch_assoc()['total_types'];
} else {
  $totalCount = 0;
}
?>


<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-blue elevation-4">
  <!-- Brand Logo -->
  <a href="" class="brand-link">
    <img src="uploads/cfg-logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light"><?php echo getSystemName(); ?></span>
  </a>

  <?php
  function getSystemName()
  {
    global $conn;

    $systemNameQuery = "SELECT system_name FROM settings";
    $systemNameResult = $conn->query($systemNameQuery);

    if ($systemNameResult->num_rows > 0) {
      $systemNameRow = $systemNameResult->fetch_assoc();
      return $systemNameRow['system_name'];
    } else {
      return 'Camalig Fitness Gym';
    }
  }

  function getLogoUrl()
  {
    global $conn;

    $logoQuery = "SELECT logo FROM settings";
    $logoResult = $conn->query($logoQuery);

    if ($logoResult->num_rows > 0) {
      $logoRow = $logoResult->fetch_assoc();
      return $logoRow['logo'];
    } else {
      return 'dist/img/AdminLTELogo.png';
    }
  }

  function hasUserPaid()
  {
    global $conn;
    // Assume you already have a database connection $conn
    $paymentSql = "SELECT date FROM payment WHERE member = '" . $_SESSION['user_id'] . "' ORDER BY created_at DESC LIMIT 1";
    $resultPayment = $conn->query($paymentSql);
    $rowPayment = $resultPayment->fetch_assoc();

    $paymentDate = new DateTime($rowPayment['date']);
    $currentDate = new DateTime();

    $interval = $paymentDate->diff($currentDate);
    if ($interval->m >= 1 || $interval->y > 0) {
      return false; // Not paid for this month
    } else {
      return true; // Paid for this month
    }
  }

  ?>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">

      <div class="info">

      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <?php
        // Render if the login user is ADMIN
        if ($_SESSION['role'] == 'admin') {
        ?>
          <!-- Admin Menu -->
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?php echo ($current_page == 'add_type.php' || $current_page == 'view_type.php' || $current_page == 'edit_type.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-th-list"></i>
              <p>
                Membership Types
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="add_type.php" class="nav-link">
                  <i class="fas fa-circle-notch nav-icon"></i>
                  <p>Add New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="view_type.php" class="nav-link">
                  <i class="fas fa-circle-notch nav-icon"></i>
                  <p>View and Manage</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="add_members.php" class="nav-link <?php echo ($current_page == 'add_members.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>Add Members</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="manage_members.php" class="nav-link <?php echo ($current_page == 'manage_members.php' || $current_page == 'edit_member.php' || $current_page == 'memberProfile.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>Manage Members</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="list_renewal.php" class="nav-link <?php echo ($current_page == 'list_renewal.php' || $current_page == 'renew.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-undo"></i>
              <p>Renewal</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="report.php" class="nav-link <?php echo ($current_page == 'report.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-file-invoice"></i>
              <p>Membership Report</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="revenue_report.php" class="nav-link <?php echo ($current_page == 'revenue_report.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-money-check"></i>
              <p>Revenue Report</p>
            </a>
          </li>


          <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?php echo ($current_page == 'add_workout.php' || $current_page == 'manage_workout.php' || $current_page == 'edit_workout.php' || $current_page == 'assign_workout.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-clipboard-list"></i>
              <p>
                Workout Program
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="add_workout.php" class="nav-link">
                  <i class="fas fa-circle-notch nav-icon"></i>
                  <p>Add Workout List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="assign_workout.php" class="nav-link">
                  <i class="fas fa-circle-notch nav-icon"></i>
                  <p>Assign Workout Program</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="manage_workout.php" class="nav-link">
                  <i class="fas fa-circle-notch nav-icon"></i>
                  <p>Manage Workout Program</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="scanner.php" class="nav-link flex items-center <?php echo ($current_page == 'scanner.php') ? 'active' : ''; ?>">
              <!-- <span class="nav-icon material-symbols-outlined ">
                qr_code_scanner
              </span> -->
              <i class="nav-icon material-symbols-outlined ">qr_code_scanner</i>
              <p class="">Scanner</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="payment.php" class="nav-link <?php echo ($current_page == 'payment.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>Payment Transaction <i class="fas fa-angle-left right"></i></p>
            </a>
          </li>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="inventory.php" class="nav-link <?php echo ($current_page == 'inventory.php') ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-box"></i>
                <p>Inventory</p>
              </a>
            </li>
          </ul>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?php echo ($current_page == 'inventory.php' || $current_page == 'add_equipment.php' || $current_page == 'edit_inventory.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-box"></i>
              <p>
                Inventory
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="add_equipment.php" class="nav-link">
                  <i class="fas fa-circle-notch nav-icon"></i>
                  <p>Add Equipment</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="inventory.php" class="nav-link">
                  <i class="fas fa-circle-notch nav-icon"></i>
                  <p>Equipment Inventory</p>
                </a>
              </li>

            </ul>
          </li>

          <li class="nav-item">
            <a href="settings.php" class="nav-link <?php echo ($current_page == 'settings.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-cogs"></i>
              <p>Settings</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="logout.php" class="nav-link <?php echo ($current_page == 'logout.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-power-off"></i>
              <p>Logout</p>
            </a>
          </li>

        <?php
        }
        // Render if the login user is CUSTOMER
        elseif ($_SESSION['role'] == 'user') {
        ?>
          <!-- User Menu -->
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <?php
          $isPaid = hasUserPaid(); // Check if user has paid
          ?>
          <li class="nav-item">
            <a href="manage_workout.php" class="nav-link 
              <?php echo ($current_page == 'manage_workout.php') ? 'active' : ''; ?>
              <?php echo (!$isPaid ? 'disabled' : ''); ?>"
              <?php echo (!$isPaid ? 'style="pointer-events: none; opacity: 0.5;"' : ''); ?>>
              <i class="nav-icon fas fa-clipboard-list"></i>
              <p>Workout Program</p>
            </a>
          </li>
          <!-- Additional User Menu Item (e.g., QR code) -->
          <li class="nav-item">
            <a href="user_qr_code.php" class="nav-link 
              <?php echo ($current_page == 'user_qr_code.php') ? 'active' : ''; ?> 
              <?php echo (!$isPaid ? 'disabled' : ''); ?>"
              <?php echo (!$isPaid ? 'style="pointer-events: none; opacity: 0.5;"' : ''); ?>>
              <i class="nav-icon fas fa-qrcode"></i>
              <p>QR Code</p>
            </a>
            <!-- <a href="user_qr_code.php" class="nav-link <?php echo ($current_page == 'user_qr_code.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-qrcode"></i>
              <p>QR Code</p>
            </a> -->
          </li>
          <!-- <li class="nav-item">
            <a href="user_profile.php" class="nav-link <?php echo ($current_page == 'user_profile.php') ? 'active' : ''; ?>">

              <i class="fa-solid fas fa-user nav-icon"></i>
              <p>Profile</p>
            </a>
          </li> -->

          <li class="nav-item">
            <a href="logout.php" class="nav-link <?php echo ($current_page == 'logout.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-power-off"></i>
              <p>Logout</p>
            </a>
          </li>
        <?php
        }
        ?>



      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>