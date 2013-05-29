<?php
defined('_JEXEC') or die('Restricted access');

class JElementOfflajnImagemanager extends JOfflajnFakeElementBase {
  
  var $_moduleName = '';
  
  var $_name = 'Offlajnimagemanager';
  
  function universalfetchElement($name, $value, &$node) {

    if (defined('WP_ADMIN')) {
      if (strpos($value, '/modules/mod_smartslider') === 0) {
        $value = smartslider_url('includes' . $value);
      }
      wp_enqueue_style('thickbox');
      wp_enqueue_style('media');
      wp_enqueue_script("jquery");
      wp_enqueue_script('thickbox');
      $this->loadFiles('wpimagemanager', 'offlajnimagemanager');
      $html = '<div class="offlajntextcontainer">';
      $html.= '<input class="offlajntext" type="text" name="' . $name . '" id="' . $this->id . '" value="' . $value . '"/>';
      $html.= '</div>';
      $html.= '<input style="margin: -3px 0 0 0;" id="' . $this->id . '_wp" value="Add from media library" class="button" type="button" />';
      DojoLoader::addScript('
          new NextendWPImagemanager({
            id: "' . $this->id . '",
            admin_url: "' . admin_url() . '"
          });
      ');
      return $html;
    } else {
      $this->loadFiles();
      $attrs = $node->attributes();
      $imgs = JFolder::files(JPATH_SITE . $attrs['folder'], $filter = '([^\s]+(\.(?i)(jpg|png|gif|bmp))$)');
      $this->loadFiles('offlajnscroller', 'offlajnlist');
      $identifier = md5($name . $attrs['folder']);
      $_SESSION['offlajnupload'][$identifier] = JPATH_SITE . $attrs['folder'];
      $html = "";
      $desc = (isset($attrs['description']) && $attrs['description'] != "") ? $attrs['description'] : "";
      $imgs = (array)$imgs;
      $url = '';
      $upload = '';
      if (defined('WP_ADMIN')) {
        $url = smartslider_url('includes/');
        $upload = 'admin.php?page=smartslider.php/slider&option=offlajnupload';
      } else {
        $url = JURI::root(true);
        $upload = 'index.php?option=offlajnupload';
      }

      //if(!in_array($value, $imgs)) $value = '';
      DojoLoader::addScript('
          new OfflajnImagemanager({
            id: "' . $this->id . '",
            folder: "' . str_replace(DIRECTORY_SEPARATOR, '/', $attrs['folder']) . '",
            root: "' . $url . '",
            uploadurl: "' . $upload . '",
            imgs: ' . json_encode((array)$imgs) . ',
            active: "' . $value . '",
            identifier: "' . $identifier . '",
            description: "' . $desc . '",
            siteurl: "' . JURI::root() . '"
          });
      ');
      
      $urlfield = 'hidden';
      if(isset($attrs['urlfield'])){
        $urlfield = $attrs['urlfield'];
      }
      $html = '<div id="offlajnimagemanager' . $this->id . '" class="offlajnimagemanager">';
      $html.= '<input type="'.$urlfield.'" name="' . $name . '" id="' . $this->id . '" value="' . $value . '"/>';
      if($urlfield != 'hidden'){
        $html.= '<br />';
      }
      $html.= '<div class="offlajnimagemanagerimg">
                  <div></div>
                </div>';
      $html.= '<div class="offlajnimagemanagerbtn"></div>';
      $html.= "</div>";
      return $html;
    }
  }
}
if (version_compare(JVERSION, '1.6.0', 'ge')) {
  
  class JFormFieldOfflajnImagemanager extends JElementOfflajnImagemanager {
  }
}
