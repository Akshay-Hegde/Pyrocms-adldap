<h1><?= $module_details['name']; ?></h1>
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
		$('[id^=check_]').hide();
	    });
    });
    
    $('#units_dropdown').prop('disabled', true);
    $('#button_dropdown').prop('disabled', true);
    
    $('[id^=check_]').change(function(){
	var checked = $('[id^=check_]').is(':checked') ? 1 : 0;
	if (checked == 0) {
	    $('#units_dropdown').prop('disabled', true);
	    $('#button_dropdown').prop('disabled', true);
	} else if (checked == 1) {
	    $('#button_dropdown').prop('disabled', false);
	    $('#units_dropdown').prop('disabled', false);
	}
    });

	
});
</script>
<section>
<form id="live-search" class="simple">
    <p>Enter a computer name:</p><input type="text" class="text-input" id="filter" value="" />
    <span id="filter-count"></span>
</form>
<?= form_open('adldap/frontend/move', 'class="crud"');?>
		<div class="tabsblock">
			<ul class="tabs">
				<? foreach ($result as $unit) { ?>
				<? if ($unit['id'] == 0) { ?>
                                <li name="<?= $unit['id'] ?>" class="active">
                                <? } else {?>
                                <li name="<?= $unit['id'] ?>">
                                <? } ?>
					<a href="#<?= $unit['id'] ?>">
						<span><?= $unit['name'] ?></span>
					</a>
				</li>
				<? } ?>
			</ul>
				<? foreach ($result as $unit) { ?>
				<? if ($unit['id'] == 0) { ?>
                                <div id="tab_<?= $unit['id'] ?>" class="info"  style="height: 300px; width: 100%; overflow: auto;">
                                <? } else {?>
                                <div id="tab_<?= $unit['id'] ?>" class="info hidden"  style="height: 300px; width: 100%; overflow: auto;">
                                <? } ?>
					<fieldset>
						<ul class="s">
							<? foreach ($unit['info'] as $key => $value) { ?>
							<li>
								<? if (!empty($value["samaccountname"][0])) { ?>
									<div id="comp_<?=$key;?>">
										<?= $value["samaccountname"][0]; ?>
										<?= form_checkbox('computer[]', $value["samaccountname"][0], FALSE, 'id="check_'.$key.'"'); ?>
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
<?= form_dropdown('units', $unitz, NULL, 'id="units_dropdown"'); ?>
<div>
    <button type="submit" class="btn blue" id="button_dropdown"><span>Replace</span></button>
		</div>
<?= form_close(); ?>
</section>