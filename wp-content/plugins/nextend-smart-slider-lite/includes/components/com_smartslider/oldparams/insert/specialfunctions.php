<?php
/*-------------------------------------------------------------------------
# com_smartslider - Smart Slider
# -------------------------------------------------------------------------
# @ author    Roland Soos
# @ copyright Copyright (C) 2013 Offlajn.com  All Rights Reserved.
# @ license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# @ website   http://www.offlajn.com
-------------------------------------------------------------------------*/
?><?php
/*
0 => anything
*/
function SSDefaultFilter($row){
  return $row[0];
}

function SSImageFilter($row){
  $desc = $row[0];
  preg_match('/src=("|\')([^("|\')]+)("|\')/', $desc, $matches);
  if(count($matches) > 2){
    return $matches[2];
  }
  return '';
}

function K2_Image($row){
  $id = $row[0];
  return "media/k2/items/cache/".md5("Image".$id)."_XL.jpg";
}

/*
*Virtuemart 1.x Special Functions
*/

/*
0 => Product_id
*/

function SSVirtuemartProductPrice($row) {
  if(version_compare(JVERSION,'1.6.0','<=')) {
    if(file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart')) {
      global $auth;
      require_once(JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'virtuemart_parser.php');
      require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'ps_product.php');
  
      $ps_product = new ps_product;
      $productPrice = $ps_product->get_adjusted_attribute_price($row[0]);
      $fullPrice = $GLOBALS['CURRENCY']->convert($productPrice['product_price'], $productPrice['product_currency']);
      if (@$auth["show_price_including_tax"]) $fullPrice *= (1 + $ps_product->get_product_taxrate($row[0]));
        return @$GLOBALS['CURRENCY_DISPLAY']->getFullValue($fullPrice);
      }
  }
  return ;
}


/*
0 => Virtuemart product full image filename
*/

function SSLinkToVmProductImage($row) {
  return JRoute::_( 'components/com_virtuemart/shop_image/product/'.$row[0] );
}

/*
0 => Virtuemart product id
*/

function SSNameOfVmCategory($row) {
  require_once(JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'virtuemart_parser.php');
  require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'ps_product_category.php';
  
  $ps_product_category = new ps_product_category;
   
  return $ps_product_category->get_name($row[0]);
}

/*
0 => Virtuemart category id
*/

function SSLinkToVmCategory($row) {
  return JRoute::_( 'index.php?option=com_virtuemart&page=shop.browse&category_id='.$row[0] );
}

/*
0 => Virtuemart product id
*/

function SSLinkToVmProduct($row) {
  require_once(JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'virtuemart_parser.php');
  require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'ps_product.php');
  require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'ps_product_category.php';
  
  $ps_product = new ps_product;
  $ps_product_category = new ps_product_category;
  
  //return JURI::root(true)."/index.php?page=shop.product_details&flypage=".$ps_product->get_flypage($row[0])."&product_id=".$row[0]."&category_id=".$ps_product_category->get_cid($row[0])."&option=com_virtuemart";
  return JRoute::_( 'index.php?page=shop.product_details&flypage='.$ps_product->get_flypage($row[0]).'&product_id='.$row[0].'&category_id='.$ps_product_category->get_cid($row[0]).'&option=com_virtuemart' );
  
}

/*
*Virtuemart 2.x Special functions
*/

/*
0 => Product_id
*/


function SSVirtuemart2ProductPrice($row) {
  $virtuemart_xml = &JFactory::getXMLParser('Simple');
  $virtuemart_xml->loadFile(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS."virtuemart.xml");
  if((int)$virtuemart_xml->document->version[0]->data() == 2) {
    if(file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart')) {
      if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'config.php');
      $config= VmConfig::loadConfig();
      require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'models'.DS.'product.php');
      $product = new VirtueMartModelProduct();
      $price = array();
      $pr = $product->getProduct($row[0]);
      $price = @$product->getPrice($row[0], 1, 1);
      $db = & JFactory::getDBO();
      $query = "SELECT ".$db->nameQuote('currency_symbol'). 
                    " FROM ".$db->nameQuote('#__virtuemart_currencies').
                    " WHERE ".$db->nameQuote('virtuemart_currency_id')."=".$db->quote($pr->product_currency);
      $db->setQuery($query);  
      return $db->loadResult()." ".$price["salesPrice"];
    }
  }
  return ;
}

/*
0 => Virtuemart product full image filename
*/

function SSLinkToVm2ProductImage($row) {
  return JURI::root().$row[0];
}

/*
0 => Virtuemart product id
*/

function SSNameOfVm2Category($row) {
  $virtuemart_xml = &JFactory::getXMLParser('Simple');
  $virtuemart_xml->loadFile(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS."virtuemart.xml");
  if((int)$virtuemart_xml->document->version[0]->data() == 2) {
      if(file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart')) {
        if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'config.php');
        $config= VmConfig::loadConfig();
        $db = & JFactory::getDBO();
        $query = "SELECT ".$db->nameQuote('category_name'). 
                    " FROM ".$db->nameQuote('#__virtuemart_categories_'.VMLANG).
                    " WHERE ".$db->nameQuote('virtuemart_category_id')."=".$db->quote($row[0]);
        $db->setQuery($query);
        return $db->loadResult();
      }
    } 
  return ;
}

/*
0 => Virtuemart category id
*/

