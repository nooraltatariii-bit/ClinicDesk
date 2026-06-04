<?php

$pageTitle = "Users";

require_once __DIR__ . "/../partials/header.php";
require_once __DIR__ . "/../partials/navbar.php";
require_once __DIR__ . "/../partials/sidebar.php";

// الخروج مرتين للوصول للمجلد الرئيسي ثم core
require_once __DIR__ . "/../../core/CSRF.php";

// توليد التوكن مرة واحدة في الأعلى
$globalCsrfToken = CSRF::generateToken();

?>

<div class="content-wrapper">
    <section class="content p-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Users</h3>
                    <div class="card-tools">
                        <a href="index.php?page=users&action=create" class="btn btn-primary btn-sm">Add User</a>
                    </div>
                </div>

                <div class="card-body">
                    <?php require_once __DIR__ . "/../partials/alerts.php"; ?>

                    <form method="GET" class="mb-3">
                        <input type="hidden" name="page" value="users">
                        
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search users" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($users)): ?>
                                <tr>
                                    <td colspan="6">No users found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= $user["id"] ?></td>
                                        <td><?= sanitize($user["name"]) ?></td>
                                        <td><?= sanitize($user["email"]) ?></td>
                                        <td><?= sanitize($user["role"]) ?></td>
                                        <td>
                                            <?php if ($user["is_active"]): ?>
                                                <span class="badge badge-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Suspended</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2 align-items-center">
                                                
                                                <a href="index.php?page=users&action=edit&id=<?php echo $user['id']; ?>" class="btn btn-sm btn-warning mr-2">
                                                    Edit
                                                </a>

                                                <form action="index.php?page=users&action=toggle" method="POST" style="display:inline; margin: 0;">
                                                    <input type="hidden" name="csrf_token" value="<?= $globalCsrfToken; ?>">
                                                    <input type="hidden" name="id" value="<?= $user["id"] ?>">
                                                    
                                                    <button type="submit" class="btn btn-sm btn-secondary">
                                                        <?= $user["is_active"] ? "Deactivate" : "Activate" ?>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <nav>
                        <ul class="pagination">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=users&p=<?= $i ?><?= isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '' ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
require_once __DIR__ . "/../partials/footer.php";
?>