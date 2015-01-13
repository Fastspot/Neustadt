<?
	
	/*
		Tralate Wordpress to Dogwood, including categories, tags and comments
	*/
	
	function import_posts() {
		$keys = array(
			"author",
			"date",
			"title",
			//"blurb",
			"content",
			"route",
			"wp_content",
			"wp_id"
		);
		$count = 0;
		
		$q = sqlquery("SELECT * FROM wp_posts WHERE post_status = 'publish' AND post_type = 'post'");
		while ($f = sqlfetch($q)) {
			$author_id = ($f['post_author'] == 2) ? 2 : 1;
		
			$old_content = $f['post_content'];
			$new_content = preg_replace("/(\\[caption.*\\[\\/caption\\])/um", "", $f['post_content']);			
			$new_content = strip_tags($new_content, "<html><body><div><span><applet><object><iframe><h1><h2><h3><h4><h5><h6><p><blockquote><pre><a><abbr><acronym><address><big><cite><code><del><dfn><em><ins><kbd><q><s><samp><small><strike><strong><sub><sup><tt><var><b><u><i><center><dl><dt><dd><ol><ul><li><fieldset><form><label><legend><table><caption><tbody><tfoot><thead><tr><th><td><article><aside><canvas><details><embed><figure><figcaption><footer><header><hgroup><menu><nav><output><ruby><section><summary><time><mark><audio><video><article><aside><details><figcaption><figure><footer><header><hgroup><menu><nav><section><ol><ul><blockquote><table>");
			$new_content = preg_replace("/(<a\\s*href=[a-z|A-Z|0-9|\\/|:|-|.|\"|\+|\_]*(wp-content)[a-z|A-Z|0-9|\\/|:|\\-|.|\"|\+|\_]*>[^<^>]*<\\/a>)/um", "", $new_content);
			$new_content = wpautop($new_content);
			
			$values = array(
				$author_id,
				$f["post_date"], 
				sqlescape($f["post_title"]), 
				//sqlescape(BigTree::trimLength(strip_tags($new_content),255)), 
				sqlescape($new_content),
				sqlescape($f["post_name"]), 
				sqlescape($old_content), 
				$f["ID"]
			);
			sqlquery("INSERT INTO btx_dogwood_posts (" . implode(",", $keys) . ") values ('" . implode("','", $values) . "') ");
			$count++;
		}
		
		return $count . " posts imported";
	}
	//$result = import_posts();
	//echo $result;
	
	
	function import_categories() {
		$count = 0;
		$keys = array(
			"title",
			"route",
			"wp_id"
		);
		
		$q = sqlquery("SELECT c.*, t.term_taxonomy_id FROM wp_terms AS c, wp_term_taxonomy AS t WHERE c.term_id = t.term_id and t.taxonomy = 'category'");
		while ($f = sqlfetch($q)) {
			$values = array(
				sqlescape($f["name"]),
				sqlescape($f["slug"]),
				$f["term_taxonomy_id"]
			);
			sqlquery("INSERT INTO btx_dogwood_categories (" . implode(",", $keys) . ") values ('" . implode("','", $values) . "') ");
			$count++;
		}
		return $count . " categories imported";
	}
	//$result = import_categories();
	//echo $result;
	
	
	function relate_categories_to_posts() {
		$count = 0;
		
		$q = sqlquery("SELECT r.*, p.id as id FROM wp_term_relationships as r, btx_dogwood_posts as p WHERE r.object_id = p.wp_id");
		while ($f = sqlfetch($q)) {
			$newCategory = sqlfetch(sqlquery("SELECT * FROM btx_dogwood_categories WHERE wp_id = " . $f['term_taxonomy_id']));
			
			if ($newCategory['id']) {
				$count++;
				
				sqlquery("INSERT INTO btx_dogwood_post_categories (`post`, `category`) values (" . $f["id"] . ", " . $newCategory["id"] . ")");
			}
		}
		
		return $count . " categories related to posts";
	}
	//$result = relate_categories_to_posts();
	//echo $result;
	
	
	function import_tags() {
		$count = 0;
		$keys = array(
			"tag",
			"metaphone",
			"route",
			"wp_id"
		);
		
		$q = sqlquery("SELECT c.*, t.term_taxonomy_id FROM wp_terms AS c, wp_term_taxonomy AS t WHERE c.term_id = t.term_id and t.taxonomy = 'post_tag'");
		while ($f = sqlfetch($q)) {
			$values = array(
				sqlescape($f["name"]),
				sqlescape(metaphone($f["name"])),
				sqlescape($f["slug"]),
				$f["term_taxonomy_id"]
			);
			sqlquery("INSERT INTO bigtree_tags (" . implode(",", $keys) . ") values ('" . implode("','", $values) . "') ");
			$count++;
		}
		return $count . " tags imported";
	}
	//$result = import_tags();
	//echo $result;
	
	
	function relate_tags_to_posts() {
		$count = 0;
		
		$q = sqlquery("SELECT r.*, p.id as id FROM wp_term_relationships as r, btx_dogwood_posts as p WHERE r.object_id = p.wp_id");
		while ($f = sqlfetch($q)) {
			$newTag = sqlfetch(sqlquery("SELECT * FROM bigtree_tags WHERE wp_id = " . $f['term_taxonomy_id']));
			
			if ($newTag['id']) {
				$count++;
				
				sqlquery("INSERT INTO bigtree_tags_rel (`table`, `entry`, `tag`) values ('btx_dogwood_posts', " . $f["id"] . ", " . $newTag["id"] . ")");
			}
		}
		
		return $count . " tags related to posts";
	}
	//$result = relate_tags_to_posts();
	//echo $result;
	
	
	function import_comments() {
		$count = 0;
		$keys = array(
			"comment",
			"author",
			"email",
			"ip",
			"date",
			"approved",
			"wp_id",
			"wp_id_parent",
			"wp_id_post"
		);
		
		$q = sqlquery("SELECT * FROM wp_comments WHERE comment_approved = '1' ORDER BY comment_ID ASC");
		while ($f = sqlfetch($q)) {
			$values = array(
				sqlescape($f["comment_content"]),
				sqlescape($f["comment_author"]),
				sqlescape($f["comment_author_email"]),
				sqlescape($f["ip"]),
				$f["comment_date"],
				"on",
				$f["comment_ID"],
				$f["comment_parent"],
				$f["comment_post_ID"]
			);
			sqlquery("INSERT INTO btx_dogwood_comments (" . implode(",", $keys) . ") values ('" . implode("','", $values) . "') ");
			$count++;
		}
		return $count . " comments imported";
	}
	//$result = import_comments();
	//echo $result;
	
	
	function fix_comment_parents() {
		$count = 0;
		
		$q = sqlquery("SELECT * FROM btx_dogwood_comments WHERE wp_id_parent != 0 id ASC");
		while ($f = sqlfetch($q)) {
			$newParent = sqlfetch(sqlquery("SELECT * FROM btx_dogwood_comments WHERE wp_id = " . $f["wp_id_parent"]));
			
			sqlquery("UPDATE btx_dogwood_comments SET parent = " . $newParent["id"] . " WHERE id = " . $f["id"]);
			$count++;
		}
		return $count . " comment parents fixed";
	}
	//$result = fix_comment_parents();
	//echo $result;
	
	
	function relate_comments_to_posts() {
		$count = 0;
		
		$q = sqlquery("SELECT * FROM btx_dogwood_comments ORDER BY id ASC");
		while ($f = sqlfetch($q)) {
			$newPost = sqlfetch(sqlquery("SELECT * FROM btx_dogwood_posts WHERE wp_id = " . $f["wp_id_post"]));
			
			sqlquery("UPDATE btx_dogwood_comments SET post = " . $newPost["id"] . " WHERE id = " . $f["id"]);
			$count++;
		}
		return $count . " comments related to posts";
	}
	//$result = relate_comments_to_posts();
	//echo $result;
	
	
	print_r($bigtree["sql"]["errors"]);
	
	
	// Wordpress Helpers
	function wpautop($pee, $br = 1) {
		if ( trim($pee) === '' )
			return '';
		$pee = $pee . "\n"; // just to make things a little easier, pad the end
		$pee = preg_replace('|<br />\s*<br />|', "\n\n", $pee);
		// Space things out a little
		$allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|option|form|map|area|blockquote|address|math|style|input|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';
		$pee = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $pee);
		$pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);
		$pee = str_replace(array("\r\n", "\r"), "\n", $pee); // cross-platform newlines
		if ( strpos($pee, '<object') !== false ) {
			$pee = preg_replace('|\s*<param([^>]*)>\s*|', "<param$1>", $pee); // no pee inside object/embed
			$pee = preg_replace('|\s*</embed>\s*|', '</embed>', $pee);
		}
		$pee = preg_replace("/\n\n+/", "\n\n", $pee); // take care of duplicates
		// make paragraphs, including one at the end
		$pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);
		$pee = '';
		foreach ( $pees as $tinkle )
			$pee .= '<p>' . trim($tinkle, "\n") . "</p>\n";
		$pee = preg_replace('|<p>\s*</p>|', '', $pee); // under certain strange conditions it could create a P of entirely whitespace
		$pee = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $pee);
		$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee); // don't pee all over a tag
		$pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee); // problem with nested lists
		$pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
		$pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);
		$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);
		$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);
		if ($br) {
			$pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', '_autop_newline_preservation_helper', $pee);
			$pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee); // optionally make line breaks
			$pee = str_replace('<WPPreserveNewline />', "\n", $pee);
		}
		$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
		$pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
		if (strpos($pee, '<pre') !== false)
			$pee = preg_replace_callback('!(<pre[^>]*>)(.*?)</pre>!is', 'clean_pre', $pee );
		$pee = preg_replace( "|\n</p>$|", '</p>', $pee );
	
		return $pee;
	}
	function _autop_newline_preservation_helper( $matches ) {
		return str_replace("\n", "<WPPreserveNewline />", $matches[0]);
	}
	
	
?>