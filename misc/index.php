<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
        <title>Miscellaneous</title>
    </head>
    <body>
        <?php
            // run command, list directory contents
            $output = `DIR`;
            echo "<pre>\n" . htmlentities($output) . "\n</pre>", "\n";
        ?>
    </body>
</html>
