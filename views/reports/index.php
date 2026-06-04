<?php

Auth::requireRole("admin");

$pageTitle = "Reports";

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

<!-- Statistics Cards -->

<div class="row">

<div class="col-lg-3 col-6">

<div class="small-box bg-info">

<div class="inner">

<h3>
<?= $stats["users"] ?>
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
<?= $stats["doctors"] ?>
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
<?= $stats["appointments"] ?>
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
<?= $stats["prescriptions"] ?>
</h3>

<p>Prescriptions</p>

</div>

<div class="icon">

<i class="fas fa-file-medical"></i>

</div>

</div>

</div>

</div>

<!-- Export Button -->

<div class="mb-4">

<a
href="index.php?page=reports&action=export"
class="btn btn-primary">

Export CSV

</a>

</div>

<!-- Chart Card -->

<div class="card">

<div class="card-header">

<h3 class="card-title">

System Statistics

</h3>

</div>

<div class="card-body">

<div style="height: 350px;">

<canvas id="statsChart"></canvas>

</div>

</div>

</div>

</div>

</section>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx =
document.getElementById('statsChart');

new Chart(ctx, {

type: 'bar',

data: {

labels: [

'Users',
'Doctors',
'Appointments',
'Prescriptions'

],

datasets: [{

label: 'System Statistics',

data: [

<?= $stats["users"] ?>,

<?= $stats["doctors"] ?>,

<?= $stats["appointments"] ?>,

<?= $stats["prescriptions"] ?>

],

backgroundColor: [

'rgba(23, 162, 184, 0.2)',

'rgba(40, 167, 69, 0.2)',

'rgba(255, 193, 7, 0.2)',

'rgba(220, 53, 69, 0.2)'

],

borderColor: [

'rgba(23, 162, 184, 1)',

'rgba(40, 167, 69, 1)',

'rgba(255, 193, 7, 1)',

'rgba(220, 53, 69, 1)'

],

borderWidth: 1

}]
},

options: {

responsive: true,

maintainAspectRatio: false,

scales: {

y: {

beginAtZero: true

}

}

}

});

</script>

<?php

require_once __DIR__
. "/../partials/footer.php";

?>