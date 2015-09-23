<?php

if ( is_object( $xoopsUser)  ) {
    $xoopsModule = XoopsModule::getByDirname("antispam");
    if ( !$xoopsUser->isAdmin($xoopsModule->mid()) ) {
        redirect_header(XOOPS_URL."/",1,_NOPERM);
        exit();
    }
} else {
    redirect_header(XOOPS_URL."/",1,_NOPERM);
    exit();
}

/**
 * Display bad behaviour stats
 */
function bb23_function_bbstats($options){
    // load our main include
    require_once( XOOPS_ROOT_PATH .  '/modules/antispam/bad-behavior-xoops.php');
    return bb2_insert_stats();
}

/**
 * Function used to display an horizontal menu inside the admin panel
 * Enable webmasters to navigate thru the module's features.
 * Each time you select an option in the admin panel of the news module, this option is highlighted in this menu
 * @package badbehavior
 * @orig author: hsalazar
 * @copyright	(c) The Xoops Project - www.xoops.org
*/

function bb2_adminmenu($currentoption = 0, $breadcrumb = '') {
	echo "
    <style type='text/css'>
    #buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }
    #buttonbar { float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/antispam/images/bg.gif') repeat-x left bottom; font-size: 12px; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px; }
    
    #buttonbar ul { margin:0; margin-top: 15px; padding:10px 5px 0; list-style:none; }
		#buttonbar li { display:inline; margin:0; padding:0; }
		#buttonbar a { float:left; background:url('" . XOOPS_URL . "/modules/antispam/images/left_both.gif') no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; white-space: nowrap}
		#buttonbar a span { float:left; display:block; background:url('" . XOOPS_URL . "/modules/antispam/images/right_both.gif') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; white-space: nowrap}
		/* Commented Backslash Hack hides rule from IE5-Mac \*/
		#buttonbar a span {float:none;}
		/* End IE5-Mac hack */
		#buttonbar a:hover span { color:#333; }
		#buttonbar #current a { background-position:0 -150px; border-width:0; }
		#buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
		#buttonbar a:hover { background-position:0% -150px; }
		#buttonbar a:hover span { background-position:100% -150px; }
		</style>
    ";

	global $xoopsModule, $xoopsConfig;
	$myts = &MyTextSanitizer::getInstance();

	$tblColors = Array_Fill(0,8,'');
	$tblColors[$currentoption] = 'current';

	if (file_exists(XOOPS_ROOT_PATH . '/modules/antispam/language/' . $xoopsConfig['language'] . '/modinfo.php')) {
		include_once XOOPS_ROOT_PATH . '/modules/antispam/language/' . $xoopsConfig['language'] . '/modinfo.php';
	} else {
		include_once XOOPS_ROOT_PATH . '/modules/antispam/language/english/modinfo.php';
	}

	include 'menu.php';

	echo '<div id="buttontop">';
	echo '<table style="width: 100%; padding: 0;" cellspacing="0"><tr>';
	echo '<td style="font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;">';
	for( $i=0; $i<count($headermenu); $i++ ){
		echo '<a class="nobutton" href="' . $headermenu[$i]['link'] .'"  TITLE='.$headermenu[$i]['title'].'>' . $headermenu[$i]['title'] . '</a> ';
		if ($i < count($headermenu)-1) {
			echo "| ";
		}
	}
	echo '</td>';
	echo '<td style="font-size: 12px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px; font-weight: bold;">' . $breadcrumb . '</td>';
	echo '</tr></table>';
	echo '</div>';

	echo '<div id="buttonbar">';
	echo "<ul>";

	for( $i=0; $i<count($adminmenu); $i++ ){
		echo '<li id="' . $tblColors[$i] . '"><a href="' . XOOPS_URL . '/modules/antispam/' . $adminmenu[$i]['link'] . ' " TITLE='.$adminmenu[$i]['title'].'><span>' . $adminmenu[$i]['title'] . '</span></a></li>';
	}
	echo '</ul></div>';
  echo '<div style="float: left; width: 100%; text-align: center; margin: 0px; padding: 0px">';
  echo '</div>';
}

function bb2_loglistheader($heading) {
	echo "
		<fieldset><legend style='font-weight: bold; color: #900;'>" . $heading . "</legend><br />\n
		<table width='100%' cellspacing='1' cellpadding='2' border='0' class = 'outer'>\n
		<tr>\n
		<th align='center'><b>" . _AM_BB2_KEY . "</b></th>\n
		<th align='center'><b>" . _AM_BB2_DATE . "</b></th>\n
		<th align='center'><b>" . _AM_BB2_IP . "</b></th>\n
		<th align='center'><b>" . _AM_BB2_USER_AGENT . "</b></th>\n
		<th align='center'><b>" . _AM_BB2_ACTION . "</b></th>\n
		</tr>\n
		";
}
?>