<?php

$pageTitle = "Prescriptions";

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

<h3>
Prescriptions
</h3>

</div>

<div class="card-body">

<table class="table table-bordered">

<thead>

<tr>

<th>ID</th>

<th>Patient</th>

<th>Diagnosis</th>

<th>Medications</th>

</tr>

</thead>

<tbody>

<?php foreach ($prescriptions as $p): ?>

<tr>

<td>
<?= $p["id"] ?>
</td>

<td>
<?= htmlspecialchars($p["patient_name"]) ?>
</td>

<td>
<?= htmlspecialchars($p["diagnosis"]) ?>
</td>

<td>
<?= htmlspecialchars($p["medications"]) ?>
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