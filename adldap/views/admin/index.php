<section class="title">
	<h4><?= $module_details['name']; ?></h4>
</section>
<script>
$(document).ready(function(){
    $("#filter").keyup(function(){
        var filter = $(this).val(), count = 0;
        $(".s li").each(function(){
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).fadeOut();
            } else {
                $(this).show();
                count++;
            }
        });
        var numberItems = count;
        $("#filter-count").text("result count = "+count);
    });
	$('[id^=dels_]').click(function(){
		var ids = $(this).attr("id");
		var computer = $(this).attr("computer");
		$.ajax({
		type: "POST",
		url: "/admin/adldap/delete",
		data: { c: computer }
		}).done(function(data){
			$('#' + ids).replaceWith('<span style="font-weight: bold; color: green;">OK</span>');
			});
	});
});
</script>
<section class="item">
	<form id="live-search">
		<fieldset>
			<input type="text" class="text-input" id="filter" value="" />
			<span id="filter-count"></span>
		</fieldset>
	</form>
	<?= form_open('admin/adldap/move', 'class="crud"');?>
		<div class="tabs">
			<ul class="tab-menu">
				<? foreach ($result as $unit) { ?>
				<li>
					<a href="#<?= $unit['id'] ?>" title="<?= $unit['id'] ?>">
						<span><?= $unit['name'] ?></span>
					</a>
				</li>
				<? } ?>
			</ul>
				<? foreach ($result as $unit) { ?>
				<div class="form_inputs" id="<?= $unit['id'] ?>">
					<fieldset>
						<ul class="s">
							<? foreach ($unit['info'] as $key => $value) { ?>
							<li>
								<? if (!empty($value["samaccountname"][0])) { ?>
									<div id="comp_<?=$key;?>">
										<?= $value["samaccountname"][0]; ?>
										<?= form_checkbox('computer', $value["samaccountname"][0]); ?>
										<button type="button" id="dels_<?=$key;?>" computer="<?= $value["samaccountname"][0]; ?>">delete</button>
									</div>							
								<? } ?>
							</li>
							<? } ?>
						</ul>
					</fieldset>
				</div>				
				<? } ?>
		</div>
		<div>
			<?= form_dropdown('units', $unitz); ?>
		</div>
		<div>
			<button type="submit" class="btn blue"><span>Replace</span></button>
		</div>
	<?= form_close(); ?>
</section>