<?

	if (!is_array($field["value"])) {
		$field["value"] = array();
	}
	
	$entries = array();
	foreach ($field["value"] as $id) {
		$f = sqlfetch(sqlquery("SELECT `id`, `".$options["mta-descriptor"]."` FROM `".$options["mta-table"]."` WHERE id = ".$id." LIMIT 1"));
		$entries[$f["id"]] = $f[$options["mta-descriptor"]];
	}

	// Gather a list of the items that could possibly be tagged.
	$list = array();
	$q = sqlquery("SELECT `id`, `".$options["mta-descriptor"]."` FROM `".$options["mta-table"]."` ORDER BY ".$options["mta-sort"]);
	while ($f = sqlfetch($q)) {
		$list[$f["id"]] = $f[$options["mta-descriptor"]];
	}

	// Remove items from the list that have already been tagged.
	foreach ($entries as $k => $v) {
		unset($list[$k]);
	}

	// Get a key we can use in JavaScript
	//$clean_key = str_replace(array("[","]"),"_",$key);
	
	// A count of the number of entries
	$x = 0;
	
	// Only show the field if there are items that could be tagged.
	//if (count($list)) {
?>
<div class="multi_widget many_to_many many_to_array" id="<?=$field["id"]?>">
	<section<? if (count($entries)) { ?> style="display: none;"<? } ?>>
		<p>No items have been tagged. Click "Add Item" to add an item to this list.</p>
	</section>
	<ul>
		<?
			foreach ($entries as $id => $description) {
		?>
		<li>
			<input type="hidden" name="<?=$field["key"]?>[<?=$x?>]" value="<?=htmlspecialchars($id)?>" />
			<span class="icon_sort"></span>
			<p><?=BigTree::trimLength(strip_tags($description),100)?></p>
			<a href="#" class="icon_delete"></a>
		</li>
		<?
				$x++;
			}
		?>
	</ul>
	<footer>
		<select>
			<? foreach ($list as $k => $v) { ?>
			<option value="<?=htmlspecialchars(htmlspecialchars_decode($k))?>"><?=htmlspecialchars(htmlspecialchars_decode(BigTree::trimLength(strip_tags($v),100)))?></option>
			<? } ?>
		</select>
		<a href="#" class="add button"><span class="icon_small icon_small_add"></span>Add Item</a>
	</footer>
</div>
<script>
// !BigTreeManyToArray
var BigTreeManyToArray = Class.extend({
	count: 0,
	field: false,
	key: false,
	sortable: false,
	
	init: function(id,count,key,sortable) {
		this.count = count;
		this.key = key;
		this.field = $("#" + id);
		if (sortable) {
			this.field.find("ul").sortable({ items: "li", handle: ".icon_sort" });
			this.sortable = true;
		}
		this.field.find(".add").click($.proxy(this.addItem,this));
		this.field.on("click",".icon_delete",this.deleteItem);
	},
	
	addItem: function() {
		select = this.field.find("select").get(0);
		val = select.value;
		text = select.options[select.selectedIndex].text;
		if (this.sortable) {
			li = $('<li><input type="hidden" name="' + this.key + '[' + this.count + ']" /><span class="icon_sort"></span><p></p><a href="#" class="icon_delete"></a></li>');
		} else {
			li = $('<li><input type="hidden" name="' + this.key + '[' + this.count + ']" /><p></p><a href="#" class="icon_delete"></a></li>');		
		}
		li.find("p").html(text);
		li.find("input").val(val);

		// Remove the option from the select.
		select.customControl.remove(val);
		
		this.field.find("ul").append(li);
		this.count++;
		// Hide the instructions saying there haven't been any items tagged.
		this.field.find("section").hide();

		return false;
	},
	
	deleteItem: function(e) {
		var widget = $(e.delegateTarget);
		select = widget.find("select").get(0);
		
		new BigTreeDialog("Delete Item",'<p class="confirm">Are you sure you want to delete this item?</p>',$.proxy(function() {
			// Add the option back to select.
			select.customControl.add($(this).parents("li").find("input").val(), $(this).parents("li").find("p").html());
			
			// If this is the last item we're removing, show the instructions again.
			if ($(this).parents("ul").find("li").length == 1) {
				$(this).parents("fieldset").find("section").show();
			}
			$(this).parents("li").remove();
		},this),"delete",false,"OK");

		return false;
	}
});
</script>
<script>
	new BigTreeManyToArray("<?=$field["id"]?>",<?=$x?>,"<?=$field["key"]?>",true);
</script>
<?
	//}
?>