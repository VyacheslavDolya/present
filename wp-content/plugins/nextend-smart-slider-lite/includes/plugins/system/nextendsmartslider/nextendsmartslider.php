<?php
/*-------------------------------------------------------------------------
# com_smartslider - Smart Slider
# -------------------------------------------------------------------------
# @ author    Roland Soós
# @ copyright Copyright (C) 2013 Nextendweb.com  All Rights Reserved.
# @ license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# @ website   http://www.nextendweb.com
-------------------------------------------------------------------------*/
$revision = '4.0.0.69';
$revision = '4.0.0';
?><?php

// no direct access
defined('_JEXEC') or die;

class plgSystemNextendSmartSlider extends JPlugin{
    function onAfterInitialise(){
        $app = JFactory::getApplication();
        $db = JFactory::getDbo();
        if($app->isSite() && JRequest::getInt('module') && JRequest::getInt('w') ){
            if(!defined('WPINC')){            
              $user = JFactory::getUser(); 
              $query = '';
              if(version_compare(JVERSION,'1.6.0','ge')){
                $groups = implode(',', $user->getAuthorisedViewLevels());
                
                $lang = JFactory::getLanguage()->getTag();
                $clientId = (int) $app->getClientId();
                $query = $db->getQuery(true);
                $query->select('m.id, m.title, m.module, m.position, m.content, m.showtitle, m.params, mm.menuid');
                $query->from('#__modules AS m');
                $query->join('LEFT', '#__modules_menu AS mm ON mm.moduleid = m.id');
                $query->where('m.published = 1');
    
                $query->join('LEFT', '#__extensions AS e ON e.element = m.module AND e.client_id = m.client_id');
                $query->where('e.enabled = 1');
    
                $date = JFactory::getDate();
                $now = $date->toSql();
                $nullDate = $db->getNullDate();
                $query->where('(m.publish_up = ' . $db->Quote($nullDate) . ' OR m.publish_up <= ' . $db->Quote($now) . ')');
                $query->where('(m.publish_down = ' . $db->Quote($nullDate) . ' OR m.publish_down >= ' . $db->Quote($now) . ')');
    
                $query->where('m.access IN (' . $groups . ')');
                $query->where('m.client_id = ' . $clientId);
    
                // Filter by language
                if ($app->isSite() && $app->getLanguageFilter())
                {
                        $query->where('m.language IN (' . $db->Quote($lang) . ',' . $db->Quote('*') . ')');
                }
                
                $query->where('m.id = '.JRequest::getInt('module',0));
    
                $query->order('m.position, m.ordering');
              }else{
                $aid	= $user->get('aid', 0);
            
            		$query = 'SELECT id, title, module, position, content, showtitle, control, params'
            			. ' FROM #__modules AS m'
            			. ' LEFT JOIN #__modules_menu AS mm ON mm.moduleid = m.id'
            			. ' WHERE m.published = 1'
            			. ' AND m.access <= '. (int)$aid
            			. ' AND m.client_id = '. (int)$app->getClientId()
            			. ' AND m.id = '.JRequest::getInt('module',0)
            			. ' ORDER BY position, ordering';
              }
  
              // Set the query
              $db->setQuery($query);
              $module = $db->loadObject();
              if(empty($module) || $module->module != 'mod_smartslider') $this->showError();
              $params = null;
              if(version_compare(JVERSION,'1.6.0','ge')){
                $params = new JRegistry;
    	          $params->loadString($module->params);
              }else{
                $params = new JParameter( $module->params );
              }
              $module->params = &$params;
            }else{
                $module = new stdClass();
                $module->module = 'mod_smartslider';
                $module->id = JRequest::getInt('module');
                $sliderid = $module->id-((int)($module->id/10000))*10000;
                $params = new JParameter();
                $params->set('slider', $sliderid);
            }
            
            $SSpath = JPATH_SITE . DS . 'modules' . DS . 'mod_smartslider';
            require_once ( $SSpath . DS . 'helpers' . DS . 'functions.php');
            require_once ($SSpath . DS . 'params' . DS . 'offlajndashboard' . DS . 'offlajndashboard.php');
            
            if (version_compare(JVERSION, '1.6.0', 'ge')) {
                $params->loadArray(o_flat_array($params->toArray()));
            }
            
            $tthis = new stdClass();
            $sliderid = $params->get('slider', 0);
            if(!is_numeric($sliderid) || $sliderid == 0) $this->showError();
            
            //get the datas of the current slider
            $query = 'SELECT *' . ' FROM #__offlajn_slider' . ' WHERE published = 1 AND id = ' . ((int)$sliderid);
            $db->setQuery($query);
            $tthis->slider = $db->loadObject();
            if ($tthis->slider == NULL) {
              $this->showError();
            }
            
            //Parse slider params
            if (!function_exists('parseParams')) {
              function parseParams(&$p, $vals) {
                if (version_compare(JVERSION, '1.6.0', '>=')) {
                  $p->loadJSON($vals);
                } else {
                  $p->loadIni($vals);
                }
              }
            }
            $tthis->typeParams = new OfflajnJParameter('');
            parseParams($tthis->typeParams, $tthis->slider->params);
            $tthis->slider->params = & $tthis->typeParams;
            
            $id = $module->module . '_' . $module->id;
            require_once ($SSpath . DS . 'classes' . DS . 'cache.class.php');
            require_once ($SSpath . DS . 'classes' . DS . 'helper.class.php');
            
            if (version_compare(JVERSION, '3.0.0', 'ge')) {
              $get_date = JFactory::getDate();
              $now = $get_date->toSql();
            } else {
              $jnow = & JFactory::getDate();
              $now = $jnow->toMySQL();
            }
            $nullDate = $db->getNullDate();
            $query = 'SELECT id, title, content, caption, groupprev, icon' . ' FROM #__offlajn_slide' . ' WHERE published = 1 AND slider = ' . ((int)$sliderid) . ' AND ( publish_up = ' . $db->Quote($nullDate) . ' OR publish_up <= ' . $db->Quote($now) . ' )' . ' AND ( publish_down = ' . $db->Quote($nullDate) . ' OR publish_down >= ' . $db->Quote($now) . ' )';
            if ($tthis->typeParams->get('random', 0) == 0) {
              $query.= ' ORDER BY ordering';
            } else {
              $query.= ' ORDER BY RAND()';
            }
            $db->setQuery($query);
            $slides = $db->loadObjectList();

            $tthis->slides = array();
            $count = count($slides);
            if ($tthis->slider->params->get('generator') != "Choose" && $count == 0) {
              $gen = $tthis->slider->params->get('generator');
              require_once ($SSpath . DS . 'generators' . DS . $gen . '.php');
              $gen.= 'Parser';
              $tp = new $gen($tthis->slider->params);
              $slidearray = $tp->makeSlides();
              for ($i = 0;$i < count($slidearray);$i++) {
                $slides[$i]->title = $slidearray[$i]->title;
                $slides[$i]->content = $slidearray[$i]->content;
                $slides[$i]->caption = $slidearray[$i]->caption;
                $slides[$i]->groupprev = $slidearray[$i]->groupprev;
              }
              $count = $i;
            }
            if (($count != 0)) {
              for ($i = 0, $j = 0;$i < $count;++$i, ++$j) {
                $slides[$i]->title = str_replace('$', '&#36;', $slides[$i]->title);
                $slides[$i]->content = str_replace('$', '&#36;', $slides[$i]->content);
                $slides[$i]->caption = str_replace('$', '&#36;', $slides[$i]->caption);
                $p = new OfflajnJParameter('');
        
                //parseParams($p, $slides[$i]->params);
                
                //$slides[$i]->params = $p;
        
                $slides[$i]->childs = array();
                if ($slides[$i]->groupprev == 1 && isset($tthis->slides[$j - 1])) {
                  --$j;
                } else {
                  $tthis->slides[$j] = & $slides[$i];
                }
                $tthis->slides[$j]->childs[] = & $slides[$i];
              }
            } else {
              echo JText::_('Please add some slide to the slider!');
              return;
            }
            $tthis->slider->params->set('bak_size', $tthis->slider->params->get('size'));
            
            $size = OfflajnValueParser::parse( $tthis->slider->params->get('size'));
	          $ow = $size[1][0];
	    
            $size[0] = 1;
            $w = JRequest::getInt('w');
            $ratio = $w/$size[1][0];
            $size[1] = intval($size[1][0]*$ratio).'||'.$size[1][1];
            $size[2] = intval($size[2][0]*$ratio).'||'.$size[2][1];
            $tthis->slider->params->set('size',implode('|*|',$size));
	    
            $ow = JRequest::getInt('ow', $ow);
            $tthis->slider->params->set('ratio',$w/$ow);
            
            $theme = $SSpath . DS . 'types' . DS . $tthis->slider->type . DS . $tthis->slider->theme . DS;
            $themecache = new OfflajnSliderThemeCache($tthis, $module, $params, $theme . 'style.css.php');
            if(defined('WPINC')){
                $themecache->themeCacheUrl = smartslider_translate_url($themecache->themeCacheUrl);
            }
            $context = array();
            $context['helper'] = new OfflajnSliderHelper($themecache->themeCacheDir, $themecache->themeCacheUrl);
            $context['bghelper'] = new OfflajnBgHelper($themecache->themeCacheDir, $themecache->themeCacheUrl);
            if(!defined('WPINC')){
                $context['fonturl'] = JURI::root() . 'modules/' . $module->module . '/fonts/';
                $context['url'] = JURI::root() . 'modules/' . $module->module . '/types/' . $tthis->slider->type . '/' . $tthis->slider->theme . '/';
            }else{
                $context['fonturl'] = smartslider_translate_url('modules/'.$module->module.'/fonts/');
                $context['url'] = smartslider_translate_url('modules/'.$module->module.'/types/'.$tthis->slider->type.'/'.$tthis->slider->theme.'/');
            }
            $context['clearcss'] = $SSpath . DS . 'clear.css.php';
            $context['captioncss'] = $SSpath . DS . 'captions' . DS . 'style.css.php';
            $context['contentcss'] = $SSpath . DS . 'contents' . DS . 'style.css.php';
            $context['id'] = '#' . $id;
      	    header("Content-type: text/css", true);
            $cachedurl = $themecache->generateCss($context);
            if(!defined('WPINC')){
      	       echo file_get_contents(str_replace(array(JURI::root(),'/'), array(JPATH_SITE.DIRECTORY_SEPARATOR,DIRECTORY_SEPARATOR), $cachedurl));
            }else{
              echo file_get_contents(str_replace(array(smartslider_translate_url(JURI::root()),'/'), array(JPATH_SITE.DIRECTORY_SEPARATOR,DIRECTORY_SEPARATOR), $cachedurl));
            }
            exit;
        }
    }
    
    function showError(){
        header("HTTP/1.0 404 Not Found");
        exit;
    }
}