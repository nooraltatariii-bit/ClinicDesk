<?php

$pageTitle = "My Appointments";

require_once __DIR__
. "/../partials/header.php";

require_once __DIR__
. "/../partials/navbar.php";

require_once __DIR__
. "/../partials/sidebar.php";
?>

<div class="content-wrapper">

<section class="content p-3">

<div class="card">

<div class="card-header">

<h3>
My Appointments
</h3>

<div class="card-tools">

<a
href="index.php?page=appointments&action=create"
class="btn btn-primary btn-sm">

Book Appointment

</a>

</div>

</div>

<div class="card-body">

<table class="table table-bordered">

<thead>

<tr>

<th>Doctor</th>
<th>Specialization</th>
<th>Date</th>
<th>Time</th>
<th>Status</th>
<th>Reason</th>

</tr>

</thead>

<tbody>

<?php foreach (
$appointments
as $appointment
): ?>

<tr>

<td>
<?= sanitize(
$appointment["doctor_name"]
) ?>
</td>

<td>
<?= sanitize(
$appointment["specialization_name"]
) ?>
</td>

<td>
<?= formatDate(
$appointment["appt_date"]
) ?>
</td>

<td>
<?= formatTime(
$appointment["appt_time"]
) ?>
</td>

<td>

<?php

$status =
$appointment["status"];

$badge = "secondary";

if ($status === "pending") {
    $badge = "warning";
}

elseif ($status === "confirmed") {
    $badge = "info";
}

elseif ($status === "completed") {
    $badge = "success";
}

elseif ($status === "cancelled") {
    $badge = "danger";
}

?>

<span class="badge badge-<?= $badge ?>">

<?= ucfirst($status) ?>

</span>

</td>

<td>
<?= sanitize(
$appointment["reason"]
) ?>
</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

</div>

</section>

</div>

<?php
require_once __DIR__
. "/../partials/footer.php";
?>