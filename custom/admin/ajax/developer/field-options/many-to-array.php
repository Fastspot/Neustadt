<h4>Many To JSON</h4>
<fieldset>
	<label>Source Table</label>
	<select name="mta-table" class="table_select">
		<option></option>
		<? BigTree::getTableSelectOptions($data["mta-table"]) ?>
	</select>
</fieldset>
<fieldset>
	<label>Descriptor</label>
	<div data-name="mta-descriptor" class="pop-dependant mta-table">
		<? if ($data["mta-table"]) { ?>
		<select name="mta-descriptor"><? BigTree::getFieldSelectOptions($data["mta-table"],$data["mta-descriptor"]) ?></select>
		<? } else { ?>
		<small>-- Please choose a table. --</small>
		<? } ?>
	</div>
</fieldset>
<fieldset>
	<label>Sort By</label>
	<div data-name="mta-sort" class="sort_by pop-dependant mta-table">
		<? if ($data["mta-table"]) { ?>
		<select name="mta-sort"><? BigTree::getFieldSelectOptions($data["mta-table"],$data["mta-sort"],true) ?></select>
		<? } else { ?>
		<small>-- Please choose a table. --</small>
		<? } ?>
	</div>
</fieldset>
<br />