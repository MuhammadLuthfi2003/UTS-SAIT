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
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Add New Data</h2>
                    </div>
                    <p>Please fill this form and submit to add student record to the database.</p>
                    <?php

                        $curl= curl_init();
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        //Pastikan sesuai dengan alamat endpoint dari REST API di UBUNTU, 
                        curl_setopt($curl, CURLOPT_URL, 'localhost:3000/api.php');
                        $res = curl_exec($curl);
                        $json = json_decode($res, true);

                        $listNim = array();
                        $listMatkul = array();

                        for ($i = 0; $i < count($json['data']); $i++) {
                            $listMatkul[$i] = $json['data'][$i]['kode_mk'];
                        }

                        $listMatkul = array_unique($listMatkul);
                    
                    ?>
                    <form action="insertMahasiswaDo.php" method="post">
                        <div class="form-group">
                            <label>NIM Mahasiswa</label>
                            <select name="nim" class="form-control">
                                <option value="sv_001">sv_001</option>
                                <option value="sv_002">sv_002</option>
                                <option value="sv_003">sv_003</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kode Matakuliah</label>
                            <select name="kode_mk" class="form-control">
                                <?php
                                for ($i = 0; $i < count($listMatkul); $i++) {
                                    echo "<option value='$listMatkul[$i]'>$listMatkul[$i]</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nilai</label>
                            <input type="number" name="nilai" class="form-control">
                        </div>
                        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>