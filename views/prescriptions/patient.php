<?php

$pageTitle = "My Prescriptions";

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
My Prescriptions
</h3>

</div>

<div class="card-body">

<table class="table table-bordered">

<thead>

<tr>

<th>Doctor</th>
<th>Date</th>
<th>Diagnosis</th>
<th>Medications</th>
<th>PDF</th>

</tr>

</thead>

<tbody>

<?php foreach (
$prescriptions
as $prescription
): ?>

<tr>

<td>
<?= sanitize(
$prescription["doctor_name"]
) ?>
</td>

<td>
<?= formatDate(
$prescription["appt_date"]
) ?>
</td>

<td>
<?= sanitize(
$prescription["diagnosis"]
) ?>
</td>

<td>
<?= sanitize(
$prescription["medications"]
) ?>
</td>

<td>

<?php if (
$prescription["file_path"]
): ?>

<a
href="index.php?page=prescriptions&action=download&id=<?= $prescription["id"] ?>"
class="btn btn-info btn-sm">

Download PDF

</a>

<?php endif; ?>

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