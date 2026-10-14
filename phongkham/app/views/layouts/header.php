<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>

    <?php if (!empty($pageCss)) { ?>
        <!-- CSS riêng của từng trang -->
        <link rel="stylesheet" href="css/pages/<?php echo $pageCss; ?>.css">
    <?php } ?>
</head>

<body>
