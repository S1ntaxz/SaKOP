<?php
// Get the current file name
$current_page = basename($_SERVER['PHP_SELF']);
$addskpages = ['SKChairman.php', 'add_sk_interface.php']; // Add all relevant pages here
?>

<a href="#" class="brand">
    <img src="logo.png" alt="Logo" class="brand-image" style="width:180px;">
</a>
<ul class="side-menu top">
    <li class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">
        <a href="dashboard.php">
            <i class='bx bxs-dashboard'></i>
            <span class="text">Dashboard</span>
        </a>
    </li>
    <li class="<?php echo in_array($current_page, $addskpages) ? 'active' : ''; ?>">
        <a href="SKChairman.php">
            <i class='bx bxs-shopping-bag-alt'></i>
            <span class="text">SK Chairman</span>
        </a>
    </li>
    <li class="<?php echo $current_page == 'Docu.php' ? 'active' : ''; ?>">
        <a href="Docu.php">
            <i class='bx bxs-message-dots'></i>
            <span class="text">Document Management</span>
        </a>
    </li>
    <li class="<?php echo $current_page == 'Budget.php' ? 'active' : ''; ?>">
        <a href="Budget.php">
            <i class='bx bxs-doughnut-chart'></i>
            <span class="text">Budget Allocation</span>
        </a>
    </li>
    <li class="<?php echo $current_page == 'Program.php' ? 'active' : ''; ?>">
        <a href="Program.php">
            <i class='bx bxs-group'></i>
            <span class="text">Program Recommendation</span>
        </a>
    </li>
</ul>
<ul class="side-menu">
    <li>
        <a href="index.php" class="logout">
            <i class='bx bxs-log-out-circle'></i>
            <span class="text">Logout</span>
        </a>
    </li>
</ul>
