<?php

/**
 * Created at: 29/03/16 15:44
 */
class Database
{
    ########## FETCH MODES ##########

    const FETCH_NONE = 0;
    const FETCH_ONE = 1;
    const FETCH_ALL = 2;

    ########## PRIVATE ##########

    private $dbh;
    /** @var Exception */
    private $lastError;

    ########## CONSTRUCTOR ##########

    private function __construct()
    {
        // wow.
        $this->dbh = new \PDO("mysql:host=localhost;dbname=x28xioro_mds;charset=utf8", "x28xioro_mds", "MDS123$");

        // throw exceptions on fail, and always use fetching associative.
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    ########## SINGLETON ##########

    /**
     * Returns the singleton instance of the Database.
     * @return Database
     */
    public static function instance()
    {
        static $singleton = null;

        // if class not spawned yet, spawn.
        if ($singleton === null)
            $singleton = new Database();

        return $singleton;
    }

    /**
     * Runs, Executes and fetches none, one, or all return values.
     * @param string $string SQL Query.
     * @param array [$array] Prepared items.
     * @param int [$fetchType] Fetch Type. Can be FETCH_NONE, FETCH_ONE, or FETCH_ALL.
     * @return boolean|array Returns true|false if FETCH_NONE, false|array if FETCH_ONE or FETCH_ALL
     */
    public function query($string, $array = [], $fetchType = Database::FETCH_NONE)
    {
//        \Log::d("LOG QUERY", $string, $array, $fetchType);
        // set last error to null.
        $this->lastError = null;
        try {

            // prepare statement.
            $prepare = $this->dbh->prepare($string);

            // execute query
            $value = $prepare->execute($array);

            // if should not fetch anything, return value.
            if ($fetchType == Database::FETCH_NONE) {
                return $value;
                // if fetching one item, fetch (or return false).
            } else if ($fetchType == Database::FETCH_ONE) {
                return $value ? $prepare->fetch() : false;
            }

            // fetching multiple
            return $value ? $prepare->fetchAll() : false;
        } catch (Exception $prepare) {

            // on exception, set last error.
            $this->lastError = $prepare;

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

    /**
     * Returns last error.
     * @return false|string Last error in a readable format.
     */
    public function lastError()
    {
        if ($this->lastError === null)
            return false;
        // get message
        $message = $this->lastError->getMessage();

        // remove PDO clause
        $lastDots = strrpos($message, ":") + 1;
        $error = substr($message, $lastDots);

        // trim space left/right for compactness.
        $trimmedError = trim($error);

        return $trimmedError;
    }

}