<?php

function show($page) {
    try {
        $st = $page->conn->query("SELECT (SELECT COUNT(*) FROM negativity_bans_active)");
        ($row = $st->fetch(PDO::FETCH_NUM)) or die('Failed to fetch row counts.');
        $st->closeCursor();
        $count = array(
            'bans.php'     => $row[0],
        );
    } catch (PDOException $ex) {
        return header("Location: ./error/no-negativity.php");
        // die ('Erreur : ' . $ex->getMessage());
    }

    $settings = $page->settings;
    ?>
    <header role="banner">
        <div class="sidebar">
            <div class="nav-item">
                <a class="logo" href="<?php echo $settings['link']; ?>">
                    <?php echo $settings["server_name"]; ?>
                </a>
            </div>
            <?php
                echo '<div class="nav-item' . ($page->info->getLink() == "checks" ? " active" : "") .'">';
                echo '<a class="nav-link" href="./">' . $page->msg("title.index") . '</a>';
                echo '</div>';
            ?>
            <!-- <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#negativity-navbar"
                    aria-controls="negativity-navbar" aria-expanded="false" aria-label="Toggle navigation">
            </button> -->
            <?php
            if(isset($_SESSION["name"])){
                foreach ($page->getNavbar() as $key => $value) {
                    echo '<div class="nav-item' . ($page->info == $value ? ' active' : '') . '">
                            <a class="nav-link" href="' . ($value->getLink()) . '">' . $page->msg("title." . $key) . '
                                <span class="number">' . ($value->getNumber()) . '</span>
                            </a>
                        </div>';
                }
            }
            if(isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]){
                echo '<div class="nav-item' . ($page->info->getLink() == "admin" ? " active" : "") .'">';
                echo '<a class="nav-link" href="./admin">' . $page->msg("title.admin") . '</a>';
                echo '</div>';
            }
            ?>
        </div>
        <div class="topbar">
            <?php
            if(isset($_SESSION["name"])){
                ?>
                <div class="nav-item">
                    <form action="./check" method="GET">
                        <div class="search-input">
                            <input class="form-control" type="text" name="search">
                            <button class="btn-outline btn-small"><?php echo $page->msg("title.search"); ?></button>
                        </div>
                    </form>
                </div>
                <div class="nav-item">
                    <span class="input-group-text bg-dark text-white border-0"><?php echo str_replace("%name%", $_SESSION["name"], $page->msg("connection.login_as")); ?></span>
                </div>
                <div class="nav-item">
                    <a href="./deconnection">
                        <button class="btn-outline btn-small"><?php echo $page->msg("connection.disconnect"); ?></button>
                    </a>
                </div>
            <?php
            }
            ?>
        </div>
    </header>
<?php
}
?>