<?php
session_start();
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
?>
<html>
<head>
<title>Toko Baju Hemat Online - Toko Baju Terlengkap</title>
<meta name="robots" content="index, follow">
<link href="style/styles_user.css" rel="stylesheet" type="text/css">
<link href="style/button.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js.popupWindow.js"></script>
</head>
<body>
<table width="800" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td colspan="2" bgcolor="black">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><img src="images/header.png" width="800" height="178"></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><a href="?open=Home" target="_self"><strong>HOME</strong></a> | <a href="?open=Profil" target="_self"><strong>PROFIL</strong></a> | <a href="?open=Barang" target="_self"><strong>BARANG</strong></a> | <a href="?open=Panduan" target="_self"><strong>PANDUAN</strong></a> | <a href="?open=Konfirmasi" target="_self"><strong>KONFIRMASI</strong></a> </td>
  </tr>
  <tr>
    <td colspan="2" align="right" bgcolor="black"><form name="form1" method="post" action="?open=Barang-Pencarian">
      <strong>Cari Barang :</strong> 
      <input name="txtKeyword" type="text" size="30" maxlength="100">
        <input type="submit" name="btnCari" value=" Cari ">
    </form>
    </td>
  </tr>
  <tr>
  <div class="kiri">
    <td width="182" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td bgcolor="#CCCCCC"><strong>Selamat Datang </strong></td>
        </tr>
        <tr>
          <td><?php echo date('d-m-Y') ?></td>
        </tr>
        <tr>
          <td bgcolor="#CCCCCC"><strong>Kontak</strong></td>
        </tr>
        <tr>
          <td>081234567890</td>
        </tr>
        <tr>
          <td><?php if(file_exists ("login.php")) { include "login.php"; }  else { echo "file login.php belum ada"; } ?> </td>
        </tr>
        <tr>
          <td bgcolor="#CCCCCC"><strong>KATEGORI</strong></td>
        </tr>
         <?php
		  $mySql = "SELECT * FROM kategori ORDER BY nm_kategori";
		  $myQry = mysql_query($mySql, $koneksidb) or die ("Query salah : ".mysql_error());
		  while($myData = mysql_fetch_array($myQry)) {
		      $Kode = $myData['kd_kategori'];
		  ?>
        <tr>
          <td> <?php echo "<a href=?open=Barang-Kategori&Kode=$Kode>$myData[nm_kategori]</a>"; ?> </td>
        </tr>
		<?php } ?>
    </table>
    </td>
    <td width="603" valign="top" bgcolor="#FFFFFF"><?php include "buka_file.php"; ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center" bgcolor="#F5F5F5"><span class="FOOT">Copyright &copy; 2016<br>
Toko Baju Online</span></td>
  </tr>
</table>
</body>
</html>
