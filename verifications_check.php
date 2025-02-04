<?php
require_once './include/page.php';

$page = new Page("verification_check");

$id = (isset($_GET["id"]) ? $_GET["id"] : -1);
$uuid = (isset($_GET["uuid"]) ? $_GET["uuid"] : null);
if($uuid != null){
    // add '-' to have real UUID
    if(!(preg_match("/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i", $uuid))){
        $nextUUID = "";
        $i = 1;
        foreach (str_split($uuid) as $char) {
            $nextUUID .= $char;
            if($i == 8 || $i == 12 || $i == 16 || $i == 20)
                $nextUUID .= "-";
            $i++;
        }
        $uuid = $nextUUID;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php $page->print_common_head(); ?>
    <title>Positivity - Verifications</title>
</head>
<body>
	<div class="page-wrapper">
        <?php $page->show_header(); ?>

        <div class="content-wrapper">
        
        <?php
        if($id == -1 && $uuid == null){
            ?>
            <div class="container">
                <h1><?php echo $page->msg("error.not_found.verifications"); ?></h1>
            </div>
            <?php
        } else {
            $stVerif = null;
            $request = "";
            if($id != -1){
                $stVerif = $page->conn->prepare("SELECT * FROM negativity_verifications WHERE id = ?;");
                $stVerif->execute(array($id));
            } else if($uuid != null){
                $stVerif = $page->conn->prepare("SELECT * FROM negativity_verifications WHERE uuid = ?;");
                $stVerif->execute(array($uuid));
            }
            $allRowVerif = $stVerif->fetchAll(PDO::FETCH_ASSOC);
            $stVerif->closeCursor();

            if(count($allRowVerif) == 0){
                ?>
                <div class="container">
                    <h1><?php echo $page->msg("error.not_found.verifications"); ?></h1>
                </div>
                <?php
            } else {
                echo '<div class="container"><table>';
                ?>
                <thead>
                    <tr>
                        <th style="width: 10%"><?php echo $page->msg("column.name"); ?></th>
                        <th style="width: 10%"><?php echo $page->msg("column.started_by"); ?></th>
                        <th style="width: 50%"><?php echo $page->msg("verifications.result"); ?></th>
                    </tr>
                </thead>
                <?php
                foreach ($allRowVerif as $rowVerif) {
                    ?>
                    <tr>
                        <td rowspan=1><?php echo $page->get_avatar($page->get_name($rowVerif["uuid"]), $rowVerif["uuid"]); ?></td>
                        <td rowspan=1><?php echo $page->get_avatar($rowVerif["startedBy"], $page->get_uuid($rowVerif["startedBy"])); ?></td>
                        <td rowspan=2><?php echo str_replace("\n", "<br>", $page->addColorFromResult($rowVerif["result"])); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $page->parse_version_name($rowVerif["player_version"]); ?></td>
                        <td><?php echo strtolower($rowVerif["creation_time"]); ?></td>
                    </tr>
                    <?php
                }
                echo '</table></div><br/>';
                $page->show_footer(); 
            }
        }
        ?>
        </div>
    </div>
</body>
</html>