<?php 
require_once 'core/Auth.php';
$role = Auth::role(); ?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a
    href="index.php?page=dashboard"
    class="brand-link">

        <span class="brand-text font-weight-light">
            ClinicDesk
        </span>

    </a>

    <div class="sidebar">

        <nav class="mt-2">

            <ul
            class="nav nav-pills nav-sidebar flex-column"
            data-widget="treeview"
            role="menu">

                <li class="nav-item">

                    <a
                    href="index.php?page=dashboard"
                    class="nav-link">

                        <i class="nav-icon fas fa-home"></i>

                        <p>Dashboard</p>

                    </a>

                </li>

                <?php if ($role === "admin"): ?>

                    <li class="nav-item">

                        <a
                        href="index.php?page=users"
                        class="nav-link">

                            <i class="nav-icon fas fa-users"></i>

                            <p>Users</p>

                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                        href="index.php?page=doctors"
                        class="nav-link">

                            <i class="nav-icon fas fa-user-md"></i>

                            <p>Doctors</p>

                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                        href="index.php?page=reports"
                        class="nav-link">

                            <i class="nav-icon fas fa-chart-bar"></i>

                            <p>Reports</p>

                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                        href="index.php?page=logs"
                        class="nav-link">

                            <i class="nav-icon fas fa-history"></i>

                            <p>Logs</p>

                        </a>

                    </li>
                    <?php endif; ?>

                <li class="nav-item">

                    <a
                    href="index.php?page=appointments"
                    class="nav-link">

                        <i class="nav-icon fas fa-calendar"></i>

                        <p>Appointments</p>

                    </a>

                </li>

                <li class="nav-item">

                    <a
                    href="index.php?page=prescriptions"
                    class="nav-link">

                        <i class="nav-icon fas fa-file-medical"></i>

                        <p>Prescriptions</p>

                    </a>

                </li>

                <li class="nav-item">

                    <a
                    href="index.php?page=profile"
                    class="nav-link">

                        <i class="nav-icon fas fa-user-circle"></i>

                        <p>My Profile</p>

                    </a>

                </li>

                <li class="nav-item">

                    <a
                    href="index.php?page=logout"
                    class="nav-link text-danger">

                        <i class="nav-icon fas fa-sign-out-alt"></i>

                        <p>Logout</p>

                    </a>

                </li>

            </ul>

        </nav>

    </div>

</aside>