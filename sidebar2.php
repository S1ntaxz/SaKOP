<?php
// Get the current file name
$current_page = basename($_SERVER['PHP_SELF']);
?>

<a href="#" class="brand">
    <img src="logo.png" alt="Logo" class="brand-image" style="width:180px;">
</a>
<ul class="side-menu top">
    <li class="<?php echo $current_page == 'SKindex.php' ? 'active' : ''; ?>">
        <a href="SKindex.php">
            <i class='bx bxs-dashboard'></i>
            <span class="text">Dashboard</span>
        </a>
    </li>
    <li class="<?php echo $current_page == 'KKMembers.php' ? 'active' : ''; ?>">
        <a href="KKMembers.php">
            <i class='bx bxs-shopping-bag-alt'></i>
            <span class="text">KK Members</span>
        </a>
    </li>
    <li class="<?php echo $current_page == 'SKBudget.php' ? 'active' : ''; ?>">
        <a href="SKBudget.php">
            <i class='bx bxs-doughnut-chart'></i>
            <span class="text">Budget Allocation</span>
        </a>
    </li>
    <li class="<?php echo $current_page == 'SKDocu.php' ? 'active' : ''; ?>">
        <a href="SKDocu.php">
            <i class='bx bxs-message-dots'></i>
            <span class="text">Document Management</span>
        </a>
    </li>
    <li class="<?php echo $current_page == 'SKProgram.php' ? 'active' : ''; ?>">
        <a href="SKProgram.php">
            <i class='bx bxs-group'></i>
            <span class="text">Program Recommendation</span>
        </a>
    </li>
</ul>
<ul class="side-menu">
    <li class="<?php echo $current_page == 'settings.php' ? 'active' : ''; ?>">
        <a href="settings.php">
            <i class='bx bxs-cog'></i>
            <span class="text">Settings</span>
        </a>
    </li>
    <li>
        <a href="index.php" class="logout">
            <i class='bx bxs-log-out-circle'></i>
            <span class="text">Logout</span>
        </a>
    </li>
</ul>
