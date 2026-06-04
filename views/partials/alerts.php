<?php if (
isset($_SESSION["flash"])
): ?>

<div class="alert alert-<?=
$_SESSION["flash"]["type"]
?>">

    <?=
    sanitize(
        $_SESSION["flash"]["message"]
    )
    ?>

</div>

<?php unset($_SESSION["flash"]); ?>

<?php endif; ?>