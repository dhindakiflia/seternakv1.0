<?php
    session_start(); 
	// cek apakah yang mengakses halaman ini sudah login
	if($_SESSION['role']!="1"){
		header("location:login.php?pesan=gagal");
	}
    include("config.php");
    $error='';
    $id=$_GET['id'];
    $username = $_SESSION['username'];
    $query=("SELECT produk.foto as foto_produk, * from pemesanan
    left join detail_pemesanan on pemesanan.no_pemesanan=detail_pemesanan.no_pemesanan
    left join produk on detail_pemesanan.id_produk=produk.id_produk left join mitra on pemesanan.id_pemilik=mitra.id_pemilik
    left join public.user on mitra.id_pemilik=public.user.username where pemesanan.no_pemesanan='$id'and pemesanan.id_pemilik='$username';");
    $datas = pg_query($dbconn,$query); 
    
    

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
                    <a class="nav-link active" aria-current="true" href="so-belumbayar-mitra.php">Belum dibayar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="so-pengemasan-mitra.php">Pengemasan</a>
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
            <div class="card" style="padding:10px;">
            <?php if($error != ''){ ?>
                <div class="alert alert-danger" role="alert"><?= $error; ?></div>
            <?php } ?>

            <?php while($data = pg_fetch_object($datas)): ?>
                <div class="container">
                    <div class="row g-0">
                        <div style="float:left;">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0" >
                                    <!-- <img id="image2" class="rounded-circle" src="assets/ style="float:left;"> -->
                                </div>
                                <div class="flex-shrink-1">
                                
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-6" style="margin-top:20px;">
                            <img id="image" class="rounded float-start" src="assets/produk/<?=$data->foto_produk?>" alt="">
                            <h6 id="left" class="card-title"><?=$data->nama_produk?></h6>
                            <p id="left" class="card-text"><?=$data->kuantitas?> <?=$data->satuan?></p>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                <p id="right" class="card-text">Rp.<?=$data->harga?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                                    
            <?php endwhile; ?>   
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#exampleModal" style="float:right;">
                Konfirmasi Pembayaran
                </button>
            </div>
            
            </div>
        </div>
    </div>
    
    
    

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Bukti Transfer</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
        
            <p>Tambahkan bukti pembayaran</p>
            <form action="function/upload_bukti.php" method="post" enctype="multipart/form-data">
            <div class="input-group">
            <input type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="file">
            <input type="hidden" name="id" id="" value="<?=$id?>">
            <input class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon04" name="upload" value="Upload">
            </div>
            
            </form>
        </div>
            </div>
    </div>
    </div>

    
    <?php     
        
    include('layout/admin-footer.php');
    ?>
</html>