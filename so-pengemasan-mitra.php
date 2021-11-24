<?php
    session_start(); 
	// cek apakah yang mengakses halaman ini sudah login
	if($_SESSION['role']!="1"){
		header("location:login.php?pesan=gagal");
	}
    include("config.php");
    $error='';
    $username = $_SESSION['username'];
    $query=("SELECT * from pemesanan
    left join detail_pemesanan on pemesanan.no_pemesanan=detail_pemesanan.no_pemesanan
	left join mitra on pemesanan.id_pemilik=mitra.id_pemilik
	left join produk on detail_pemesanan.id_produk=produk.id_produk
    left join peternak on produk.id_peternak=peternak.id_peternak
    left join public.user on peternak.id_peternak=public.user.username where pemesanan.status='2' and pemesanan.id_pemilik='$username';");
    $datas = pg_query($dbconn,$query); 
    $cek = pg_affected_rows($datas);
    if($cek > 0){
        
    }else{
        $error =  'Data Tidak Ditemukan';
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Status Order</title>
  </head>
  <style type="text/css">
    #left { text-align: left;}
    #right { text-align: right;}
    #center { text-align: center;}
    #justify { text-align: justify;}
    #right-btn { align:right;}
    #image { width: 100px ; height: 100px ; margin-right:20px;}
    #image2 { width: 50px ; height: 50px ; margin-right:20px;}
  </style>
  <body>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
    
    <?php
    include('layout/admin-navbar.php');
    ?>


    <div class="container"style="padding-top:100px;padding-bottom:5%;"> 
        <div class="card text-center">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link" aria-current="true" href="so-belumbayar-mitra.php">Belum dibayar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="so-pengemasan-mitra.php">Pengemasan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="so-pengiriman-mitra.php">Pengiriman</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="so-selesai-mitra.php">Selesai</a>
                </li>
                </ul>
            </div>
            

            
            <div class="card-body">
                <div class="card text-start" style="padding:10px;">
                <?php if($error != ''){ ?>
                    <div class="alert alert-danger" role="alert" id="center"><?= $error; ?></div>
                <?php } ?>
                <ul class="list-group list-group-flush">
                    <?php while($data = pg_fetch_object($datas)): ?>
                        <li class="list-group-item">
                        <img id="image2" class="rounded-circle" src="upload/<?=$data->foto?>" style="float:left;">
                        <?=$data->nama_peternakan?>
                        <br><?=$data->tgl_pesan?>
                        <br>No.pemesanan: <?=$data->no_pemesanan?>
                            <a class="btn btn-outline-success" href="detail-pengemasan-mitra.php?id=<?=$data->no_pemesanan?>" style="float:right; role="button">Detail</a>
                        </li>
                    <?php endwhile; ?>   
                </ul>
                    
                </div>
            </div>
            
        </div>
    </div>
    
    <?php     
        
    include('layout/admin-footer.php');
    ?>
</html>