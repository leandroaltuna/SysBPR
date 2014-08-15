<?php 
	
	$this->load->view('frontend/includes/header');

	$this->load->view('frontend/includes/navbar');

?>
		<div class="wrapper row-offcanvas row-offcanvas-left">
			<?php $this->load->view('frontend/includes/sidebar'); ?>
			<aside class="right-side">
				<?php $this->load->view($main_content); ?>
			</aside>
		</div>
<?php 
	$this->load->view('frontend/includes/footer');
?>