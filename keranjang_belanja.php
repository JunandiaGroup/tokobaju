<?php
include_once "inc.session.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

// Baca Kode Pelanggan yang Login
$KodePelanggan	= $_SESSION['SES_PELANGGAN'];

# TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	$arrData = count($_POST['txtJum']); 
	$qty = 1;
	for ($i=0; $i < $arrData; $i++) {
		# Melewati biar tidak 0 atau minus
		if ($_POST['txtJum'][$i] < 1) {
			$qty = 1;
		}
		else {
			$qty = $_POST['txtJum'][$i];
		}
					
		# Simpan Perubahan
		$KodeBrg	= $_POST['txtKodeH'][$i];
		$tanggal	= date('Y-m-d');
		$jam		= date('G:i:s');
		
		$sql = "UPDATE tmp_keranjang SET jumlah='$qty', tanggal='$tanggal' 
				WHERE kd_barang='$KodeBrg' AND kd_pelanggan='$KodePelanggan'";
		$query = mysql_query($sql, $koneksidb);
	}
	// Refresh
	echo "<meta http-equiv='refresh' content='0; url=?open=Keranjang-Belanja'>";
	exit;	
}

# MENGHAPUS DATA BARANG YANG ADA DI KERANJANG
// Membaca Kode dari URL
if(isset($_GET['aksi']) and trim($_GET['aksi'])=="Hapus"){ 
	// Membaca Id data yang dihapus
	$idHapus	= $_GET['idHapus'];
	
	// Menghapus data keranjang sesuai Kode yang dibaca di URL
	$mySql = "DELETE FROM tmp_keranjang  WHERE id='$idHapus' AND kd_pelanggan='$KodePelanggan'";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Eror hapus data".mysql_error());
	if($myQry){
		echo "<meta http-equiv='refresh' content='0; url=?open=Keranjang-Belanja'>";
	}
}

# MEMERIKSA DATA DALAM KERANJANG
$cekSql = "SELECT * FROM tmp_keranjang WHERE  kd_pelanggan='$KodePelanggan'";
$cekQry = mysql_query($cekSql, $koneksidb) or die (mysql_error());
$cekQty = mysql_num_rows($cekQry);
if($cekQty < 1){
	echo "<br><br>";
	echo "<center>";
	echo "<b> KERANJANG BELANJA KOSONG </b>";
	echo "<center>";
	
	// Jika Keranjang masih Kosong, maka halaman Refresh ke data Barang
	echo "<meta http-equiv='refresh' content='2; url=?page=Barang'>";
	exit;
}
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td colspan="6" bgcolor="#CCCCCC"><strong>KERANJANG BELANJA</strong></td>
    </tr>
    <tr>
      <td width="15%"><strong>Gambar</strong></td>
      <td width="46%"><strong>Nama Barang</strong></td>
      <td width="16%"><strong>Harga (Rp)</strong></td>
      <td width="5%"><strong>Jumlah</strong></td>
      <td width="13%"><strong>Total (Rp)</strong></td>
      <td width="5%"><strong>Tools</strong></td>
    </tr>
	<?php
	// Menampilkan data Barang dari tmp_keranjang (Keranjang Belanja)
	$mySql = "SELECT barang.nm_barang, barang.file_gambar, kategori.nm_kategori, tmp_keranjang.*
			FROM tmp_keranjang
			LEFT JOIN barang ON tmp_keranjang.kd_barang=barang.kd_barang
			LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori 
			WHERE tmp_keranjang.kd_pelanggan='$KodePelanggan' 
			ORDER BY tmp_keranjang.id";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal SQL".mysql_error());
	$total = 0; $grandTotal = 0;
	$no	= 0;
	while ($myData = mysql_fetch_array($myQry)) {
	  $no++;
	  // Menghitung sub total harga
	  $total 		= $myData['harga'] * $myData['jumlah'];
	  
	  // Menghitung grand total harga (semua barang yang dibeli)
	  $grandTotal	= $grandTotal + $total;
	  
	  // Menampilkan gambar
	  if ($myData['file_gambar']=="") {
			$fileGambar = "noimage.jpg";
	  }
	  else {
			$fileGambar	= $myData['file_gambar'];
	  }
	  
	  #Kode Barang
	  $Kode = $myData['kd_barang'];
	?>    
	<tr>
      <td rowspan="3"> <img src="img-barang/<?php echo $fileGambar; ?>" width="70" border="1" > </td>
      <td><a href="?open=Barang-Lihat&Kode=<?php echo $Kode; ?>" target="_blank"><strong><?php echo $myData['nm_barang']; ?></strong></a></td>
      <td>Rp.<?php echo format_angka($myData['harga']); ?></td>
      <td><input name="txtJum[]" type="text" value="<?php echo $myData['jumlah']; ?>" size="4" maxlength="2">
      <input name="txtKodeH[]" type="hidden" value="<?php echo $myData['kd_barang']; ?>"></td>
      <td>Rp. <?php echo format_angka($total); ?></td>
      <td><a href="?open=Keranjang-Belanja&aksi=Hapus&idHapus=<?php echo $myData['id'];?>">Delete</a></td>
    </tr>
    <tr>
      <td>Kategori : <?php echo $myData['nm_kategori']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	<?php } ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2"><b>GRAND TOTAL   : </b></td>
      <td bgcolor="#CCCCCC"><strong><?php echo "Rp. ".format_angka($grandTotal); ?></strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnSimpan" type="submit" value=" Ubah Data"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" align="center"><a href="?open=Transaksi-Proses" target="_self"><img src="images/btn_lanjutkan.jpg" alt="Lanjutkan Transaksi (Checkout)" border="0"></a></td>
    </tr>
  </table>
</form>







