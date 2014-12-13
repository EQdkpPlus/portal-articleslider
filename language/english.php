<?php
/*	Project:	EQdkp-Plus
 *	Package:	Article Slider Portal Module
 *	Link:		http://eqdkp-plus.eu
 *
 *	Copyright (C) 2006-2015 EQdkp-Plus Developer Team
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU Affero General Public License as published
 *	by the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU Affero General Public License for more details.
 *
 *	You should have received a copy of the GNU Affero General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

$lang = array(
	'articleslider'					=> 'Articleslider',
	'articleslider_name'			=> 'Articleslider',
	'articleslider_desc'			=> 'Shows an imageslider for featured articles',
	'articleslider_f_categories'	=> 'Articlecategories',
	'articleslider_f_help_categories'=> 'The featured articles will be shown from the selected categories.',
	'articleslider_f_maxitems'		=> 'Maximum count of shown featured articles',
	'articleslider_f_height'		=> 'Maximum height of the slider',
	'articleslider_f_help_height'	=> 'Currency is pixel',
	'articleslider_f_width'			=> 'Maximum width of the slider',
	'articleslider_f_help_width'	=> 'Currency is pixel. Leave the field empty for full width.',
	'articleslider_f_auto'			=> 'Automatic transition between the slides',
	'articleslider_f_timeout'		=> 'Waiting time between the automatic transition (milliseconds)',
	'articleslider_f_wordcount'		=> 'Wordcount of preview text',
);
?>