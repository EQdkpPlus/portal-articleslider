<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2008
 * Date:		$Date: 2012-12-17 13:13:57 +0100 (Mo, 17. Dez 2012) $
 * -----------------------------------------------------------------------
 * @author		$Author: godmod $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 12604 $
 * 
 * $Id: weather_portal.class.php 12604 2012-12-17 12:13:57Z godmod $
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

class articleslider_portal extends portal_generic {
	public static function __shortcuts() {
		$shortcuts = array('user', 'pdh', 'pfh', 'core', 'db', 'tpl', 'config', 'puf'	=> 'urlfetcher', 'in', 'routing', 'bbcode');
		return array_merge(parent::$shortcuts, $shortcuts);
	}

	protected $path		= 'articleslider';
	protected $data		= array(
		'name'			=> 'articleslider',
		'version'		=> '0.1.0',
		'author'		=> 'GodMod',
		'contact'		=> EQDKP_PROJECT_URL,
		'description'	=> 'Shows a articleslider for your articles',
	);
	protected $positions = array('left', 'left', 'right', 'middle', 'bottom');
	
	protected $install	= array(
	);
	
	protected $multiple = true;
	
	public function get_settings($state){
		$arrCategories = $this->pdh->get('article_categories', 'id_list', array(true));
		$settings	= array(
		'pk_articleslider_categories'	=> array(
			'name'		=> 'pk_articleslider_categories',
			'language'	=> 'pk_articleslider_categories',
			'property'	=> 'jq_multiselect',
			'help'		=> 'pk_articleslider_categories_help',
			'options'	=> $this->pdh->aget('article_categories', 'name', 0, array($arrCategories)),
		),
		'pk_articleslider_maxitems'	=> array(
				'name'		=> 'pk_articleslider_maxitems',
				'language'	=> 'pk_articleslider_maxitems',
				'property'	=> 'spinner',
				'default'	=> 5,
		),
		'pk_articleslider_height'	=> array(
				'name'		=> 'pk_articleslider_height',
				'language'	=> 'pk_articleslider_height',
				'property'	=> 'text',
				'help'		=> 'pk_articleslider_height_help',
				'default'	=> '300',
		),
		'pk_articleslider_width'	=> array(
				'name'		=> 'pk_articleslider_width',
				'language'	=> 'pk_articleslider_width',
				'property'	=> 'text',
				'help'		=> 'pk_articleslider_width_help',
		),
		'pk_articleslider_auto'	=> array(
				'name'		=> 'pk_articleslider_auto',
				'language'	=> 'pk_articleslider_auto',
				'property'	=> 'boolean',
				'default'	=> 1,
				),
		'pk_articleslider_timeout'	=> array(
				'name'		=> 'pk_articleslider_timeout',
				'language'	=> 'pk_articleslider_timeout',
				'property'	=> 'text',
				'default'	=> 5000,
				),
		'pk_articleslider_wordcount'	=> array(
				'name'		=> 'pk_articleslider_wordcount',
				'language'	=> 'pk_articleslider_wordcount',
				'property'	=> 'text',
				'default'	=> 160,
		),
		'pk_articleslider_headtext'	=> array(
				'name'		=> 'pk_articleslider_headtext',
				'language'	=> 'pk_articleslider_headtext',
				'property'	=> 'text',
				'size'		=> '30',
				'help'		=> '',
		),
		);
		return $settings;
	}

