<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>
<style type="text/css">
.error-template {padding: 40px 15px;text-align: center;}
.error-actions {margin-top:15px;margin-bottom:15px;}
.error-actions .btn { margin-right:10px; }
</style>
</head>
<body>
	<div id="container">
	<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="container">
    <div class="row">
    <div class="error-template">
	    <h1>Oops!</h1>
		<img src="error/404.jpg">
	    <h2>404 Not Found</h2>
	    <div class="error-details">
		Sorry, an error has occured, Requested page not found!<br>
		<?php echo CHtml::encode($message); ?>
	    </div>
	    <div class="error-actions">
		<a href="<?php echo Yii::app()->request->baseUrl; ?>" class="btn btn-primary">
		    <i class="icon-home icon-white"></i> Take Me Home </a>
		<a href="mailto:me@null-byte.info" class="btn btn-default">
		    <i class="icon-envelope"></i> Contact Support </a>
	    </div>
	</div>
    </div>
</div>
	
	
	
	
	
	
	
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
	</div>
</body>
</html>