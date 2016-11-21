<?php
if (isset($_GET["f"])) {
    $filepath = "./tmp/" . $_GET["f"];
    if (file_exists($filepath) && is_file($filepath)) {
        $pathinfo = pathinfo($filepath);

        $name = preg_replace("/^.*?__/", "", $pathinfo["basename"], 1);
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $name . '"');
        readfile(realpath($pathinfo["dirname"] . "/" . $pathinfo["basename"]));
    }
}
