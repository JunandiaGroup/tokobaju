<?php
// Membaca Kode dari URL
if(isset($_GET['Kode'])){
	$Kode	= $_GET['Kode'];
	
	// Menampilkan data sesuai Kode dari URL
	$lihatSql = "SELECT barang.*, kategori.nm_kategori FROM barang 
				LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
				WHERE barang.kd_barang='$Kode'";
	
	$lihatQry = mysql_query($lihatSql, $koneksidb) or die ("Data Gagal Ditampilkan ..!");
	$no=0;
	$lihatData = mysql_fetch_array($lihatQry);
	  $no++;
	  $KodeBarang= $lihatData['kd_barang'];
	  $KodeKategori = $lihatData['kd_kategori'];
	  	  
	  // Membaca gambar utama
	  if ($lihatData['file_gambar']=="") {
			$fileGambar = "noimage.jpg";
	  }
	  else {
			$fileGambar	= $lihatData['file_gambar'];
	  }
} 
else {
	// Jika variabel Kode tidak ada di URL
	echo "Kode barang tidak ada ";
	
	// Refresh
	echo "<meta http-equiv='refresh' content='2; url=index.php'>";
	exit;
}
?>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td width="19%">
	<img src="img-barang/<?php echo $fileGambar; ?>" width="200" border="0" /><br />
    <div class='harga'>Rp. <?php echo format_angka($lihatData['harga_jual']); ?> </div> <br />
    <a href="?open=Barang-Beli&Kode=<?php echo $KodeBarang; ?>" class="button orange small"> <strong>Beli</strong></a> </td>
    <td width="81%" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="3"><strong>DETAIL BARANG </strong></td>
        </tr>
      <tr>
        <td width="23%"><strong>Nama </strong></td>
        <td width="1%">:</td>
        <td width="76%"> <?php echo $lihatData['nm_barang']; ?> </td>
      </tr>
      <tr>
        <td><strong>Harga (Rp.)</strong></td>
        <td>:</td>
        <td> <?php echo format_angka($lihatData['harga_jual']); ?> </td>
      </tr>
      <tr>
        <td><strong>Stok</strong></td>
        <td>:</td>
        <td> <?php echo $lihatData['stok']; ?> </td>
      </tr>
      <tr>
        <td><strong>Kategori </strong></td>
        <td>:</td>
        <td> <?php echo $lihatData['nm_kategori']; ?> </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3"><?php echo $lihatData['keterangan']; ?></td>
        </tr>
    </table> </td>
  </tr>
</table>
<?php include "barang_lainnya.php"; ?>