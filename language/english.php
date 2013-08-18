<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2008
 * Date:		$Date: 2012-10-06 12:41:52 +0200 (Sa, 06. Okt 2012) $
 * -----------------------------------------------------------------------
 * @author		$Author: hoofy_leon $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 12207 $
 * 
 * $Id: german.php 12207 2012-10-06 10:41:52Z hoofy_leon $
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

$lang = array(
	'articleslider'					=> 'Articleslider',
	'articleslider_name'			=> 'Articleslider',
	'articleslider_desc'			=> 'Shows an imageslider for featured articles',
	'pk_articleslider_categories'	=> 'Articlecategories',
	'pk_articleslider_categories_help'=> 'The featured articles will be shown from the selected categories.',
	'pk_articleslider_maxitems'		=> 'Maximum count of shown featured articles',
	'pk_articleslider_height'		=> 'Maximum height of the slider',
	'pk_articleslider_height_help'	=> 'Currency is pixel',
	'pk_articleslider_width'		=> 'Maximum width of the slider',
	'pk_articleslider_width_help'	=> 'Currency is pixel. Leave the field empty for full width.',
	'pk_articleslider_auto'			=> 'Automatic transition between the slides',
	'pk_articleslider_timeout'		=> 'Waiting time between the automatic transition (milliseconds)',
	'pk_articleslider_wordcount'	=> 'Wordcount of preview text',
	'pk_articleslider_headtext'		=> 'Title of the articleslider'
);
?>