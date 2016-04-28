<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td colspan="2" bgcolor="#CCCCCC"><strong>KOLEKSI BARANG SEJENIS</strong></td>
  </tr>
<?php 
// Menampilkan daftar barang
$barangSql = "SELECT barang.*,  kategori.nm_kategori FROM barang 
			LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori 
			WHERE barang.kd_kategori='$KodeKategori' AND barang.kd_barang != '$Kode' 
			ORDER BY barang.kd_barang ASC LIMIT 5"; 
$barangQry = mysql_query($barangSql, $koneksidb) or die ("Gagal Query".mysql_error()); 
$nomor = 0;
while ($barangData = mysql_fetch_array($barangQry)) {
	$nomor++;
	
	// Membaca file gambar
	if ($barangData['file_gambar']=="") {
		$fileGambar = "noimage.jpg";
	}
	else {
		$fileGambar	= $barangData['file_gambar'];
	}
?>
  <tr>
    <td width="24%"><a href="?open=Barang-Lihat&Kode=<?php echo $KodeBarang; ?>"><img src="img-barang/<?php echo $fileGambar; ?>" width="100" border="0"> </a> <br>
      <div class='harga'>Rp. <?php echo format_angka($barangData['harga_jual']); ?> </div><br>
    <a href="?open=Barang-Beli&Kode=<?php echo $KodeBarang; ?>" class="button orange small"> <strong>Beli</strong></a> </td>
    <td width="76%">
	  <a href="?open=Barang-Lihat&Kode=<?php echo $KodeBarang; ?>">
      <div class='judul'> <?php echo $barangData['nm_barang']; ?> </div>
      </a>
      
	  <p><?php echo substr($barangData['keterangan'], 0, 200); ?> ....</p>
      <p><strong>Stok :</strong> <?php echo $barangData['stok']; ?> </p>
    <strong>Kategori :</strong> <a href="?open=Kategori-Barang&Kode=<?php echo $KodeKategori; ?>"> <?php echo $barangData['nm_kategori']; ?> </a> </td>
  </tr>
<?php } ?>
</table>
