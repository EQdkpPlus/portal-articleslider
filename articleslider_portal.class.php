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

class articleslider_portal extends portal_generic {
	protected static $path		= 'articleslider';
	protected static $data		= array(
		'name'			=> 'articleslider',
		'version'		=> '0.1.1',
		'author'		=> 'GodMod',
		'contact'		=> EQDKP_PROJECT_URL,
		'description'	=> 'Shows a articleslider for your articles',
		'lang_prefix'	=> 'articleslider_',
		'multiple'		=> true,
		'icon'			=> 'fa-sliders'
	);
	protected static $positions = array('left', 'left', 'right', 'middle', 'bottom');
	protected static $multiple = true;
	protected static $apiLevel = 20;
	
	public function get_settings($state){
		$arrCategories = $this->pdh->get('article_categories', 'id_list', array(true));
		$settings	= array(
			'categories'	=> array(
				'type'		=> 'multiselect',
				'options'	=> $this->pdh->aget('article_categories', 'name', 0, array($arrCategories)),
			),
			'featured' => array(
				'type'		=> 'radio',
				'default'	=> 1,
			),
			'maxitems'	=> array(
					'type'		=> 'spinner',
					'default'	=> 5,
			),
			'height'	=> array(
					'type'		=> 'text',
					'default'	=> '300',
			),
			'width'	=> array(
					'type'		=> 'text',
			),
			'auto'	=> array(
					'type'		=> 'radio',
					'default'	=> 1,
			),
			'timeout'	=> array(
					'type'		=> 'text',
					'default'	=> 5000,
			),
			'wordcount'	=> array(
					'type'		=> 'text',
					'default'	=> 160,
			),
		);
		return $settings;
	}

