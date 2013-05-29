-- Joomla Module --
UPDATE #__components 
  SET name = 'Smart Slider', admin_menu_alt='Smart Slider'
  WHERE link LIKE 'option=com_smartslider';
  
  
UPDATE `#__plugins` SET published=1 WHERE element='smartsliderinsert'