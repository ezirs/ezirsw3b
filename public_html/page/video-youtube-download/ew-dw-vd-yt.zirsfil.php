vevesdv
<?php
    $downloadURL = urldecode($_GET['link']);
    $type = urldecode($_GET['type']);
    $title = urldecode($_GET['title']);
    $fileName = $title . '.' . $type;
    $size = urldecode($_GET['size']);

    if (!empty($downloadURL) && substr($downloadURL, 0, 8) === 'https://') {
        header('Content-Description: File Transfer');
        header("Content-Type: $type");

        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: must-revalidate");
        header("Accept-Ranges: bytes");
        header("Content-Length: $size");
        header("Content-Range: bytes ");
        header("Content-Disposition: attachment; filename=$fileName");
        header("Content-Transfer-Encoding: binary");
        readfile($downloadURL);
    }

?>