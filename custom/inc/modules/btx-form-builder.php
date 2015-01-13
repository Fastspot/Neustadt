<?
	class BTXFormBuilder extends BigTreeModule {
		var $Table = "btx_form_builder_forms";
		
		function get($id) {
			$id = sqlescape($id);
			$form = sqlfetch(sqlquery("SELECT * FROM btx_form_builder_forms WHERE id = '$id'"));
			$fields = array();
			$q = sqlquery("SELECT * FROM btx_form_builder_fields WHERE form = '$id' AND `column` = '0' ORDER BY position DESC, id ASC");
			while ($f = sqlfetch($q)) {
				if ($f["type"] == "column") {
					// Get left column
					$subfields = array();
					$qq = sqlquery("SELECT * FROM btx_form_builder_fields WHERE `column` = '".$f["id"]."' AND `alignment` = 'left' ORDER BY position DESC, id ASC");
					while ($ff = sqlfetch($qq)) {
						$subfields[] = $ff;
					}
					$f["fields"] = $subfields;
					$fields[] = $f;
					// Get right column
					$subfields = array();
					$qq = sqlquery("SELECT * FROM btx_form_builder_fields WHERE `column` = '".$f["id"]."' AND `alignment` = 'right' ORDER BY position DESC, id ASC");
					while ($ff = sqlfetch($qq)) {
						$subfields[] = $ff;
					}
					$f["fields"] = $subfields;
					$fields[] = $f;
				} else {
					$fields[] = $f;				
				}
			}
			$form["fields"] = $fields;
			return $form;
		}
		
		function getAll($sort = "id ASC") {
			$items = array();
			$q = sqlquery("SELECT * FROM btx_form_builder_forms ORDER BY $sort");
			while ($f = sqlfetch($q)) {
				$items[] = $f;
			}
			return $items;
		}
		
		function getEntries($id) {
			global $cms;
			$items = array();
			$q = sqlquery("SELECT * FROM btx_form_builder_entries WHERE form = '".sqlescape($id)."' ORDER BY id DESC");
			while ($f = sqlfetch($q)) {
				$f["data"] = json_decode($f["data"],true);
				foreach ($f["data"] as $key => $val) {
					$f["data"][$key] = $cms->replaceRelativeRoots($val);
				}
				$items[] = $f;
			}
			return $items;
		}
		
		function getEntry($id) {
			global $cms;
			$item = sqlfetch(sqlquery("SELECT * FROM btx_form_builder_entries WHERE id = '".sqlescape($id)."'"));
			$item["data"] = json_decode($item["data"],true);
			foreach ($item["data"] as $key => $val) {
				$item["data"][$key] = $cms->replaceRelativeRoots($val);
			}
			return $item;
		}
		
		function searchEntries($id,$query,$page = 0) {
			global $cms;
			$items = array();
			$qparts = explode(" ",$query);
			$query = "SELECT * FROM btx_form_builder_entries WHERE form = '".sqlescape($id)."'";
			foreach ($qparts as $part) {
				$query .= " AND data LIKE '%".sqlescape($part)."%'";
			}

			$q = sqlquery($query." ORDER BY id DESC LIMIT ".($page * 15).",15");
			while ($f = sqlfetch($q)) {
				$f["data"] = json_decode($f["data"],true);
				foreach ($f["data"] as $key => $val) {
					$f["data"][$key] = $cms->replaceRelativeRoots($val);
				}
				$items[] = $f;
			}
			
			$pages = ceil(sqlrows(sqlquery($query)) / 15);
			if ($pages == 0) {
				$pages = 1;
			}
			
			return array($pages,$items);
		}
	}
?>
