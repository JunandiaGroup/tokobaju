<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

# SAAT TOMBOL KIRIM DIKLIK
if(isset($_POST['btnKirim'])){
	// Baca variabel form
	$txtNoPemesanan	= $_POST['txtNoPemesanan'];
	$txtNoPemesanan 		= str_replace("'","&acute;",$txtNoPemesanan);
	
	$txtNama		= $_POST['txtNama'];
	$txtNama 		= str_replace("'","&acute;",$txtNama);
	
	$txtJumlahTransfer		= $_POST['txtJumlahTransfer'];
	$txtJumlahTransfer 		= str_replace(".","",$txtJumlahTransfer); // Menghilangkan karakter titik (10.000 jadi 10000)
	$txtJumlahTransfer 		= str_replace(",","",$txtJumlahTransfer); // Menghilangkan karakter koma (10,000 jadi 10000)
	$txtJumlahTransfer 		= str_replace(" ","",$txtJumlahTransfer); // Menghilangkan karakter kosong (10 000 jadi 10000)
	
	$txtKeterangan	= $_POST['txtKeterangan'];
	$txtKeterangan 	= str_replace("'","&acute;",$txtKeterangan);
	
	// Validasi form
	$pesanError = array();
	if (trim($txtNoPemesanan)=="") {
		$pesanError[] = "Data <b>No. Pemesanan</b>  masih kosong, isi sesuai dengan <b>No Pemesanan</b> Anda";
	}
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Penerima</b>  masih kosong, isi sesuai nama akun Anda";
	}
	if (trim($txtJumlahTransfer)=="" or ! is_numeric(trim($txtJumlahTransfer))) {
		$pesanError[] = "Data <b> Jumlah Ditransfer (Rp)</b> masih kosong, dan <b> harus ditulis angka </b>";
	}
	if (trim($txtKeterangan)=="") {
		$pesanError[] = "Data <b> Keterangan </b> masih kosong";
	}

	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='pesanError' align='left'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "<br>"; 
	}
	else {
		# SIMPAN DATA KE DATABASE. Jika tidak menemukan pesan error, simpan data ke database
		// Membuat tanggal
		$tanggal	= date('Y-m-d');
		
		// Simpan data ke database
		$mySql = "INSERT INTO konfirmasi (no_pemesanan, nm_pelanggan, jumlah_transfer, keterangan, tanggal) 
				  VALUES ('$txtNoPemesanan', '$txtNama', '$txtJumlahTransfer', '$txtKeterangan', '$tanggal')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		
		echo "<b> SUKSES ...! KONFIRMASI SUDAH DIKIRIM </b>";
		echo "<meta http-equiv='refresh' content='2; url=?open=Barang'>";
		exit;
	}	
} // End if($_POST) 
	
# REKAM DATA JIKA KOSONG FORM
$dataNoPemesanan	= isset($_POST['txtNoPemesanan']) ? $_POST['txtNoPemesanan'] : '';
$dataNama			= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataJumlahTransfer	= isset($_POST['txtJumlahTransfer']) ? $_POST['txtJumlahTransfer'] : '';
$dataKeterangan 	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><b>KONFIRMASI PEMBAYARAN </b></td>
    </tr>
    <tr>
      <td width="282"><strong>No. Pemesanan </strong></td>
      <td width="3">:</td>
      <td width="924"><input name="txtNoPemesanan" type="text" value="<?php echo $dataNoPemesanan; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td><strong>Nama Penerima </strong></td>
      <td>:</td>
      <td><input name="txtNama" type="text" value="<?php echo $dataNama; ?>" size="60" maxlength="100" /></td>
    </tr>
    <tr>
      <td><strong>Jumlah Transfer (Rp.) </strong></td>
      <td>:</td>
      <td><input name="txtJumlahTransfer" type="text" value="<?php echo $dataJumlahTransfer; ?>" size="20" maxlength="12" /></td>
    </tr>
    <tr>
      <td><strong>Keterangan</strong></td>
      <td>:</td>
      <td><textarea name="txtKeterangan" cols="50" rows="3"><?php echo $dataKeterangan; ?></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnKirim" value=" Kirim "></td>
    </tr>
  </table>
</form>
