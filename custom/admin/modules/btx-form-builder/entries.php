<?
	$action_title = "View Entries";
	
	$form = $fb->get(end($path));
	// Figure out what the headers should be…
	$columns = array();
	function _form_builder_get_table_header($fields) {
		global $columns;
		foreach ($fields as $field) {
			$t = $field["type"];
			$fdata = unserialize($field["data"]);
			$label = $fdata["label"];
			if (!$label) {
				$label = ucwords($t);
			}
			
			$label = $label;
			
			if ($t == "column") {
				_form_builder_get_table_header($field["fields"]);
			} elseif ($t == "address") {
				$columns[] = $label." - Street";
				$columns[] = $label." - Street 2";
				$columns[] = $label." - City";
				$columns[] = $label." - State";
				$columns[] = $label." - Zip";
				$columns[] = $label." - Country";
			} elseif ($t == "name") {
				$columns[] = $label." - First";
				$columns[] = $label." - Last";
			} elseif ($t != "section") {
				$columns[] = $label;
			}
		}
	}
	_form_builder_get_table_header($form["fields"]);
	$columns = array_slice($columns,0,4);
	
	$pages = ceil(sqlrows(sqlquery("SELECT id FROM btx_form_builder_entries WHERE form = '".$form["id"]."'")) / 15);
	if ($pages == 0) {
		$pages = 1;
	}
?>
<h2>Entries in &ldquo;<?=$form["title"]?>&rdquo;</h2>
<br class="clear" />
<div class="table">
	<summary>
		<input type="search" placeholder="Search" class="form_search" id="search" />
		<ul id="view_paging" class="view_paging"></ul>
	</summary>
	<header>
		<span class="view_column" style="width: 114px;">Date Submitted</span>
		<? foreach ($columns as $column) { ?>
		<span class="view_column" style="width: 155px;"><?=$column?></span>
		<? } ?>
		<span class="view_action">View</span>
		<span class="view_action">Delete</span>
	</header>
	<ul id="results">
		<? include BigTree::path("admin/ajax/btx-form-builder/entries-page.php") ?>
	</ul>
</div>
<script type="text/javascript">
	var deleteConfirm,deleteTimer,deleteId,searchTimer;

	$("#search").keyup(function() {
		clearTimeout(searchTimer);
		searchTimer = setTimeout("_local_search();",400);
	});
	
	$(".table").on("click",".icon_delete",function() {
		new BigTreeDialog("Delete Item",'<p class="confirm">Are you sure you want to delete this entry?</p>',$.proxy(function() {
			$.ajax("<?=$admin_root?>ajax/btx-form-builder/delete-entry/?form=<?=$form["id"]?>&id=" + BigTree.CleanHref($(this).attr("href")));
		},this),"delete",false,"OK");

		return false;
	}).on("click","#view_paging a",function() {
		mpage = BigTree.CleanHref($(this).attr("href"));
		search = escape($("#search").val());
		if ($(this).hasClass("active") || $(this).hasClass("disabled")) {
			return false;
		}
		$("#results").load("<?=$admin_root?>ajax/btx-form-builder/entries-page/?form=<?=$form["id"]?>&search=" + search + "&page=" + mpage);

		return false;
	});
	
	function _local_search() {
		search = escape($("#search").val());
		$("#results").load("<?=$admin_root?>ajax/btx-form-builder/entries-page/?form=<?=$form["id"]?>&page=0&&search=" + search);
	}
</script>