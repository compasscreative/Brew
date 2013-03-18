<?php
use Reinink\Buster\Buster;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Cache Buster Example</title>
    <?php

        // Include the class
        include 'cachebuster.php';

        // Create a cache buster instance
        // Set the path where PHP can find the files
        $buster = new Buster('/public');

        // Output the stylesheet link tags
        echo $buster->css('/css/boilerplate.css');
        echo $buster->css('/css/template.css');
    ?>
</head>

<body>

<h1>PHP Cache Buster Example</h1>

<p>This works great!</p>

<?php

    // Output the JavaScript script tags
    // Put them at the bottom of the page!
    echo $buster->js('/js/jquery.js');
    echo $buster->js('/js/template.js');
?>

</body>
</html>