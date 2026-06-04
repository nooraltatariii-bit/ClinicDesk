<?php

$pageTitle = "Create Doctor";

require_once __DIR__ . "/../partials/header.php";
require_once __DIR__ . "/../partials/navbar.php";
require_once __DIR__ . "/../partials/sidebar.php";
?>

<div class="content-wrapper">
    <section class="content p-3">
        <div class="card">
            <div class="card-header">
                <h3>Create Doctor</h3>
            </div>

            <div class="card-body">
                <form method="POST" enctype="multipart/form-data" action="index.php?page=doctors&action=store">
                    
                    <input type="hidden" name="csrf_token" value="<?= CSRF::generateToken() ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                    </div>

                    <br>

                    <label>Specialization</label>
                    <select name="specialization_id" class="form-control">
                        <?php foreach ($specializations as $specialization): ?>
                            <option value="<?= $specialization["id"] ?>">
                                <?= sanitize($specialization["name"]) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <br>

                    <label>Consultation Fee</label>
                    <input type="number" step="0.01" name="consultation_fee" class="form-control">

                    <br>

                    <label>Available Days</label>
                    <br>
                    <?php $days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"]; ?>
                    <?php foreach ($days as $day): ?>
                        <label class="mr-2">
                            <input type="checkbox" name="available_days[]" value="<?= $day ?>">
                            <?= $day ?>
                        </label>
                    <?php endforeach; ?>

                    <br><br>

                    <label>Bio</label>
                    <textarea name="bio" class="form-control"></textarea>

                    <br>

                    <div class="form-group">
                        <label>Doctor Photo</label>
                        <input type="file" name="photo" class="form-control">
                    </div>

                    <br>

                    <button class="btn btn-success">
                        Save Doctor
                    </button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php
require_once __DIR__ . "/../partials/footer.php";
?>