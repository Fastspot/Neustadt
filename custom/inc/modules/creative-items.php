<?
	class NCMCreativeItems extends BigTreeModule {

		var $Table = "ncm_creative_items";
		var $Module = "4";
		
		function get($item) {
			$item = parent::get($item);
			
			$item["related"] = array();
			$q = sqlquery("SELECT i.* FROM ncm_creative_items AS i, ncm_creative_items_to_items AS rel WHERE rel.item1 = ".$item["id"]." AND rel.item2 = i.id ORDER BY rel.position DESC");
			while ($f = sqlfetch($q)) {
				$f = parent::get($f);
				$f["client"] = parent::get(sqlfetch(sqlquery("SELECT * FROM ncm_clients WHERE id = ".$f["client"]." LIMIT 1")));
				$f["type"] = parent::get(sqlfetch(sqlquery("SELECT * FROM ncm_creative_subcategories WHERE id = ".$f["type"]." LIMIT 1")));
				$item["related"][] = $f;
			}
			
			$item["client"] = parent::get(sqlfetch(sqlquery("SELECT * FROM ncm_clients WHERE id = ".$item["client"]." LIMIT 1")));
			$item["type"] = parent::get(sqlfetch(sqlquery("SELECT * FROM ncm_creative_subcategories WHERE id = ".$item["type"]." LIMIT 1")));
			$item["category"] = parent::get(sqlfetch(sqlquery("SELECT * FROM ncm_creative_categories WHERE subcategories LIKE '%\"".$item["type"]["id"]."\"%' LIMIT 1")));
			
			return $item;
		}
		
		function getByCategories($cats){
			$items = array();
			$q = sqlquery("SELECT * FROM " . $this->Table . " WHERE archived = '' AND (type = " . implode(' OR type = ', $cats) . ") ORDER BY REPLACE(descriptive_title,'The ','') ASC");
			while ($f = sqlfetch($q)) {
				$items[] = $this->get($f);
			}
			return $items;
		}
		
/*
		function getByIDs($ids){
			$items = array();
			$q = sqlquery("SELECT * FROM " . $this->Table . " WHERE id = " . implode(' OR id = ', $ids) . " ORDER BY position DESC");
			while ($f = sqlfetch($q)) {
				$items[] = $this->get($f);
			}
			return $items;
		}
*/
	}
?>
