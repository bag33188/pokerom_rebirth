<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
        <title>List Routes</title>
        <style <?= 'type="text/css"'; ?>>
            pre {
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <?php
            // run command, list routes
            $output = `CD .. && php artisan route:list`;
            echo "<pre>\n" . htmlentities($output) . "\n</pre>", "\n";
        ?>
    </body>
</html>
