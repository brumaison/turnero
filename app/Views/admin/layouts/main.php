<?php
// app/Views/admin/layouts/main.php
require __DIR__ . '/partials/header.php';
echo $content ?? '';
require __DIR__ . '/partials/footer.php';