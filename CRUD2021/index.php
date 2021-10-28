<?php
    //Koneksi Database
    $server ="localhost";
    $user = "root";
    $pass = "";
    $database = "dblatihan";

    $koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

    //Jika tombol simpan diklik
    if(isset($_POST['bsimpan']))
    {
        //Pengujian apakah data akan diedit atau disimpan baru
        if($_GET['hal'] == "edit")
        {
            //Data akan diedit
            $edit = mysqli_query($koneksi, "UPDATE tmhs set
                                                nim = '$_POST[tnim]',
                                                nama = '$_POST[tnama]',
                                                alamat = '$_POST[talamat]',
                                                prodi = '$_POST[tprodi]'
                                             WHERE id_mhs = '$_GET[id]' 
                                           ");
            if($edit) //Jika edit sukses
            {
                echo "<script>
                        alert('Edit data sukses!');
                        document.location='index.php';
                    </script>";
            }
            else 
            {
                echo "<script>
                        alert('Edit data GAGAl!');
                        document.location='index.php';
                    </script>";   
            }
        }
        else
        {
            //Data akan disimpan baru
            $simpan = mysqli_query($koneksi, "INSERT INTO tmhs (nim, nama, alamat, prodi)
                                         VALUES ('$_POST[tnim]', 
                                                '$_POST[tnama]', 
                                                '$_POST[talamat]', 
                                                '$_POST[tprodi]')
                                        ");
            if($simpan)
            {
                echo "<script>
                        alert('Simpan data sukses!');
                        document.location='index.php';
                    </script>";
            }
            else 
            {
                echo "<script>
                        alert('Simpan data GAGAl!');
                        document.location='index.php';
                    </script>";   
            }
        }


        
    }


    //Pengujian jika tombol Edit/Hapus diklik
    if(isset($_GET['hal']))
    {
        //Pengujian edit data
        if($_GET['hal'] == "edit")
        {
            //Tampilkan data yang akan diedit
            $tampil = mysqli_query($koneksi, "SELECT * FROM tmhs WHERE id_mhs = '$_GET[id]' ");
            $data = mysqli_fetch_array($tampil);
            if($data)
            {
                //Jika data ditemukan, maka data ditampung ke dalam variabel
                $vnim = $data['nim'];
                $vnama = $data['nama'];
                $valamat = $data['alamat'];
                $vprodi = $data['prodi'];
            }
        }
        else if ($_GET['hal'] == "hapus")
        {
            //Persiapan hapus data
            $hapus = mysqli_query($koneksi, "DELETE FROM tmhs WHERE id_mhs = '$_GET[id]' ");
            if($hapus){
                echo "<script>
                        alert('Hapus data sukses!');
                        document.location='index.php';
                    </script>"; 
            }
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD 2021 PHP & MySQL + Booststarp</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">

    <h1 class="text-center">DATA MAHASISWA FTI UNMER MALANG</h1>
    <h2 class="text-center">(LATIHAN CRUD)</h2>

    <!-- AWal Card Form -->
    <div class="card mt-5">
    <div class="card-header bg-primary text-white">
        Form Input Data Mahasiswa
    </div>
    <div class="card-body">
        <form method="post" action="">
            <div class="form-group">
                <label>NIM</label>
                <input type="text" name="tnim" value="<?=@$vnim?>" class="form-control" placeholder="Input NIM Anda di sini!" required>
            </div>
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Input nama Anda di sini!" required>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea class="form-control" name="talamat" placeholder="Input alamat Anda di sini!"><?=@$valamat?></textarea>
            </div>
            <div class="form-group">
                <label>Program Studi</label>
                <select class="form-control" name="tprodi">  
                    <option value="<?=@$vprodi?>"><?=@$vprodi?></option>
                    <option value="D3 Teknik Informatika">D3 Teknik Informatika</option>
                    <option value="S1 Sistem Informasi">S1 Sistem Informasi</option>
                </select>
            </div>


            <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
            <button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>

        </form>
    </div>
    </div>
    <!-- Akhir Card Form -->

   <!-- AWal Card Table -->
   <div class="card mt-3">
    <div class="card-header bg-success text-white">
        Daftar Mahasiswa
    </div>
    <div class="card-body">
      
        <table class="table table-bordered table-striped">
            <tr>
                <th>No.</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Program Studi</th>
                <th>Aksi</th>
            </tr>
            <?php
                $no = 1;
                $tampil = mysqli_query($koneksi, "SELECT * from tmhs order by id_mhs desc");
                while($data = mysqli_fetch_array($tampil)) :

            ?>
            <tr>
                <td><?=$no++;?></td>
                <td><?=$data['nim']?></td>
                <td><?=$data['nama']?></td>
                <td><?=$data['alamat']?></td>
                <td><?=$data['prodi']?></td>
                <td>
                    <a href="index.php?hal=edit&id=<?=$data['id_mhs']?>" class="btn btn-warning"> Edit </a>
                    <a href="index.php?hal=hapus&id=<?=$data['id_mhs']?>" onclick="return confirm('Apakah yakin ingin menghapus?')" class="btn btn-danger"> Hapus </a>
                </td>
            </tr>
            <?php endwhile; //penutup perulangan while ?>
        </table>

    </div>
    </div>
    <!-- Akhir Card Table -->

</div>

<script type="text/javascript" src="css/bootstrap.min.js"></script>
</body>
</html>