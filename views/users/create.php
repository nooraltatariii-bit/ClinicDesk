<?php

$pageTitle = "Create User";

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

    <h3>Create User</h3>

</div>

<div class="card-body">

<form
method="POST"
action="index.php?page=users&action=store">

<input
type="hidden"
name="csrf_token"
value="<?= CSRF::generateToken() ?>">

<div class="mb-3">

<label>Name</label>

<input
type="text"
name="name"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Password</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Phone</label>

<input
type="text"
name="phone"
class="form-control">

</div>

<div class="mb-3">

<label>Role</label>

<select
name="role"
class="form-control">

<option value="patient">
    Patient
</option>

<option value="doctor">
    Doctor
</option>

<option value="admin">
    Admin
</option>

</select>

</div>

<button class="btn btn-success">

Save User

</button>

</form>

</div>

</div>

</section>

</div>

<?php
require_once __DIR__
. "/../partials/footer.php";
?>