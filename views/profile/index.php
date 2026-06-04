<?php

$pageTitle = "My Profile";

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
My Profile
</h3>

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>

<th>ID</th>

<td>
<?= $user["id"] ?>
</td>

</tr>

<tr>

<th>Name</th>

<td>
<?= htmlspecialchars($user["name"]) ?>
</td>

</tr>

<tr>

<th>Role</th>

<td>
<?= htmlspecialchars($user["role"]) ?>
</td>

</tr>

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