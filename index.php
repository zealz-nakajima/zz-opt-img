<?php
if (isset($_FILES["f"])) {
    $file = $_FILES["f"];
    define('SAVE_FOLDER', "./tmp/");

    if ($file["error"] == 0) {
        if ($file["type"] == "image/jpeg") {
            $img_size_m = filesize($file["tmp_name"]);
            exec("jpegoptim --strip-all --max=80 -t " . realpath($file["tmp_name"]));

            $save_path = uniqid() . "__" . $file["name"];
            copy($file["tmp_name"], SAVE_FOLDER . $save_path);

            $img_size_a = filesize(SAVE_FOLDER . $save_path);
            $avg        = number_format(round($img_size_m / 1000)) . "KB => " . number_format(round($img_size_a / 1000)) . "KB : " . (100 - (round(($img_size_a / $img_size_m) * 100, 2))) . "%(" . number_format(round(($img_size_m - $img_size_a) / 1024)) . "KB削減)";
        } elseif ($file["type"] == "image/png") {
            $img_size_m = filesize($file["tmp_name"]);
            $ret        = exec("optipng -o2 " . realpath($file["tmp_name"]));

            $save_path = uniqid() . "__" . $file["name"];
            copy($file["tmp_name"], SAVE_FOLDER . $save_path);

            $img_size_a = filesize(SAVE_FOLDER . $save_path);
            $avg        = number_format(round($img_size_m / 1000)) . "KB => " . number_format(round($img_size_a / 1000)) . "KB : " . (100 - (round(($img_size_a / $img_size_m) * 100, 2))) . "%(" . (round(($img_size_m - $img_size_a) / 1024)) . "KB削減)";
        }
    }
}

if ( ! empty($save_path)) {
    $img = base64_encode(file_get_contents(SAVE_FOLDER . $save_path));

    echo '<a href="down.php?f=' . $save_path . '"><img src="data:' . $file["type"] . ';base64,' . $img . '" style="max-width: 120px" /></a>' . "<br />" . $avg;
}
