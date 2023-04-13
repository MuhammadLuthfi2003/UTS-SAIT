<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<?php
 $nim = $_GET['nim'];
 $kodematkul = $_GET['kode_mk'];
 $curl= curl_init();
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
 //Pastikan sesuai dengan jenis_game endpoint dari REST API di ubuntu
 curl_setopt($curl, CURLOPT_URL, 'localhost:3000/api.php?nim='.$nim.'&kode_mk='.$kodematkul.'');
 $res = curl_exec($curl);
 $json = json_decode($res, true);
//var_dump($json);
?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Nilai</h2>
                    </div>
                    <form action="updateMahasiswaDo.php" method="post">
                        <div class="form-group">
                            <label>NIM Mahasiswa</label>
                            <input type="hidden" name="nim" class="form-control" value="<?php echo($json["data"][0]["nim"]); ?>">
                            <p><?php echo($nim); ?></p>
                        </div>
                        <div class="form-group">
                            <label>Kode Matakuliah</label>
                            <input type="hidden" name="kode_mk" class="form-control" value="<?php echo($json["data"][0]["kode_mk"]); ?>">
                            <p><?php echo($kodematkul); ?></p>
                        </div>
                        <div class="form-group">
                            <label>Nilai</label>
                            <input type="number" name="nilai" class="form-control" value="<?php echo($json["data"][0]["nilai"]); ?>">
                        </div>
                        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>