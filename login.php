<form name="frmLogin" method="post" action="?open=Login-Validasi">
<table width="100%" border="0" cellspacing="1" cellpadding="3">
<?php
if (! isset($_SESSION['SES_PELANGGAN'])) {
   // Jika belum Login, maka form Login ditampilkan
?> 
  <tr>
    <td bgcolor="#CCCCCC"><b>LOGIN</b></td>
  </tr>
  <tr>
    <td><strong>Username : </strong><br>
      <input name="txtUsername" type="text"  size="20" maxlength="30">
    </td>
  </tr>
  <tr>
    <td><strong>Password : </strong><br>
    <input name="txtPassword" type="password" size="20" maxlength="30"></td>
  </tr>
  <tr>
    <td><input type="submit" name="btnLogin" value="Login" /> </td>
  </tr>
  <tr>
    <td><a href="?open=Pelanggan-Baru" target="_self">Pendaftaran Baru </a></td>
  </tr>
<?php 
}
else { 
  // Jika sudah Login, maka menu Pelanggan ditampilkan
?>
  <tr>
    <td bgcolor="#CCCCCC"><b>TRANSAKSI</b></td>
  </tr>
  <tr>
    <td><a href="?open=Keranjang-Belanja" target="_self">Keranjang Belanja </a></td>
  </tr>
  <tr>
    <td><a href="?open=Transaksi-Tampil" target="_self">Tampilkan Transaksi </a></td>
  </tr>
  <tr>
    <td><a href="login_out.php" target="_self">Logout</a></td>
  </tr>
<?php } ?>
</table>
</form>