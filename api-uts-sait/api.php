<?php
require_once "config.php";
$request_method=$_SERVER["REQUEST_METHOD"];

switch ($request_method) {
   case 'GET':
         if(!empty($_GET["nim"]))
         {
            $id=$_GET["nim"];
            get_mhs($id);
         }
         else
         {
            get_all();
         }
         break;
   case 'POST':
         if(!empty($_GET["nim"]) && !empty($_GET["kode_mk"]))
         {
            $id = $_GET["nim"];
            $kodematkul = $_GET["kode_mk"];
            update_nilai($id, $kodematkul);
         }
         else
         {
            insert_data();
         }     
         break; 
   case 'DELETE':
        if (!empty($_GET["nim"]) && !empty($_GET["kode_mk"]))
        {
            $id = $_GET["nim"];
            $kodematkul = $_GET["kode_mk"];
            delete_data($id, $kodematkul);
        }
            
            break;
   default:
      // Invalid Request Method
         header("HTTP/1.0 405 Method Not Allowed");
         break;
      break;
 }



   function get_all()
   {
      global $mysqli;
      $query="SELECT m.nim, m.nama, m.alamat, m.tanggal_lahir, mk.kode_mk, mk.nama_mk, mk.sks, p.nilai
      FROM mahasiswa m
      JOIN perkuliahan p ON m.nim = p.nim
      JOIN matakuliah mk ON p.kode_mk = mk.kode_mk;";
      $data=array();
      $result=$mysqli->query($query);
      while($row=mysqli_fetch_object($result))
      {
         $data[]=$row;
      }
      $response=array(
                     'status' => 1,
                     'message' =>'Get List All Mahasiswa Successfull!.',
                     'data' => $data
                  );
      header('Content-Type: application/json');
      echo json_encode($response);
   }
 
   function get_mhs($id)
   {
      global $mysqli;
      $query="SELECT m.nim, m.nama, m.alamat, m.tanggal_lahir, mk.kode_mk, mk.nama_mk, mk.sks, p.nilai
      FROM mahasiswa m
      JOIN perkuliahan p ON m.nim = p.nim
      JOIN matakuliah mk ON p.kode_mk = mk.kode_mk
      WHERE m.nim = (
          SELECT nim
          FROM mahasiswa
          WHERE nim = "."'$id'".");";

      $data=array();
      $result=$mysqli->query($query);
      while($row=mysqli_fetch_object($result))
      {
         $data[]=$row;
      }
      $response=array(
                     'status' => 1,
                     'message' =>'Get Specific NIM Successfull!.',
                     'data' => $data
                  );
      header('Content-Type: application/json');
      echo json_encode($response);
        
   }
 
   function insert_data()
      {
         global $mysqli;
         if(!empty($_POST["nim"]) && !empty($_POST["kode_mk"]) && !empty($_POST["nilai"]) ){
            $data=$_POST;

         }else{
            $data = json_decode(file_get_contents('php://input'), true);
         }

         $arrcheckpost = array('nim' => '','kode_mk' => '', 'nilai' => '');
         $hitung = count(array_intersect_key($data, $arrcheckpost));
         if($hitung == count($arrcheckpost)){
          
               $result = mysqli_query($mysqli, 
               "INSERT INTO perkuliahan SET
               nim = '$data[nim]',
               kode_mk = '$data[kode_mk]',
               nilai = $data[nilai]");   

               if($result)
               {
                  $response=array(
                     'status' => 1,
                     'message' =>'Nilai Berhasil Ditambahkan!.'
                  );
               } else {
                  $response=array(
                     'status' => 0,
                     'message' =>'Nilai Gagall Ditambahkan!.'
                  );
               }
         }else{
            $response=array(
                     'status' => 0,
                     'message' =>'Parameter Tidak Sesuai!.'
                  );
         }
         header('Content-Type: application/json');
         echo json_encode($response);
      }
 
   function update_nilai($id, $kodematkul)
      {
         global $mysqli;
         if(!empty($_POST["nilai"])){
            $data= $_POST;
         }else{
            $data = json_decode(file_get_contents('php://input'), true);
         }

         $arrcheckpost = array('nilai' => '');
         $hitung = count(array_intersect_key($data, $arrcheckpost));
         if($hitung == count($arrcheckpost)) {
          
              $result = mysqli_query($mysqli, 
              "UPDATE perkuliahan SET
               nilai = '$data[nilai]'
               WHERE kode_mk = '$kodematkul' AND nim = '$id';");
          
            if($result)
            {
               $response=array(
                  'status' => 1,
                  'message' =>'Nilai Berhasil Diupdate!.'
               );
            }
            else
            {
               $response=array(
                  'status' => 0,
                  'message' =>'Nilai Gagal Diupdate!.'
               );
            }
         }
         else{
            $response=array(
                     'status' => 0,
                     'message' =>'Parameter Tidak Sesuai!.'
                  );
         }
         header('Content-Type: application/json');
         echo json_encode($response);
      }
 
   function delete_data($id, $kodematkul)
   {
      global $mysqli;
      $query="DELETE FROM perkuliahan WHERE nim='$id' AND kode_mk='$kodematkul' ";

      if(mysqli_query($mysqli, $query))
      {
         $response=array(
            'status' => 1,
            'message' =>'Berhasil Menghapus Nilai!.'
         );
      }
      else
      {
         $response=array(
            'status' => 0,
            'message' =>'Gagal Menghapus Nilai!.'
         );
      }
      header('Content-Type: application/json');

      echo json_encode($response);
   }

 
?> 
