<?php

Auth::requireRole("admin");

$pageTitle = "System Logs";

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
System Logs
</h3>

</div>

<div class="card-body">

<table class="table table-bordered">

<thead>

<tr>

<th>User</th>

<th>Action</th>

<th>Date</th>

</tr>

</thead>

<tbody>

<?php foreach ($logs as $log): ?>

<tr>

<td>
<?= htmlspecialchars($log["name"]) ?>
</td>

<td>
<?= htmlspecialchars($log["action"]) ?>
</td>

<td>
<?= $log["created_at"] ?>
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