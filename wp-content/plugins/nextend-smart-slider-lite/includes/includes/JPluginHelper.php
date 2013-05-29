<?php
class OfflajnJPluginHelper extends JPluginHelper{
  public static function importPlugin($type, $plugin = null, $autocreate = true, $dispatcher = null)
	{
		static $loaded = array();
    
		// check for the default args, if so we can optimise cheaply
		$defaults = false;
		if (is_null($plugin) && $autocreate == true && is_null($dispatcher))
		{
			$defaults = true;
		}

		if (!isset($loaded[$type]) || !$defaults)
		{
			$results = null;

      $plugins = array();
      foreach(JFolder::folders(JPATH_PLUGINS.DIRECTORY_SEPARATOR.$type) AS $name){
        $plg = new stdClass();
        $plg->type = $type;
        $plg->name = $name;
        $plugins[] = $plg;
      }
			// Get the specified plugin(s).
			for ($i = 0, $t = count($plugins); $i < $t; $i++)
			{
				if ($plugins[$i]->type == $type && ($plugin === null || $plugins[$i]->name == $plugin))
				{
					self::_import($plugins[$i], $autocreate, $dispatcher);
					$results = true;
				}
			}

			// Bail out early if we're not using default args
			if (!$defaults)
			{
				return $results;
			}
			$loaded[$type] = $results;
		}

		return $loaded[$type];
	}
}
?>