<?php

$pageTitle = "Book Appointment";

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

    <h3>Book Appointment</h3>

</div>

<div class="card-body">

<form
method="POST"
action="index.php?page=appointments&action=store">

<input
type="hidden"
name="csrf_token"
value="<?= CSRF::generateToken() ?>">

<label>Doctor</label>

<select
name="doctor_id"
class="form-control">

<?php foreach ($doctors as $doctor): ?>

<option
value="<?= $doctor["id"] ?>">

<?= sanitize(
$doctor["name"]
) ?>

-
<?= sanitize(
$doctor["specialization_name"]
) ?>

</option>

<?php endforeach; ?>

</select>

<br>

<label>Date</label>

<input
type="date"
name="appt_date"
class="form-control"
required>

<br>

<label>Time</label>

<select
name="appt_time"
class="form-control">

<?php

$slots = [

"09:00",
"09:30",
"10:00",
"10:30",
"11:00",
"11:30",
"12:00",
"13:00",
"14:00",
"15:00",
"16:00"

];

?>

<?php foreach ($slots as $slot): ?>

<option value="<?= $slot ?>">

<?= $slot ?>

</option>

<?php endforeach; ?>

</select>

<br>

<label>Reason</label>

<textarea
name="reason"
class="form-control"></textarea>

<br>

<button class="btn btn-primary">

Book Appointment

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