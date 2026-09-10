<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/** @var array<int,array<string,mixed>> $products */
/** @var string|null $username */
?>
<?php require APP_DIR . 'views/layouts/header.php'; ?>
<main>
    <div class="actions products-heading" style="justify-content:space-between; margin-bottom:28px">
        <div><p class="notice">INVENTORY / <?= count($products) ?> ITEMS</p><h1>Products</h1><p class="lede">Keep the catalog current, clear, and ready to ship.</p></div>
        <a class="button" href="<?= (string) site_url('products/create') ?>">+ Add product</a>
    </div>
    <section class="panel">
        <?php if (!$products): ?><p class="notice">No products yet. Add the first item to begin.</p><?php else: ?>
        <table><thead><tr><th>Product</th><th>Description</th><th>Price</th><th>Quantity</th><th>Created</th><th></th></tr></thead><tbody>
        <?php foreach ($products as $product): ?><tr>
            <td><strong><?= (string) html_escape($product['product_name']) ?></strong></td>
            <td><?= nl2br((string) html_escape($product['description'])) ?></td>
            <td>$<?= number_format((float) $product['price'], 2) ?></td>
            <td><?= (int) $product['quantity'] ?></td>
            <td><?= (string) html_escape($product['created_at']) ?></td>
            <td><div class="table-actions"><a href="<?= (string) site_url('products/edit/' . (int) $product['id']) ?>">Edit</a><form class="inline" method="post" action="<?= (string) site_url('products/delete/' . (int) $product['id']) ?>" onsubmit="return confirm('Delete this product?');"><?= (string) csrf_field() ?><button class="danger" type="submit">Delete</button></form></div></td>
        </tr><?php endforeach; ?></tbody></table>
        <?php endif; ?>
    </section>
</main>
<?php require APP_DIR . 'views/layouts/footer.php'; ?>