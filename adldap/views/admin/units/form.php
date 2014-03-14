<section class="title">
	<h4>Edit a unit</h4>
</section>

<section class="item">
<?php echo form_open($form_url, 'class="crud"');?>
<table style="width: 450px; border: 1px solid #eee;">
	<tr>
		<td>Name:</td>
		<td><input type=text name="name" value="<?= (isset($unit->name)) ? $unit->name : ""; ?>"></td>
	</tr>
	<tr>
		<td>Path to unit:</td>
		<td><input type='text' name="path" value="<?= (isset($unit->path)) ? $unit->path : ""; ?>" class="frmPass"></td>
	</tr>
	<tr>
		<td colspan="2">
			<button class="btn blue" value="save" name="btnAction" type="submit"><span>Save</span></button>
				&nbsp;&nbsp;
			<a class="btn-more" href="/admin/adldap/units">Cancel</a>
		</td>
	</tr>
</table>

<?php 
 if(isset($unit->id)){
?>
<input type="hidden" name="id" value="<?= $unit->id; ?>">
<?php } ?>

<?php echo form_close(); ?>
</section>