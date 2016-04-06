<?php

/**
 * Created at: 06/04/16 11:05
 */
class Request
{
    public $get;
    public $post;
    public $cookie;
    public $server;
    public $globals;

    /**
     * Request constructor.
     */
    private function __construct()
    {
        // start SESSION
        session_start();

        $this->get = $this->curate($_GET);
        $this->post = $this->curate($_POST);
        $this->cookie = $_COOKIE;
        $this->server = $_SERVER;
        $this->globals = $GLOBALS;
    }

    /**
     * Curate an array with XSS injection proofing.
     * @param $item mixed
     * @return mixed
     */
    private function curate($item)
    {
        if (is_array($item)) {
            foreach ($item as $key => $value) {
                $item[$key] = $this->curate($value);
            }
            return $item;
        }

        // should be a string
        if (!is_callable($item))
            return htmlspecialchars($item);
        return $item;
    }

    public static function getInstance()
    {
        static $singleton = null;
        if ($singleton === null)
            $singleton = new Request();

        return $singleton;
    }

    /**
     * Get Session Key.
     * @param string $key
     * @return null|mixed
     */
    public function getSession($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * Set Session Key.
     * @param string $key
     * @param mixed $value
     */
    public function setSession($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Delete Session Key
     * @param string $key
     */
    public function delSession($key)
    {
        unset($_SESSION[$key]);
    }
}