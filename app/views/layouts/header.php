<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/** @var string|null $title */
/** @var string|null $username */
/** @var bool $auth_page */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= (string) html_escape($title ?? 'Product Desk') ?></title>
    <style>
        :root { --ink:#eaf3ff; --muted:#9db2cc; --paper:#071321; --panel:#10243b; --accent:#4f9cff; --accent-bright:#79b8ff; --line:#294766; --green:#2f729f; }
        * { box-sizing:border-box; } body { margin:0; background:radial-gradient(circle at 12% 0%,#173b62 0%,transparent 42%),linear-gradient(135deg,#071321 0%,#0d2036 55%,#050c16 100%); color:var(--ink); font:16px/1.5 Georgia,serif; min-height:100vh; }
        body::before { content:''; position:fixed; inset:0; pointer-events:none; opacity:.2; background-image:linear-gradient(rgba(121,184,255,.08) 1px,transparent 1px),linear-gradient(90deg,rgba(121,184,255,.08) 1px,transparent 1px); background-size:44px 44px; mask-image:linear-gradient(to bottom,black,transparent 72%); }
        a { color:inherit; } .shell { max-width:1080px; margin:auto; padding:28px 22px 60px; } .topbar { display:flex; justify-content:space-between; align-items:center; gap:20px; border:1px solid var(--line); border-radius:8px; padding:14px 18px; margin-bottom:38px; background:rgba(9,25,43,.78); box-shadow:0 12px 30px rgba(0,0,0,.18); }
        .brand { text-decoration:none; font:700 22px/1.1 Georgia,serif; letter-spacing:.02em; } .brand span { color:var(--accent-bright); } nav { display:flex; align-items:center; gap:16px; color:var(--muted); } nav a { text-decoration:none; } nav a:hover { color:var(--accent-bright); }
        .button { display:inline-block; border:0; background:var(--accent); color:#061321; padding:11px 16px; text-decoration:none; cursor:pointer; font:600 15px Georgia,serif; border-radius:6px; box-shadow:0 6px 16px rgba(79,156,255,.2); } .button:hover { background:var(--accent-bright); } .button.secondary { background:var(--green); color:#fff; } .button.quiet { background:transparent; color:var(--ink); border:1px solid var(--line); box-shadow:none; }
        h1 { font-size:clamp(30px,4vw,46px); line-height:1.05; margin:0 0 10px; } h2 { margin-top:0; } .lede { color:var(--muted); margin:0 0 28px; }
        .products-heading { position:relative; padding:22px 0 14px; }
        .products-heading h1 { font-size:clamp(38px,6vw,68px); letter-spacing:.01em; }
        .products-heading .notice { color:var(--accent-bright); font-weight:bold; letter-spacing:.12em; }
        .products-heading .lede { max-width:500px; font-size:18px; }
        .products-heading > .button { align-self:flex-end; }
        .panel { background:rgba(16,36,59,.94); border:1px solid var(--line); padding:24px; border-radius:8px; box-shadow:0 18px 48px rgba(0,0,0,.3); } .actions { display:flex; gap:10px; align-items:center; flex-wrap:wrap; }
        label { display:block; font-weight:bold; margin:16px 0 6px; } input, textarea { width:100%; border:1px solid #365b7e; border-radius:6px; background:#091a2d; padding:12px; font:16px Georgia,serif; color:var(--ink); } input:focus, textarea:focus { outline:2px solid var(--accent); border-color:var(--accent); } textarea { min-height:110px; resize:vertical; } .form-wrap { max-width:680px; margin:auto; }
        .error { background:#3b202b; color:#ffc7cf; border-left:4px solid #e27d91; padding:10px 14px; margin:0 0 16px; } .notice { color:var(--muted); }
        table { width:100%; border-collapse:collapse; } th,td { text-align:left; padding:15px 12px; border-bottom:1px solid var(--line); vertical-align:top; } th { color:var(--muted); font-size:13px; text-transform:uppercase; letter-spacing:.08em; } .table-actions { display:flex; gap:8px; } .inline { display:inline; } .danger { color:#ff9eae; background:none; border:0; padding:0; cursor:pointer; font:inherit; }
        .auth-page .shell { max-width:680px; padding-top:48px; }
        .auth-page .topbar { display:none; }
        body.auth-page { display:flex; align-items:center; justify-content:center; padding:24px; }
        .auth-page .shell { width:100%; margin:0; padding:0; }
        @media(max-width:700px) {
            .shell { padding:20px 14px 40px; }
            .topbar { align-items:flex-start; flex-direction:column; margin-bottom:26px; }
            nav { flex-wrap:wrap; gap:10px 14px; font-size:14px; }
            .actions { align-items:flex-start; }
            .actions > div { width:100%; }
            .actions > .button { width:100%; text-align:center; }
            .products-heading { padding-top:8px; }
            .products-heading h1 { font-size:40px; }
            .panel { padding:14px; overflow:visible; }
            table, tbody, tr, td { display:block; }
            thead { display:none; }
            tr { background:rgba(16,36,59,.94); border:1px solid var(--line); border-radius:6px; padding:10px 13px; margin-bottom:12px; }
            td { display:flex; justify-content:space-between; gap:14px; padding:8px 0; border-bottom:1px solid rgba(73,52,94,.65); text-align:right; overflow-wrap:anywhere; }
            td::before { color:var(--muted); content:''; font-size:12px; font-weight:bold; letter-spacing:.06em; text-align:left; text-transform:uppercase; }
            td:nth-child(1)::before { content:'Product'; }
            td:nth-child(2)::before { content:'Description'; }
            td:nth-child(3)::before { content:'Price'; }
            td:nth-child(4)::before { content:'Quantity'; }
            td:nth-child(5)::before { content:'Created'; }
            td:last-child { border-bottom:0; padding-top:12px; }
            td:last-child::before { content:''; }
            .table-actions { width:100%; justify-content:flex-end; }
        }
    </style>
</head>
<body class="<?= !empty($auth_page) ? 'auth-page' : '' ?>"><div class="shell">
    <header class="topbar">
        <?php if (!empty($username)): ?><nav><span>Hi, <?= (string) html_escape($username) ?></span><a href="<?= (string) site_url('products') ?>">Products</a><form class="inline" method="post" action="<?= (string) site_url('logout') ?>"><?= (string) csrf_field() ?><button class="danger" type="submit">Log out</button></form></nav><?php endif; ?>
    </header>