	public function output() {
		$this->tpl->js_file($this->server_path.'portal/articleslider/js/responsiveslides.min.js');
		
		$blnFeatured	= ($this->config('featured'))? true : false;
		$intLimit		= ($this->config('maxitems'))? intval($this->config('maxitems')) : 5;
		$intTimeout		= ($this->config('timeout'))? intval($this->config('timeout')) : 5000;
		$strWidth		= (strlen($this->config('width')))? intval($this->config('width')) : '100%';
		$intHeight		= (strlen($this->config('height')))? intval($this->config('height')) : 300;
		$intWordcount	= (strlen($this->config('wordcount')))? intval($this->config('wordcount')) : 160;
		
		$blnAuto = true;
		if (strlen($this->config('auto'))) $blnAuto = ($this->config('auto'));
		
		$this->tpl->add_css("
			.rslides { position: relative; list-style: none; overflow: hidden; padding: 0; margin: 0; }
			.rslides li { -webkit-backface-visibility: hidden; position: absolute; display: none; width: 100%; left: 0; top: 0; }
			.rslides li:first-child { position: relative; display: block; float: left; }
			.rslides img { display: block; height: auto; float: left; width: 100%; border: 0; }
			
			.callbacks { position: relative; list-style: none; overflow: hidden; width: 100%; padding: 0; margin: 0; }
			.callbacks_container.slider_".$this->id." { position: relative; margin: auto; ".(($strWidth != "100%") ? 'max-width: '.$strWidth.';' : '')." }
			.callbacks li { position: absolute; width: 100%; left: 0; bottom: 0; }
			.callbacks img { display: block; position: relative; z-index: 1; height: auto; width: 100%; border: 0; }
			.callbacks .caption { display: block; position: absolute; z-index: 2; font-size: 14px; text-shadow: none; color: #fff; background: #000; background: rgba(0,0,0, .7); left: 0; right: 0; bottom: 0; padding: 10px 20px; margin: 0; max-width: none; }
			
			.slider_".$this->id." .callbacks_imagecontainer { max-height: ".$intHeight."px; overflow: hidden; ".((!$this->wide_content)? "display:none;" : "")." }
			
			.callbacks_container:hover .callbacks_nav { display:block; }
			
			.callbacks_nav { position: absolute; top: 52%; left: 0; opacity: 0.7; z-index: 3; text-indent: -9999px; overflow: hidden; text-decoration: none; height: 61px; width: 38px; background: transparent url(\"".$this->server_path."portal/articleslider/images/themes.gif\") no-repeat left top; margin-top: -45px; display:none; }
			.callbacks_nav:active { opacity: 1.0; }
			.callbacks_nav.next { left: auto; background-position: right top; right: 0; border-top-left-radius: 4px; border-bottom-left-radius: 4px; }
			.callbacks_nav.prev { border-top-right-radius: 4px; border-bottom-right-radius: 4px; }
			
			.callbacks_tabs { margin-top: 10px; text-align: center; }
			.callbacks_tabs li { display: inline; float: none; margin-right: 5px; }
			.callbacks_tabs a { text-indent: -9999px; overflow: hidden; border-radius: 15px; background: rgba(0,0,0, .2); display: inline-block; box-shadow: inset 0 0 2px 0 rgba(0,0,0,.3); width: 14px; height: 14px; }
			.callbacks_here a { background: #222; background: rgba(0,0,0, .8); }
			
			".((!$this->wide_content)? "#slider_".$this->id.".callbacks .caption { padding: 0; position: static; color: #000; background: transparent; }" : "")."
		");
		
		$arrCategories = $this->config('categories');
		if(empty($arrCategories)) $arrCategories = array();
		$arrArticles = array();
		foreach($arrCategories as $intCategoryID){
			$arrArticles = array_merge($arrArticles, $this->pdh->get('article_categories', 'published_id_list', array($intCategoryID, $this->user->id, false, $blnFeatured)));
		}
		$arrArticles = array_unique($arrArticles);
		$arrSortedArticles = $this->pdh->sort($arrArticles, 'articles', 'date', 'desc');
		$arrSortedArticles = $this->pdh->limit($arrSortedArticles, 0, $intLimit);
		
		$this->tpl->add_js('
			$("#slider_'.$this->id.'").responsiveSlides({
				auto: '.(($blnAuto) ? 'true' : 'false').',
				pager: true,
				nav: '.(($this->wide_content)? 'true' : 'false').',
				speed: 500,
				timeout: '.$intTimeout.',
				pause: true,
				namespace: "callbacks",
			});
		', 'docready');
		
		$strOut = '<div class="callbacks_container slider_'.$this->id.'"><ul class="rslides" id="slider_'.$this->id.'">';

		foreach($arrSortedArticles as $intArticleID){
			$strOut .= '<li><a href="'.$this->controller_path.$this->pdh->get('articles', 'path', array($intArticleID)).'">';
			
			$strPreviewImage = $this->pdh->get('articles', 'previewimage', array($intArticleID));
			if (strlen($strPreviewImage)){
				$strImage = register('pfh')->FileLink($strPreviewImage, 'files', 'absolute');
			} else {
				$strImage = $this->server_path.'portal/articleslider/images/dummy.jpg';
			}
			$strTitle = $this->pdh->get('articles', 'title', array($intArticleID));
			$strOut .= '<div class="callbacks_imagecontainer"><img src="'.$strImage.'" alt="'.$strTitle.'" /></div>';
			if(strlen($strTitle)){
				$strText = $this->pdh->get('articles', 'text', array($intArticleID));
				$strText = $this->bbcode->remove_embeddedMedia($this->bbcode->remove_shorttags($strText));
				$strText = strip_tags(xhtml_entity_decode($strText));
				$strText = truncate($strText, $intWordcount, '...', false, true);
				
				$strOut .= '<p class="caption"><span style="font-weight:bold;">'.$strTitle.'</span><br />';
				$strOut .= $strText;
				$strOut .= '</p>';
			}
			$strOut .= '</a></li>';
		}
		
		$strOut .= "</ul></div>";
		
		return $strOut;
	}

}
?>