function SSLinkToVm2Category($row) {
  return JRoute::_( 'index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$row[0] );
}

/*
0 => Virtuemart product id
*/

function SSLinkToVm2Product($row) {
  return JRoute::_( 'index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$row[0] );
}

/*
0 => Content category id
*/

function SSLinkToCategory($row) {
  if($row[0])
  return JRoute::_( 'index.php?option=com_content&view=category&id='.$row[0] );
}

/*
0 => Article_id
*/

function SSLinkToArticle($row) {
  if(version_compare(JVERSION,'3.0.0','l') && !class_exists('JControllerLegacy')){
    class JControllerLegacy extends JController{};
    jimport( 'joomla.application.component.view' );
    class JViewLegacy extends JView{};
    jimport( 'joomla.application.component.model' );
    class JModelLegacy extends JModel{};
  }
  
  $com_path = JPATH_SITE.'/components/com_content/';
  require_once $com_path.'router.php';
  require_once $com_path.'helpers/route.php';
  jimport('joomla.application.component.modellegacy');
  JModelLegacy::addIncludePath($com_path . '/models', 'ContentModel'); 
  
  $model = JModelLegacy::getInstance('Article', 'ContentModel', array('ignore_request' => true)); 
  
  $app = JFactory::getApplication('site');
	$params = $app->getParams();
	$model->setState('params', $params);
  $item = $model->getItem($row[0]);
  return ContentHelperRoute::getArticleRoute($item->id, $item->catid, $item->language);
}

/*
0 => K2 category id
*/

function SSLinkToK2Category($row) {
  return JRoute::_( 'index.php?option=com_k2&view=itemlist&layout=category&task=category&id='.$row[0] );
}

/*
0 => K2 item_id
*/

function SSLinkToK2Item($row) {
  return JRoute::_( 'index.php?option=com_k2&view=item&id='.$row[0] );
}

/*
0 => Easyblog blog category id
*/

function SSLinkToEasyBlogCategory($row) {
  return JRoute::_( 'index.php?option=com_easyblog&view=categories&layout=listings&id='.$row[0] );
}

/*
0 => Easyblog blog id
*/

function SSLinkToEasyBlog($row) {
  return JRoute::_( 'index.php?option=com_easyblog&view=entry&id='.$row[0] );
}

/*
0 => Menu item link
1 => Menu item id
*/

function SSMenuItemLink($row) {
  return JRoute::_( $row[1].'&Itemid='.$row[0] );
}

/*
0 => Phocagallery image filename (path + filename)
*/

function SSLinkToPhocagalleryImg($row) {
  return JRoute::_( 'images/phocagallery/'.$row[0] );
}

/*
0 => Phocagallery category id
*/

function SSLinkToPhocagalleryCategory($row) {
  return JRoute::_( 'index.php?option=com_phocagallery&view=category&id='.$row[0] );
}

/*
0 => Ignitegallery image id
1 => Ignitegallery image filename
*/

function SSLinkToIgnitegalleryImg($row) {
  $folder = "";
    $num = 1;
    if($row[0] < 100) {
       $num = intval($row[0] / 100);
    }
    if ($row[0] > $num*100) {
      $num++;
    }
    $folder = $num*100-99;
    $folder .= "-";
    $folder .= $num*100;

  return JRoute::_( 'images/igallery/original/'.$folder.'/'.$row[1] );
}


/*
0 => Ignite gallery category id
*/

function SSLinkToIgnitegalleryCategory($row) {
  return JRoute::_( 'index.php?option=com_igallery&view=igcategory&id='.$row[0] );
}

global $SSCobaltRecord;
$SSCobaltRecord = array();

function SSgetCobaltRecord($id){
  global $SSCobaltRecord;
  if(isset($SSCobaltRecord[$id]))
    return $SSCobaltRecord[$id];
  if(count($SSCobaltRecord) == 0){
    require_once JPATH_SITE . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_cobalt' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'form.php';
    if(version_compare(JVERSION,'2.5.6','lt')) {
      jimport ( 'joomla.application.component.model' );
    }else{
      jimport ( 'joomla.application.component.modellegacy' );
    }
    JLoader::import( 'record', JPATH_SITE . DS . 'components' . DS . 'com_cobalt' . DS . 'models' );
  }
  if(version_compare(JVERSION,'2.5.6','lt')) {
    $model = JModel::getInstance( 'record', 'CobaltModel' );
  }else{
    $model = JModelLegacy::getInstance( 'record', 'CobaltModel' );
  }
  
  $SSCobaltRecord[$id] = $model->_prepareItem($model->getItem($id));;
  return $SSCobaltRecord[$id];
}

function SSCobalt($row){
  if(count($row) == 1) $row = explode('.', $row[0]);
  $rec = SSgetCobaltRecord($row[0]);
  if(isset($row[1])){
    switch($row[1]){
      case 'title':
        return $rec->title;
      case 'url':
        return $rec->href;
      default:
      $row[1] = str_replace('field','',$row[1]);
      if(isset($rec->fields_by_id[$row[1]]) ){
        $field = $rec->fields_by_id[$row[1]];
        if($field->value && is_array($field->value) && isset($field->value['image'])){
          $array = array();
          preg_match( '/src="([^"]*)"/i', $field->result, $array ) ;
          return $array[1];
        }
        
        return $field->result;
      }
    }
  }else{
    return '';
  }
}



?>