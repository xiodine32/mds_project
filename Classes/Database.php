<?php

/**
 * Created at: 29/03/16 15:44
 */
class Database
{
    const FETCH_NONE = 0;
    const FETCH_ONE = 1;
    const FETCH_ALL = 2;
    private $dbh;

    private function __construct()
    {
        $this->dbh = new \PDO("mysql:host=localhost;dbname=x28xioro_mds;charset=utf8", "x28xioro_mds", "MDS123$");
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    /**
     * @return Database
     */
    public static function instance()
    {
        static $singleton = null;
        if ($singleton === null)
            $singleton = new Database();
        return $singleton;
    }

    /**
     * @param string $string
     * @param array [$array]
     * @param int [$fetchType]
     * @return mixed|null
     */
    public function query($string, $array = [], $fetchType = Database::FETCH_NONE)
    {
        try {
//        echo "<pre>";var_dump("query", $string, $array);echo "</pre>";

            $e = $this->dbh->prepare($string);


            $value = $e->execute($array);


            if ($fetchType == Database::FETCH_NONE) {

                return $value;

            } else if ($fetchType == Database::FETCH_ONE) {
                if ($value)
                    return $e->fetch();
                return false;

            }

            if ($value) {

                return $e->fetchAll();

            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Last insert ID
     * @param null|string $name
     * @return string
     */
    public function lastInsertId($name = null)
    {
        return $this->dbh->lastInsertId($name);
    }

}