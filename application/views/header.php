<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nivelman Hesabı</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.min.css" />
<style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
</style>
<script type="text/javascript" src="<?php echo base_url(); ?>java_scripts/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>java_scripts/bootstrap-dropdown.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>java_scripts/bootstrap-modal.js"></script>
</head>
<body>
    <div class="navbar navbar-fixed-top">
	    <div class="navbar-inner">
		    <div class="container">
		    	    <a class="brand" href="#">Nivelman Hesabı</a>
		    	    <ul class="nav">
<?php 
if ($this->gu_session->isLogged()):
?>
						<li><a href="<?php echo site_url("levelling/new_project"); ?>">Yeni Proje</a></li>
						<li><a href="<?php echo site_url("user/projects"); ?>">Projeler</a></li>
						<li><a href="<?php echo site_url("user/logout"); ?>">Oturumu Kapat</a></li>
<?php else: ?>
						<li class="dropdown">
			              <a data-toggle="dropdown" class="dropdown-toggle" href="#">Oturum Aç <b class="caret"></b></a>
			              <ul style="margin:0px" class="dropdown-menu">
			                <li><a href="<?php echo base_url(); ?>user/login_with_google">Google ile Oturum Açın</a></li>
				    		<li><a href="<?php echo base_url(); ?>user/login_with_myopenid">myOpenID ile Oturum Açın</a></li>
			              </ul>
			            </li>
<?php endif; ?>
					</ul>
		    </div>
	    </div>
    </div>
    <div class="container">