	public function output() {
		$this->tpl->js_file($this->server_path.'portal/articleslider/js/responsiveslides.min.js');
		
		$intLimit = ($this->config('pk_articleslider_maxitems')) ? intval($this->config('pk_articleslider_maxitems')) : 5;
		$intTimeout = ($this->config('pk_articleslider_timeout')) ? intval($this->config('pk_articleslider_timeout')) : 5000;
		$strWidth = (strlen($this->config('pk_articleslider_width'))) ? intval($this->config('pk_articleslider_width')) : '100%';
		$intHeight = (strlen($this->config('pk_articleslider_height'))) ? intval($this->config('pk_articleslider_height')) : 300;
		$intWordcount = (strlen($this->config('pk_articleslider_wordcount'))) ? intval($this->config('pk_articleslider_wordcount')) : 160;
		
		$blnAuto = true;
		if (strlen($this->config('pk_articleslider_auto'))) $blnAuto = ($this->config('pk_articleslider_auto'));
		
		$this->tpl->add_css("		
.rslides {
  position: relative;
  list-style: none;
  overflow: hidden;
  padding: 0;
  margin: 0;
}

.rslides li {
  -webkit-backface-visibility: hidden;
  position: absolute;
  display: none;
  width: 100%;
  left: 0;
  top: 0;
  }

.rslides li:first-child {
  position: relative;
  display: block;
  float: left;
  }

.rslides img {
  display: block;
  height: auto;
  float: left;
  width: 100%;
  border: 0;
  }
.callbacks {
  position: relative;
  list-style: none;
  overflow: hidden;
  width: 100%;
  padding: 0;
  margin: 0;
  }
.callbacks_container {
  position: relative;
  margin: auto;
".(($strWidth != "100%") ? 'max-width: '.$strWidth.';' : '')."
  }
.callbacks li {
  position: absolute;
  width: 100%;
  left: 0;
  bottom: 0;
  }

.callbacks img {
  display: block;
  position: relative;
  z-index: 1;
  height: auto;
  width: 100%;
  border: 0;
  }
.callbacks_imagecontainer {
	max-height: ".$intHeight."px;
	overflow: hidden;
}
.callbacks .caption {
  display: block;
  position: absolute;
  z-index: 2;
  font-size: 14px;
  text-shadow: none;
  color: #fff;
  background: #000;
  background: rgba(0,0,0, .7);
  left: 0;
  right: 0;
  bottom: 0;
  padding: 10px 20px;
  margin: 0;
  max-width: none;
}

.callbacks_container:hover .callbacks_nav {
	display:block;	
}				

.callbacks_nav {
  position: absolute;
  -webkit-tap-highlight-color: rgba(0,0,0,0);
  top: 52%;
  left: 0;
  opacity: 0.7;
  z-index: 3;
  text-indent: -9999px;
  overflow: hidden;
  text-decoration: none;
  height: 61px;
  width: 38px;
  background: transparent url(\"".$this->server_path."portal/articleslider/images/themes.gif\") no-repeat left top;
  margin-top: -45px;
display:none;
  }

.callbacks_nav:active {
  opacity: 1.0;
  }

.callbacks_nav.next {
  left: auto;
  background-position: right top;
  right: 0;
  border-top-left-radius: 4px;
  border-bottom-left-radius: 4px;
  }
.callbacks_nav.prev {
	border-top-right-radius: 4px;
	border-bottom-right-radius: 4px;	
}			
.callbacks_tabs {
  margin-top: 10px;
  text-align: center;
  }

.callbacks_tabs li {
  display: inline;
  float: none;
  _float: left;
  *float: left;
  margin-right: 5px;
  }

.callbacks_tabs a {
  text-indent: -9999px;
  overflow: hidden;
  -webkit-border-radius: 15px;
  -moz-border-radius: 15px;
  border-radius: 15px;
  background: #ccc;
  background: rgba(0,0,0, .2);
  display: inline-block;
  _display: block;
  *display: block;
  -webkit-box-shadow: inset 0 0 2px 0 rgba(0,0,0,.3);
  -moz-box-shadow: inset 0 0 2px 0 rgba(0,0,0,.3);
  box-shadow: inset 0 0 2px 0 rgba(0,0,0,.3);
  width: 14px;
  height: 14px;
  }

.callbacks_here a {
  background: #222;
  background: rgba(0,0,0, .8);
  }			
		");
		
		
		$arrCategories = unserialize($this->config('pk_articleslider_categories'));
		$arrArticles = array();
		foreach($arrCategories as $intCategoryID){
			$arrArticles = array_merge($arrArticles, $this->pdh->get('article_categories', 'published_id_list', array($intCategoryID, $this->user->id, false, true)));
		}
		$arrArticles = array_unique($arrArticles);
		$arrSortedArticles = $this->pdh->sort($arrArticles, 'articles', 'date', 'desc');
		$arrSortedArticles = $this->pdh->limit($arrSortedArticles, 0, $intLimit);
		
		$this->tpl->add_js('		
		$("#slider4").responsiveSlides({
	        auto: '.(($blnAuto) ? 'true' : 'false').',
	        pager: true,
	        nav: true,
	        speed: 500,
			timeout: '.$intTimeout.',
			pause: true,
			namespace: "callbacks",
	      });
		', 'docready');
		
		$strOut = '<div class="callbacks_container"><ul class="rslides" id="slider4">';

		foreach($arrSortedArticles as $intArticleID){
			$strOut .= '<li><a href="'.$this->server_path.$this->pdh->get('articles', 'path', array($intArticleID)).'">';
			
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
		
		if($this->config('pk_articleslider_headtext')){
			$this->header = sanitize($this->config('pk_articleslider_headtext'));
		}
		
		return $strOut;
	}

}
if(version_compare(PHP_VERSION, '5.3.0', '<')) registry::add_const('short_weather_portal', weather_portal::__shortcuts());

?>