<?php

jimport('joomla.database.database.mysql');
JLoader::register('JDatabaseMySQL', dirname(__FILE__) . '/../libraries/joomla/database/database/mysql.php');
JLoader::register('JDatabaseQueryMySQLWP', dirname(__FILE__) . '/JDatabaseQueryMySQLWP.php');

class JDatabaseMySQLWP extends JDatabaseMySQL{
	public function getQuery($new = false)
	{
		if ($new)
		{
			// Make sure we have a query class for this driver.
			if (!class_exists('JDatabaseQueryMySQLWP'))
			{
				throw new JDatabaseException(JText::_('JLIB_DATABASE_ERROR_MISSING_QUERY'));
			}
			return new JDatabaseQueryMySQLWP($this);
		}
		else
		{
			return $this->sql;
		}
	}
}
?>