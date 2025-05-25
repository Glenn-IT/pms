<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<style>
	.inmate-img{
		width:3em;
		height:3em;
		object-fit:cover;
		object-position:center center;
	}
</style>