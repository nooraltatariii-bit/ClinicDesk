<?php

$pageTitle = "Dashboard";

require_once __DIR__ . "/../partials/header.php";
require_once __DIR__ . "/../partials/navbar.php";
require_once __DIR__ . "/../partials/sidebar.php";

?>

<div class="content-wrapper">

    <section class="content p-3">

        <div class="container-fluid">

            <div class="row">

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>
                                <?= $stats["users"] ?? 0 ?>
                            </h3>
                            <p>Total Users</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>
                                <?= $stats["doctors"] ?? 0 ?>
                            </h3>
                            <p>Total Doctors</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>
                                <?= $stats["appointments"] ?? 0 ?>
                            </h3>
                            <p>Appointments</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>
                                <?= $stats["prescriptions"] ?? 0 ?>
                            </h3>
                            <p>Prescriptions</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-medical"></i>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </section>

</div>

<?php
require_once __DIR__ . "/../partials/footer.php";
?>
