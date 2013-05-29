<?php
class JDatabaseQueryMySQLWP extends JDatabaseQueryMySQL{
  public function __toString()
	{
    $sql = parent::__toString();
    preg_match('/#__[a-zA-Z0-9_]*/',(string) $this->from, $o);
    if(isset($o[0]) && !in_array($o[0], $GLOBALS['EXISTINGJOOMLATABLES'])){
      if($o[0] == '#__extensions'){
        return 'SELECT 1';
      }
    }
    return $sql;
  }
}
?>