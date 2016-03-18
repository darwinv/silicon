<header class="header">
<?php
if (! isset ( $_SESSION )) {
	session_start ();
}
if (isset ( $_SESSION ["id"] )) {
	include ("menu-top-usr.php");
} else {
	include ("menu-top.php");
}

?>
</header>