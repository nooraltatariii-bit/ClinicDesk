<?php

Auth::requireRole("admin");

$pageTitle = "All Appointments";

require_once __DIR__ . "/../partials/header.php";
require_once __DIR__ . "/../partials/navbar.php";
require_once __DIR__ . "/../partials/sidebar.php";
?>

<div class="content-wrapper">
    <section class="content p-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Appointments</h3>
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
                                <td><?= $appt["id"] ?></td>
                                <td><?= htmlspecialchars($appt["patient_name"]) ?></td>
                                <td><?= htmlspecialchars($appt["doctor_name"]) ?></td>
                                <td><?= $appt["appt_date"] ?></td>
                                <td><?= $appt["appt_time"] ?></td>
                                <td>
                                    <?php if ($appt["status"] === "pending"): ?>
                                        <span class="badge badge-warning">Pending</span>
                                    <?php elseif ($appt["status"] === "confirmed"): ?>
                                        <span class="badge badge-success">Confirmed</span>
                                    <?php elseif ($appt["status"] === "completed"): ?>
                                        <span class="badge badge-primary">Completed</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Cancelled</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form method="POST" action="index.php?page=appointments&action=updateStatus">
                                        
<?php
require_once __DIR__ . '/../../core/CSRF.php';

$token = '';
if (class_exists('CSRF') && method_exists('CSRF', 'generateToken')) {
    $token = CSRF::generateToken();
}
?>
<input type="hidden" name="csrf_token" value="<?=$token?>">
                                        <input type="hidden" name="csrf_token" value="<?= $token ?>">
                                        <input type="hidden" name="id" value="<?= $appt["id"] ?>">

                                        <select name="status" class="form-control mb-2">
                                            <option value="pending" <?= ($appt["status"] == "pending") ? "selected" : "" ?>>Pending</option>
                                            <option value="confirmed" <?= ($appt["status"] == "confirmed") ? "selected" : "" ?>>Confirmed</option>
                                            <option value="completed" <?= ($appt["status"] == "completed") ? "selected" : "" ?>>Completed</option>
                                            <option value="cancelled" <?= ($appt["status"] == "cancelled") ? "selected" : "" ?>>Cancelled</option>
                                        </select>

                                        <?php $notes = isset($appt["doctor_notes"]) ? $appt["doctor_notes"] : ""; ?>
                                        <textarea name="doctor_notes" class="form-control mb-2" placeholder="Notes"><?= htmlspecialchars($notes) ?></textarea>

                                        <button type="submit" class="btn btn-sm btn-primary mb-2">Update</button>
                                    </form>

                                    <a href="index.php?page=prescriptions&action=create&appointment_id=<?= $appt["id"] ?>" class="btn btn-sm btn-success">
                                        Add Prescription
                                    </a>
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
require_once __DIR__ . "/../partials/footer.php";
?>