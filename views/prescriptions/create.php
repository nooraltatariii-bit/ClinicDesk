<?php

$pageTitle = "Add Prescription";

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
Add Prescription
</h3>

</div>

<div class="card-body">

<form
method="POST"
enctype="multipart/form-data"
action="index.php?page=prescriptions&action=store">

<input
type="hidden"
name="csrf_token"
value="<?= CSRF::generateToken() ?>">

<input
type="hidden"
name="appointment_id"
value="<?= $appointmentId ?>">

<label>Diagnosis</label>

<textarea
name="diagnosis"
class="form-control"
required></textarea>

<br>

<label>Medications</label>

<textarea
name="medications"
class="form-control"
required></textarea>

<br>

<label>Notes</label>

<textarea
name="notes"
class="form-control"></textarea>

<br>

<label>PDF File</label>

<input
type="file"
name="pdf"
class="form-control">

<br>

<button class="btn btn-success">

Save Prescription

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