<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET, POST, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf8');

$koneksi = mysqli_connect("localhost", "root", "", "menu_makanan");

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="API Pelanggan",
 *         version="1.0.0",
 *         description="Dokumentasi API untuk mengelola data pelanggan"
 *     ),
 *     @OA\Server(
 *         url="http://localhost:8080/api/",
 *         description="Server lokal"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api_tugas3.php?id={id}",
 *     summary="Ambil data pelanggan semuanya atau berdasarkan id",
 *     @OA\Parameter(
 *         name="id",
 *         in="query",
 *         required=false,
 *         description="ID Pelanggan (opsional, jika ingin mengambil data berdasarkan ID)",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Berhasil mengambil data",
 *         @OA\JsonContent(type="array", @OA\Items(
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="nama_pelanggan", type="string"),
 *             @OA\Property(property="alamat", type="string"),
 *             @OA\Property(property="no_hp", type="string"),
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="created_at", type="string", format="date-time")
 *         ))
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Parameter tidak valid"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api_tugas3.php",
 *     summary="Ambil data pelanggan semuanya atau berdasarkan id",
 *     @OA\Response(
 *         response=200,
 *         description="Berhasil mengambil data",
 *         @OA\JsonContent(type="array", @OA\Items(
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="nama_pelanggan", type="string"),
 *             @OA\Property(property="alamat", type="string"),
 *             @OA\Property(property="no_hp", type="string"),
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="created_at", type="string", format="date-time")
 *         ))
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Parameter tidak valid"
 *     )
 * )
 */
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $sql = "SELECT * FROM pelanggan WHERE id = '$id'";
    } else {
        $sql = "SELECT * FROM pelanggan";
    }

    $query = mysqli_query($koneksi, $sql);
    $array_data = array();
    while ($data = mysqli_fetch_assoc($query)) {
        $array_data[] = $data;
    }
    echo json_encode($array_data);
}

/**
 * @OA\Post(
 *     path="/api_tugas3.php",
 *     summary="Tambah data pelanggan",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"nama_pelanggan", "alamat", "no_hp", "email"},
 *             @OA\Property(property="nama_pelanggan", type="string"),
 *             @OA\Property(property="alamat", type="string"),
 *             @OA\Property(property="no_hp", type="string"),
 *             @OA\Property(property="email", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Berhasil menambahkan pelanggan",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="berhasil")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Data tidak lengkap"
 *     )
 * )
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (isset($data['nama_pelanggan'], $data['alamat'], $data['no_hp'], $data['email'])) {
        $nama_pelanggan = $data['nama_pelanggan'];
        $alamat = $data['alamat'];
        $no_hp = $data['no_hp'];
        $email = $data['email'];

        $sql = "INSERT INTO pelanggan (nama_pelanggan, alamat, no_hp, email) 
                VALUES ('$nama_pelanggan', '$alamat', '$no_hp', '$email')";
        $cek = mysqli_query($koneksi, $sql);

        if ($cek) {
            echo json_encode(['status' => "berhasil"]);
        } else {
            echo json_encode(['status' => "gagal"]);
        }
    } else {
        echo json_encode(['status' => "gagal", 'message' => "Data tidak lengkap"]);
    }
}
?>
