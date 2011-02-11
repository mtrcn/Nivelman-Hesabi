<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nivelman Hesabı</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>java_scripts/jquery-1.4.4.min.js"></script>
</head>
<body>
<div id="container">
	<div id="holder" class="clearfix">
		<div id="logo">
			<h1>Nivelman Hesabı</h1>
	  	</div>
		<div id="navigation">
<?php 
if ($this->gu_session->isLogged()):
?>
			<ul>
				<li><a href="<?php echo site_url("levelling/new_project"); ?>">Yeni Proje</a></li>
				<li><a href="<?php echo site_url("user/projects"); ?>">Projeler</a></li>
				<li><a href="<?php echo site_url("user/account"); ?>">Hesabım</a></li>
			</ul>
<?php else: ?>
			<ul>
				<li><a href="http://www.geomatikuygulamalar.com/v2/user/login">Oturum Aç</a></li>
				<li><a href="http://www.geomatikuygulamalar.com/v2/store/application/<?php echo $this->config->item("appID"); ?>">Uygulama Sayfası</a></li>
			</ul>
<?php endif; ?>
	    </div>
		<div id="content">