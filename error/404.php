<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>litebans-php - Tables Not Found</title>
    <link href="../include/css/custom.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="jumbotron">
        <h2>Tables Not Found</h2><br>
        <div class="text-warning">
            The web interface has connected to the database, but could not find any tables generated by LiteBans.
            <br>
            This means that the plugin has not successfully connected to this database before with the same
            configuration.
            <br>
            LiteBans needs to be connected to this database before the web interface can display anything!
            <br><br>
            Solutions:
            <br>
            - Check that LiteBans has successfully connected to a MySQL database using <a class="text-info">/litebans
                info</a>
            <br>
            - Ensure that the plugin is using the MySQL driver to connect to the database.
            (In config.yml, replace
            <a class="text-danger">"driver: H2"</a> with <a class="text-info">"driver: MySQL"</a>)
            <?php
            require_once '../inc/settings.php';
            $settings = new Settings(false);
            $host = $settings->host;
            if ($host === "localhost" || $host === "127.0.0.1" || $host === "0.0.0.0") {
                echo("<br>- The web interface is connected to <a class=\"text-info\">$host</a>. If LiteBans and the web interface are both connected to <a class=\"text-info\">$host</a>, they should not be hosted on two separate servers.");
            }
            $table_prefix = $settings->table_prefix;
            echo("<br>- Ensure that the table prefix is the same in config.yml and settings.php. The table prefix in settings.php is currently set to <a class=\"text-info\">\"$table_prefix\"</a>.")
            ?>
            <br>
            - Ensure that you are using the latest version of LiteBans.
            <br>
        </div>
        <br>
        <a href="../" class="btn btn-default">Try Again</a>
    </div>
</div>
</body>
</html>
