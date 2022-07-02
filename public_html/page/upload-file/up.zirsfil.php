<?php
    require __DIR__.'/../../../config.zirsfil.php';
    date_default_timezone_set('Asia/Jakarta');
    $time = date("Y-m-d h:i:sa");
    $password = $_POST['password'];
    $fileName = $_FILES['file']['name'];
    $file_name =  str_replace("-", " ", str_replace("#", " ", str_replace("_", " ", $fileName)));
    $tmp_name = $_FILES['file']['tmp_name'];
    $file_up_name = 'EW_' . uniqid() . '#' . $file_name;

    $zip = new ZipArchive();
    $new_fil_name = explode('.', $file_up_name)[0] . '.zip';
    
    if (file_exists("files/" . $new_fil_name)) {
        $conn->query("insert into tbfiles (nama_file, password, size, tanggal_pembuatan) values ('$new_fil_name','$password','$size', '$time')");
    } else {
        $ext = pathinfo($file_up_name, PATHINFO_EXTENSION);
        $zip_name = 'files/' . $new_fil_name;
        if ($ext == 'zip') {
            move_uploaded_file($tmp_name, $zip_name);
        } else {
            $zip->open($zip_name, ZIPARCHIVE::CREATE);
            $zip->addFile($tmp_name, $file_name);
            $zip->close();
        }
        $size = filesize($zip_name);
        $sql = "insert into tbfiles (nama_file, password, size, tanggal_pembuatan) values ('$new_fil_name','$password','$size', '$time')";
        mysqli_query($conn, $sql);
    }
?>

<div class="text-center"><h1>Akses Ditolak</h1></div>
