<?php
require_once './include/page.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Negativity - Bans</title>
    <link href="./include/css/main.css" rel="stylesheet">
</head>
<body>
    <?php

    $page = new Page("ban");

    $page->show_header();

    $rows = $page->run_query();
    foreach ($rows as $row) {
        $player_name = $page->get_name($row["id"]);
        if ($player_name === null)
            continue;
        $page->print_row($row);
    }

    $page->show_page_mover();

    $page->show_footer();
    ?>
</body>
</html>