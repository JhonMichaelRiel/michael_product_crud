<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/** @var string|null $error */
?>
<?php require APP_DIR . 'views/layouts/header.php'; ?>
<main class="form-wrap">
    <div class="panel">
        <h1>Welcome back.</h1>
        <p class="lede">Sign in to manage the product catalog.</p>
        <?php if ($error): ?><div class="error"><?= (string) html_escape($error) ?></div><?php endif; ?>
        <form method="post" action="<?= (string) site_url('login') ?>">
            <?= (string) csrf_field() ?>
            <label for="login">Email or username</label>
            <input id="login" name="login" required autocomplete="username">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required autocomplete="current-password">
            <p class="actions"><button class="button" type="submit">Sign in</button><a class="button quiet" href="<?= (string) site_url('signup') ?>">Create account</a></p>
        </form>
    </div>
</main>
<?php require APP_DIR . 'views/layouts/footer.php'; ?>