<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<style>
    .user-avatar{
        width:3rem;
        height:3rem;
        object-fit:scale-down;
        object-position:center center;
    }
</style>

<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">This Page is Under Construction</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<p>Hello, Under Construction! 🏗️👷👷‍♀️</p>
		</div>
	</div>
</div>
