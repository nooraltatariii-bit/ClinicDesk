<?php

$pageTitle = "Prescriptions";

require_once __DIR__ . "/../partials/header.php";
require_once __DIR__ . "/../partials/navbar.php";
require_once __DIR__ . "/../partials/sidebar.php";
?>

<div class="content-wrapper">
    <section class="content p-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3>Prescriptions</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Patient</th>
                                <th>Diagnosis</th>
                                <th>Medications</th>
                                <th class="text-center">Actions</th> </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($prescriptions) && is_array($prescriptions) && !empty($prescriptions)): ?>
                                <?php foreach ($prescriptions as $p): ?>
                                    <tr>
                                        <td>
                                            <?= htmlspecialchars($p["id"]) ?>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($p["patient_name"] ?? 'Unknown') ?>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($p["diagnosis"]) ?>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($p["medications"]) ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if (!empty($p['file_path'])): ?>
                                                <a href="index.php?page=prescriptions/download&id=<?= $p['id'] ?>" class="btn btn-sm btn-primary">
                                                    Download PDF
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">No File</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No prescriptions found.</td>
                                </tr>
                            <?php endif; ?>
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