<?php
/*
 * Created on Sep 15, 2009
 *
 * This is the Connection object.  This object creates a connection
 * to the database upon calling it and tears down the connection
 * automatically when it is finished.
*/
class Connection {
    private $databaseLink;
    private $dbhost;
    private $dbuser;
    private $dbpass;
    private $dbname;
    function __construct($dbhost, $dbuser, $dbpass, $dbname) {
        $this->dbhost = $dbhost;
        $this->dbuser = $dbuser;
        $this->dbpass = $dbpass;
        $this->dbname = $dbname;
        $this->databaseLink = mysql_connect($dbhost, $dbuser, $dbpass);
        if ($this->databaseLink) {
            if (!mysql_select_db($dbname)) {
                echo "Could not change to database " . $dbname;
                die;
            }
        } else {
            echo "Could not connect to the MySQL database ";
            die;
        }
    }
    public function get_databaseLink() {
        return $this->databaseLink;
    }
    function __destruct() {
        // Tears down the database connection.
        mysql_close($this->databaseLink);
    }
}
?>
