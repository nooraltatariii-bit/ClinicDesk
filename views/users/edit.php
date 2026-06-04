<?php

Auth::requireRole("admin");

$pageTitle = "Edit User";

require_once __DIR__ . "/../partials/header.php";
require_once __DIR__ . "/../partials/navbar.php";
require_once __DIR__ . "/../partials/sidebar.php";

// تضمين كلاس الحماية بالمسار الصحيح
require_once __DIR__ . "/../../core/CSRF.php";
?>

<div class="content-wrapper">
    <section class="content p-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3>Edit User</h3>
                </div>

                <div class="card-body">
                    <?php require_once __DIR__ . "/../partials/alerts.php"; ?>

                    <form method="POST" action="index.php?page=users&action=update">

                        <input type="hidden" name="csrf_token" value="<?= CSRF::generateToken() ?>">
                        <input type="hidden" name="id" value="<?= $user["id"] ?>">

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user["name"]) ?>">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user["email"]) ?>">
                        </div>

                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user["phone"]) ?>">
                        </div>

                        <div class="form-group">
                            <label>Role</label>
                            <select name="role" class="form-control">
                                <option value="admin" <?= $user["role"] === "admin" ? "selected" : "" ?>>Admin</option>
                                <option value="doctor" <?= $user["role"] === "doctor" ? "selected" : "" ?>>Doctor</option>
                                <option value="patient" <?= $user["role"] === "patient" ? "selected" : "" ?>>Patient</option>
                            </select>
                        </div>

                        <button class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
require_once __DIR__ . "/../partials/footer.php";
?>