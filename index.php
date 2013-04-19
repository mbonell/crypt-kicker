<?php
/**
 * The entry point
 */
	include_once('controllers/IndexController.php');
	include_once('library/Decrypt.php');
	mb_internal_encoding("UTF-8");

	$index = new IndexController();
	$index->index();
?>
