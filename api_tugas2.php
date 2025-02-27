<?php
header('Content-Type: application/json; charset=utf8');
$koneksi = mysqli_connect("localhost", "root", "", "menu_makanan");

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $sql = "SELECT * FROM menu_makanan";
    $query = mysqli_query($koneksi, $sql);
    $array_data = array();
    while($data = mysqli_fetch_assoc($query)){
        $array_data[] = $data;
    }
    echo json_encode($array_data);
} else if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nama_makanan= $_POST['nama_makanan'];
    $stok= $_POST['stok'];
    $harga= $_POST['harga'];

    $sql = "INSERT INTO menu_makanan (nama_makanan, stok, harga) VALUES ('$nama_makanan', '$stok', '$harga')";
    $cek = mysqli_query($koneksi, $sql);

    if($cek){
        $data = [
            'status' => "berhasil"
        ];
        echo json_encode([$data]);
    } else{
        $data = [
            'status' => "gagal"
        ];
        echo json_encode([$data]);
    }
} else if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
    $id = $_GET['id'];
    $sql = "DELETE FROM menu_makanan WHERE id = '$id'";
    $cek = mysqli_query($koneksi, $sql);

    if($cek){
        $data = [
            'status' => "berhasil"
        ];
        echo json_encode([$data]);
    } else{
        $data = [
            'status' => "gagal"
        ];
        echo json_encode([$data]);
    }
}
