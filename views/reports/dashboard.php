<?php

$pageTitle = "Reports Dashboard";

require_once __DIR__
. "/../partials/header.php";

require_once __DIR__
. "/../partials/navbar.php";

require_once __DIR__
. "/../partials/sidebar.php";
?>

<div class="content-wrapper">

<section class="content p-3">

<div class="container-fluid">

<div class="row">

<div class="col-lg-3">

<div class="small-box bg-info">

<div class="inner">

<h3>
<?= $stats["total_users"] ?>
</h3>

<p>Total Users</p>

</div>

<div class="icon">
<i class="fas fa-users"></i>
</div>

</div>

</div>

<div class="col-lg-3">

<div class="small-box bg-success">

<div class="inner">

<h3>
<?= $stats["total_doctors"] ?>
</h3>

<p>Total Doctors</p>

</div>

<div class="icon">
<i class="fas fa-user-md"></i>
</div>

</div>

</div>

<div class="col-lg-3">

<div class="small-box bg-warning">

<div class="inner">

<h3>
<?= $stats["total_appointments"] ?>
</h3>

<p>Appointments</p>

</div>

<div class="icon">
<i class="fas fa-calendar"></i>
</div>

</div>

</div>

<div class="col-lg-3">

<div class="small-box bg-danger">

<div class="inner">

<h3>
<?= $stats["total_prescriptions"] ?>
</h3>

<p>Prescriptions</p>

</div>

<div class="icon">
<i class="fas fa-file-medical"></i>
</div>

</div>

</div>

</div>

<div class="card">

<div class="card-header">

<h3>
Appointments Per Doctor
</h3>

</div>

<div class="card-body">

<table class="table table-bordered">

<thead>

<tr>

<th>Doctor</th>
<th>Total Appointments</th>

</tr>

</thead>

<tbody>

<?php foreach (
$doctorStats
as $doctor
): ?>

<tr>

<td>
<?= sanitize(
$doctor["doctor_name"]
) ?>
</td>

<td>
<?= $doctor["total_appointments"] ?>
</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

</div>

<div class="card">

<div class="card-header">

<h3>
Monthly Revenue
</h3>

<div class="card-tools">

<a
href="index.php?page=reports&action=export"
class="btn btn-success btn-sm">

Export CSV

</a>

</div>

</div>

<div class="card-body">

<table class="table table-bordered">

<thead>

<tr>

<th>Month</th>
<th>Revenue</th>

</tr>

</thead>

<tbody>

<?php foreach (
$revenue
as $item
): ?>

<tr>

<td>
<?= sanitize(
$item["month"]
) ?>
</td>

<td>
$<?= number_format(
$item["revenue"],
2
) ?>
</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

</div>

</div>

</section>

</div>

<?php
require_once __DIR__
. "/../partials/footer.php";
?>