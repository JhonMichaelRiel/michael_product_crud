<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/** @var array<string,mixed>|null $product */
/** @var string $title */
/** @var string $action */
/** @var array<int,string> $errors */
?>
<?php require APP_DIR . 'views/layouts/header.php'; ?>
<main class="form-wrap">
    <div class="panel">
        <p class="notice">INVENTORY / <?= $product ? 'EDIT ITEM' : 'NEW ITEM' ?></p>
        <h1><?= (string) html_escape($title) ?></h1>
        <p class="lede">Enter the product details below.</p>
        <?php if ($errors): ?><div class="error"><ul><?php foreach ($errors as $error): ?><li><?= (string) html_escape($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
        <form method="post" action="<?= (string) site_url($action) ?>">
            <?= (string) csrf_field() ?>
            <label for="product_name">Product name</label>
            <input id="product_name" name="product_name" maxlength="100" required value="<?= (string) html_escape($product['product_name'] ?? '') ?>">
            <label for="description">Description</label>
            <textarea id="description" name="description"><?= (string) html_escape($product['description'] ?? '') ?></textarea>
            <label for="price">Price</label>
            <input id="price" name="price" type="number" min="0" step="0.01" required value="<?= (string) html_escape($product['price'] ?? '') ?>">
            <label for="quantity">Quantity</label>
            <input id="quantity" name="quantity" type="number" min="0" step="1" required value="<?= (string) html_escape($product['quantity'] ?? '') ?>">
            <p class="actions"><button class="button" type="submit">Save product</button><a class="button quiet" href="<?= (string) site_url('products') ?>">Cancel</a></p>
        </form>
    </div>
</main>
<?php require APP_DIR . 'views/layouts/footer.php'; ?>