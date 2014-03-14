<section class="title">
	<h4>Units</h4>
</section>

<section class="item">
<? if (!empty($units)) { ?>
<div id="filter-stage">
			<table border="0" class="table-list">
				<thead>
					<tr>
						<th>Name</th>
						<th>Path</th>
						<th width="200">Manage</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="8">
							<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
						</td>
					</tr>
				</tfoot>
				<tbody>
					<?php foreach ($units as $unit): ?>
						<tr>
							<td class="collapse"><?= $unit->name ?></td>
							<td class="collapse"><?= $unit->path ?></td>
							<td class="actions">
								<?= anchor('admin/adldap/units/delete/' . $unit->id, lang('global:delete'), array('class'=>'button delete')); ?>
                                                                <?= anchor('admin/adldap/units/edit/' . $unit->id, lang('global:edit'), array('class'=>'button edit')); ?>
							</td>
							</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
</div>
<? } else { ?>
    <div class="no_data">No units</div>
<? } ?>

</section>