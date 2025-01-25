<?php
$current_page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>

<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php?page=dashboard">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">KMJS</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= $current_page == 'dashboard' ? 'active' : '' ?>">
        <a class="nav-link" href="index.php?page=dashboard">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Individual
    </div>

    <!-- Nav Item - Students -->
    <li class="nav-item <?= $current_page == 'students' ? 'active' : '' ?>">
        <a class="nav-link" href="index.php?page=students">
            <i class="fas fa-user-graduate"></i>
            <span>Students</span></a>
    </li>

    <!-- Nav Item - Grades -->
    <li class="nav-item <?= $current_page == 'grades' ? 'active' : '' ?>">
        <a class="nav-link" href="index.php?page=grades">
            <i class="fas fa-graduation-cap"></i>
            <span>Grades</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Courses
    </div>


    <!-- Nav Item - Subjects -->
    <li class="nav-item <?= $current_page == 'subjects' ? 'active' : '' ?>">
        <a class="nav-link" href="index.php?page=subject">
            <i class="fas fa-book"></i>
            <span>Subjects</span></a>
    </li>

    <!-- Nav Item - Courses -->
    <li class="nav-item <?= $current_page == 'courses' ? 'active' : '' ?>">
        <a class="nav-link" href="index.php?page=courses">
            <i class="fas fa-chalkboard-teacher"></i>
            <span>Courses</span></a>
    </li>

    <!-- Nav Item - Year Level -->
    <li class="nav-item <?= $current_page == 'yearlevels' ? 'active' : '' ?>">
        <a class="nav-link" href="index.php?page=yearlevel">
            <i class="fas fa-graduation-cap"></i>
            <span>Year Level</span></a>
    </li>

    <!-- Nav Item - Curriculums -->
    <li class="nav-item <?= $current_page == 'curriculums' ? 'active' : '' ?>">
        <a class="nav-link" href="index.php?page=curriculum">
            <i class="fas fa-scroll"></i>
            <span>Curriculums</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>