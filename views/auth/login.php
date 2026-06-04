<?php require_once __DIR__
. "/../partials/header.php"; ?>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-4">

            <div class="card">

                <div class="card-header">
                    Login
                </div>

                <div class="card-body">

                    <?php
                    require_once __DIR__
                    . "/../partials/alerts.php";
                    ?>

                    <form
                    method="POST"
                    action="index.php?page=login&action=login">

                        <input
                        type="hidden"
                        name="csrf_token"
                        value="<?= CSRF::generateToken() ?>">

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

                        <button
                        class="btn btn-primary w-100">

                            Login

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php require_once __DIR__
. "/../partials/footer.php"; ?>