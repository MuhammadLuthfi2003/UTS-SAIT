<?php

$nim = $_GET['nim'];
$kodematkul = $_GET['kode_mk'];

//Pastikan sesuai dengan alamat endpoint dari REST API di ubuntu
$url='localhost:3000/api.php?nim='.$nim.'&kode_mk='.$kodematkul.'';


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
// pastikan method nya adalah delete
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
$result = json_decode($result, true);

curl_close($ch);

//var_dump($result);
// tampilkan return statusnya, apakah sukses atau tidak
print("<center><br>status :  {$result["status"]} "); 
print("<br>");
print("message :  {$result["message"]} "); 
 //
echo "<br>Sukses menghapus data di ubuntu server !";
echo "<br><a href=selectMahasiswaView.php> OK </a>";

?>