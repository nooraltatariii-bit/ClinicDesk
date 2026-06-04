<?php
$pageTitle = "Doctors";

require_once __DIR__ . "/../partials/header.php";
require_once __DIR__ . "/../partials/navbar.php";
require_once __DIR__ . "/../partials/sidebar.php";
?>

<div class="content-wrapper">
    <section class="content p-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Doctors</h3>
                <div class="card-tools">
                    <a href="index.php?page=doctors&action=create" class="btn btn-primary btn-sm">
                        Add Doctor
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Specialization</th>
                            <th>Fee</th>
                            <th>Available Days</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (($doctors ?? []) as $doctor): ?>
                            <tr>
                                <td>
                                    <?php if ($doctor["photo"]): ?>
                                        <img src="<?= $doctor["photo"] ?>" 
                                             width="60" 
                                             height="60" 
                                             style="object-fit:cover; border-radius:50%;" 
                                             alt="Doctor Photo">
                                    <?php else: ?>
                                        <span class="badge bg-secondary">No Photo</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?= sanitize($doctor["name"]) ?>
                                </td>
                                <td>
                                    <?= sanitize($doctor["email"]) ?>
                                </td>
                                <td>
                                    <?= sanitize($doctor["specialization_name"]) ?>
                                </td>
                                <td>
                                    $<?= $doctor["consultation_fee"] ?>
                                </td>
                                <td>
                                    <?= sanitize($doctor["available_days"]) ?>
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
require_once __DIR__ . "/../partials/footer.php";
?>