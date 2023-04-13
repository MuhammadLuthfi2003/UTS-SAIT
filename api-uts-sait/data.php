<html>
    <?php
        require_once("config.php");
        // queries the db
        $sql = "SELECT m.nim, m.nama, m.alamat, m.tanggal_lahir, mk.kode_mk, mk.nama_mk, mk.sks, p.nilai
        FROM mahasiswa m
        JOIN perkuliahan p ON m.nim = p.nim
        JOIN matakuliah mk ON p.kode_mk = mk.kode_mk;";
        $result = $mysqli->query($sql);

        echo " 
            <table border=1>
                <tr>
                    <th>nim</th>
                    <th>nama</th>
                    <th>alamat</th>
                    <th>tanggal_lahir</th>
                    <th>kode_mk</th>
                    <th>nama_mk</th>
                    <th>sks</th>
                    <th>nilai</th>
                </tr>
        ";
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                    <tr>
                        <td>".$row["nim"]."</td>
                        <td>".$row["nama"]."</td>
                        <td>".$row["alamat"]."</td>
                        <td>".$row["tanggal_lahir"]."</td>
                        <td>".$row["kode_mk"]."</td>
                        <td>".$row["nama_mk"]."</td>
                        <td>".$row["sks"]."</td>
                        <td>".$row["nilai"]."</td>
                    </tr>
                ";
            }
            echo "</table> ";
        }
        else {
            echo "0 results";
        } 
    ?>
</html>