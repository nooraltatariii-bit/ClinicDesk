<?php

Auth::requireRole("admin");

$pageTitle = "All Appointments";

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

<div class="card">

<div class="card-header">

<h3 class="card-title">
All Appointments
</h3>

</div>

<div class="card-body">

<table class="table table-bordered">

<thead>

<tr>

<th>ID</th>

<th>Patient</th>

<th>Doctor</th>

<th>Date</th>

<th>Time</th>

<th>Status</th>

<th>Actions</th>

</tr>

</thead>

<tbody>

<?php foreach ($appointments as $appt): ?>

<tr>

<td>
<?= $appt["id"] ?>
</td>

<td>
<?= htmlspecialchars(
$appt["patient_name"]
) ?>
</td>

<td>
<?= htmlspecialchars(
$appt["doctor_name"]
) ?>
</td>

<td>
<?= $appt["appt_date"] ?>
</td>

<td>
<?= $appt["appt_time"] ?>
</td>

<td>

<?php if (
$appt["status"] === "pending"
): ?>

<span class="badge badge-warning">
Pending
</span>

<?php elseif (
$appt["status"] === "confirmed"
): ?>

<span class="badge badge-success">
Confirmed
</span>

<?php elseif (
$appt["status"] === "completed"
): ?>

<span class="badge badge-primary">
Completed
</span>

<?php else: ?>

<span class="badge badge-danger">
Cancelled
</span>

<?php endif; ?>

</td>

<td>

<form
method="POST"
action="index.php?page=appointments&action=updateStatus">

<input
type="hidden"
name="csrf_token"
value="<?= CSRF::token() ?>">

<input
type="hidden"
name="id"
value="<?= $appt["id"] ?>">

<select
name="status"
class="form-control mb-2">

<option value="pending">
Pending
</option>

<option value="confirmed">
Confirmed
</option>

<option value="completed">
Completed
</option>

<option value="cancelled">
Cancelled
</option>

</select>

<textarea
name="doctor_notes"
class="form-control mb-2"
placeholder="Notes"></textarea>

<button
class="btn btn-sm btn-primary">

Update

</button>

</form>

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