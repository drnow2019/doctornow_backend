<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style>
   .control-label { padding: 18px; }
   .progress-bar {
    background-color: #133653 !important;
}
</style>
<link href="<?=base_url('assets/style.css');?>" rel="stylesheet">
<div class="container">
	<div class="msg" id="msg">
		<?php if($this->session->flashdata('msg')): echo $this->session->flashdata('msg'); endif; ?>
	</div>

	<div class="ava-a" align="center">
		<img src="<?=base_url('error/404.jpg')?>">

	</div>
</div>
