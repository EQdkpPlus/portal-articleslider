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
	'articleslider'					=> 'Artikel-Slider',
	'articleslider_name'			=> 'Artikel-Slider',
	'articleslider_desc'			=> 'Zeigt einen Image-Slider für hervorgehobene Artikel an',
	'articleslider_f_categories'	=> 'Artikelkategorien',
	'articleslider_f_help_categories'=> 'Aus den ausgewählten Kategorien werden die hervorgehobenen Artikel im Artikel-Slider angezeigt',
	'articleslider_f_featured'		=> 'Zeige nur Featured Artikel',
	'articleslider_f_maxitems'		=> 'Maximal angezeigte hervorgehobene Artikel',
	'articleslider_f_height'		=> 'Maximale Höhe des Sliders',
	'articleslider_f_help_height'	=> 'In Pixel',
	'articleslider_f_width'			=> 'Maximale Breite des Sliders',
	'articleslider_f_help_width'	=> 'In Pixel. Leer lassen für volle Breite',
	'articleslider_f_auto'			=> 'Automatisch zwischen den einzelnen Slides wechseln',
	'articleslider_f_timeout'		=> 'Wartezeit zwischen dem automatischen Slidewechseln (in Millisekunden)',
	'articleslider_f_wordcount'		=> 'Wortanzahl des Vorschautextes',
);
?>