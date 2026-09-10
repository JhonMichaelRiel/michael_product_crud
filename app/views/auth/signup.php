<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/** @var array<string,string> $data */
/** @var array<int,string> $errors */
?>
<?php require APP_DIR . 'views/layouts/header.php'; ?>
<main class="form-wrap">
    <div class="panel">
        <h1>Create account.</h1>
        <p class="lede">Register to open the authenticated product desk.</p>
        <?php if ($errors): ?><div class="error"><ul><?php foreach ($errors as $error): ?><li><?= (string) html_escape($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
        <form method="post" action="<?= (string) site_url('signup') ?>">
            <?= (string) csrf_field() ?>
            <label for="username">Username</label>
            <input id="username" name="username" maxlength="50" required autocomplete="username" value="<?= (string) html_escape($data['username'] ?? '') ?>">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" maxlength="191" required autocomplete="email" value="<?= (string) html_escape($data['email'] ?? '') ?>">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" minlength="8" required autocomplete="new-password">
            <label for="password_confirmation">Confirm password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" minlength="8" required autocomplete="new-password">
            <p class="actions"><button class="button" type="submit">Create account</button><a class="button quiet" href="<?= (string) site_url('login') ?>">Back to login</a></p>
        </form>
    </div>
</main>
<?php require APP_DIR . 'views/layouts/footer.php'; ?>