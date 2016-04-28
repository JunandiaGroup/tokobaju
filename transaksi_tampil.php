<?php
include_once "inc.session.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

// Baca Kode Pelanggan yang Login
$KodePelanggan	= $_SESSION['SES_PELANGGAN'];
?> 
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td colspan="8" bgcolor="#CCCCCC"><strong>DAFTAR PEMESANAN </strong></td>
  </tr>
  <tr bgcolor="#dfe9ff">
    <td width="4%" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="15%" bgcolor="#F5F5F5"><strong>No. Pesan </strong></td>
    <td width="10%" bgcolor="#F5F5F5"><strong>Tanggal</strong></td>
    <td width="22%" bgcolor="#F5F5F5"><strong>Nama Penerima </strong></td>
    <td width="14%" bgcolor="#F5F5F5"><strong>Total   (Rp)</strong></td>
    <td width="20%" bgcolor="#F5F5F5"><strong>Biaya Kirim (Rp) </strong></td>
    <td width="10%" bgcolor="#F5F5F5"><strong>Status</strong></td>
    <td width="5%" bgcolor="#F5F5F5"><strong>Tools</strong></td>
  </tr>
<?php
// Deklrasi variabel
$biayaKirim	= 0;
$totalBayar 	= 0;
$digitHp	= "";
$unikTransfer	= 0;

// Menampilkan semua data Pesanan Lunas (yang sudah lunas)
$mySql = "SELECT pemesanan.*, pelanggan.nm_pelanggan, provinsi.biaya_kirim
		  FROM pemesanan
		  LEFT JOIN pelanggan ON pemesanan.kd_pelanggan= pelanggan.kd_pelanggan 
		  LEFT JOIN provinsi ON pemesanan.kd_provinsi=provinsi.kd_provinsi
		  WHERE pemesanan.kd_pelanggan='$KodePelanggan' ORDER BY no_pemesanan";
$myQry = @mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
$nomor = 0;
while ($myData =mysql_fetch_array($myQry)) {
	$nomor++;
	$Kode = $myData['no_pemesanan'];
	
	// Deklarasi variabel data
	$diskonHarga	= 0;
	$hargaDiskon	= 0;
	$totalHarga		= 0;
	$totalBarang	= 0;
	
	// Menampilkan data di pemesanan_item
	$hitungSql	= "SELECT SUM(harga * jumlah) As total_harga,
				SUM(jumlah) As total_barang FROM pemesanan_item WHERE no_pemesanan='$Kode'";
	$hitungQry 	= mysql_query($hitungSql, $koneksidb) or die ("Gagal query 2 ".mysql_error());
	$hitungData = mysql_fetch_array($hitungQry);
	
	$totalHarga		= $hitungData['total_harga'];
	$totalBarang	= $hitungData['total_barang'];
	
	// Hitung total biaya kirim (Biaya Kirim Dikali dengan jumlah barang)
	$biayaKirim	= $totalBarang * $myData['biaya_kirim'];
	
	// Hitung total yang harus dibayar
	$totalBayar	= $totalHarga + $biayaKirim;
	
	// Mengambil 3 digit terakhir nomor HP
	$digitHp 	= substr($myData['no_telepon'],-3);
	
	// Membuat nominal transfer
	$unikTransfer = substr($totalBayar,0,-3).$digitHp;
?>
  <tr>
	<td> <?php echo $nomor; ?> </td>
	<td> <?php echo $myData['no_pemesanan']; ?> </td>
	<td> <?php echo IndonesiaTgl($myData['tgl_pemesanan']); ?> </td>
	<td> <?php echo $myData['nama_penerima']; ?> </td>
	<td> Rp. <?php echo format_angka($totalHarga); ?> </td>
	<td> Rp. <?php echo format_angka($biayaKirim); ?> </td>
	<td> <?php echo $myData['status_bayar']; ?> </td>
    <td><a href="transaksi_lihat.php?Kode=<?php echo $Kode; ?>" target="_blank" alt="Lihat Data">Cetak</a></td>
  </tr>
<?php } ?>
</table>
