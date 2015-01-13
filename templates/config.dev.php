<?
	// Time Zone
	date_default_timezone_set("America/New_York");

	// Set to false to stop all PHP errors/warnings from showing.
	$bigtree["config"]["debug"] = true;

	// Routing setup
	$bigtree["config"]["routing"] = "htaccess";

	// Database info.
	$bigtree["config"]["db"]["host"] = "localhost";
	$bigtree["config"]["db"]["name"] = "dev_ncm";
	$bigtree["config"]["db"]["user"] = "fastspot_dev";
	$bigtree["config"]["db"]["password"] = "fastspotdeadpets";
	$bigtree["config"]["sql_interface"] = "mysqli"; // Change to "mysql" to use legacy MySQL interface in PHP.

	// Separate write database info (for load balanced setups)
	$bigtree["config"]["db_write"]["host"] = "";
	$bigtree["config"]["db_write"]["name"] = "";
	$bigtree["config"]["db_write"]["user"] = "";
	$bigtree["config"]["db_write"]["password"] = "";

	// Setup the www_root and resource_root
	// Resource root must be on a different domain than www_root.  Usually we just remove the www. from the domain.
	$bigtree["config"]["domain"] = "http://dev.fastspot.com";
	$bigtree["config"]["www_root"] = str_replace(array("/var/www/vhosts/dev.fastspot.com/httpdocs/","/templates/config.php"),array("http://dev.fastspot.com/","/"),__FILE__);
	$bigtree["config"]["static_root"] = $bigtree["config"]["www_root"];
	$bigtree["config"]["admin_root"] = $bigtree["config"]["www_root"]."admin/";

	// Current Environment
	$bigtree["config"]["environment"] = "dev"; // "dev" or "live"; empty to hide
	$bigtree["config"]["environment_live_url"] = "http://www.ncmark.com"; // Site URL

	// Default Image Quality Presets
	$bigtree["config"]["image_quality"] = 90;
	$bigtree["config"]["retina_image_quality"] = 25;

	// The amount of work for the password hashing.  Higher is more secure but more costly on your CPU.
	$bigtree["config"]["password_depth"] = 8;
	// If you have HTTPS enabled, set to true to force admin logins through HTTPS
	$bigtree["config"]["force_secure_login"] = false;
	// Encryption key for encrypted settings
	$bigtree["config"]["settings_key"] = "dshshwegsdhsdhsdhsd";

	// Custom Output Filter Function
	$bigtree["config"]["output_filter"] = false;

	// Enable Simple Caching
	$bigtree["config"]["cache"] = false;
	// Use X-Sendfile headers to deliver cached files (more memory efficient, but your web server must support X-Sendfile headers) -- https://tn123.org/mod_xsendfile/
	$bigtree["config"]["xsendfile"] = false;

	// ReCAPTCHA Keys
	$bigtree["config"]["recaptcha"]["private"] = "6LcjTrwSAAAAADnHAf1dApaNCX1ODNuEBP1YdMdJ";
	$bigtree["config"]["recaptcha"]["public"] = "6LcjTrwSAAAAAKvNG6n0YtCROEWGllOu-dS5M5oj";

	// Base classes for BigTree.  If you want to extend / overwrite core features of the CMS, change these to your new class names
	// Set BIGTREE_CUSTOM_BASE_CLASS_PATH to the directory path (relative to /core/) of the file that will extend BigTreeCMS
	// Set BIGTREE_CUSTOM_ADMIN_CLASS_PATH to the directory path (relative to /core/) of the file that will extend BigTreeAdmin
	define("BIGTREE_CUSTOM_BASE_CLASS",false);
	define("BIGTREE_CUSTOM_ADMIN_CLASS",false);
	define("BIGTREE_CUSTOM_BASE_CLASS_PATH",false);
	define("BIGTREE_CUSTOM_ADMIN_CLASS_PATH",false);

	// ------------------------------
	// BigTree Resource Configuration
	// ------------------------------

	// Array containing all JS files to minify; key = name of compiled file
	// example: $bigtree["config"]["js"]["site"] compiles all JS files into "site.js"
	$bigtree["config"]["js"]["files"]["site"] = array(
		"../components/jquery/jquery.js",
		"../components/ba-dotimeout/jquery.ba-dotimeout.js",
		"../components/Rubberband/jquery.bp.rubberband.js",
		"../components/Boxer/jquery.fs.boxer.js",
		"../components/Naver/jquery.fs.naver.js",
		"../components/Picker/jquery.fs.picker.js",
		"../components/Selecter/jquery.fs.selecter.js",
		"../components/Mimeo/jquery.bp.mimeo.js",
		"../components/Sizer/jquery.fs.sizer.js",
		"../components/Roller/jquery.fs.roller.js",
		"jquery.fitvids.js",
		"jquery.fittext.js",
		"main.js",
		"webfont.1.4.2.min.js"
	);

	$bigtree["config"]["js"]["files"]["ie"] = array(
		"ie/html5.js",
		"ie/respond.min.js"
	);

	// Array containing variables to be replaced in compiled JS files
	// example: "variable_name" => "Variable Value" will replace all instances of $variable_name with 'Variable Value'
	$bigtree["config"]["js"]["vars"] = array(
		// "variable_name" => "Variable Value"
	);

	// Flag for JS minification
	$bigtree["config"]["js"]["minify"] = false;


	// Array containing all CSS files to minify; key = name of compiled file
	// example: $bigtree["config"]["css"]["site"] compiles all CSS files into "site.css"
	$bigtree["config"]["css"]["files"]["site"] = array(
		"../components/Sprout/sprout.css",
		"../components/Gridlock/gridlock-base.css",
		"../components/Gridlock/gridlock-12.css",
		"../components/Boxer/jquery.fs.boxer.css",
		"../components/Naver/jquery.fs.naver.css",
		"../components/Picker/jquery.fs.picker.css",
		"../components/Picker/jquery.fs.picker.css",
		"../components/Selecter/jquery.fs.selecter.css",
		"../components/Roller/jquery.fs.roller.css",
		"btx-form-builder.css",
		"main.css",
		"retina.css"
	);

	$bigtree["config"]["css"]["files"]["wysiwyg"] = array(
		"tinymce.css"
	);

	// Array containing variables to be replaced in compiled CSS files
	// example: "variable_name" => "Variable Value" will replace all instances of $variable_name with 'Variable Value'
	$bigtree["config"]["css"]["vars"] = array(
		"gray" => "#807263",
		"light_gray" => "#FAFAFA",
		"orange" => "#EA7700",

		"scala_regular" => "font-family: 'ScalaRegular','Scala','Palatino',serif; font-weight: normal; font-style: normal",
		"scala_italic" => "font-family: 'ScalaItalic','Scala','Palatino',serif; font-weight: normal; font-style: italic",
		"scala_bold" => "font-family: 'ScalaBold','Scala','Palatino',serif; font-weight: bold; font-style: normal",
		"scala_bold_italic" => "font-family: 'ScalaBoldItalic','Scala','Palatino',serif; font-weight: bold; font-style: italic",

		"univers_regular" => "font-family: 'UniversRegular','Univers'; font-weight: normal; font-style: normal;",
		"univers_italic" => "font-family: 'UniversItalic','Univers'; font-weight: normal; font-style: italic;",
		"univers_bold" => "font-family: 'UniversBold','Univers'; font-weight: bold; font-style: normal;"

	);

	// Flag for BigTree CSS3 parsing - automatic vendor prefixing for standard CSS3
	$bigtree["config"]["css"]["prefix"] = false;

	// Flag for CSS minification
	$bigtree["config"]["css"]["minify"] = false;

	// Additional CSS Files For the Admin to Load
	$bigtree["config"]["admin_css"] = array(
		"custom.css"
	);

	// Additional JavaScript Files For the Admin to Load
	$bigtree["config"]["admin_js"] = array(
		"custom.js"
	);

	// --------------------------
	// Placeholder Image Defaults
	// --------------------------

	// Add your own key to the "placeholder" array to create more placeholder image templates.
	$bigtree["config"]["placeholder"]["default"] = array(
		"background_color" => "CCCCCC",
		"text_color" => "666666",
		"image" => false,
		"text" => false
	);
?>