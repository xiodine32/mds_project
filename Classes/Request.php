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
        $lifetime = 180;
        session_cache_expire($lifetime);
        session_cache_limiter("private");
        session_set_cookie_params($lifetime, "/mds/", null, null, true);
        session_name("RAT");
        session_start();
        setcookie(session_name(), session_id(), time() + $lifetime, "/mds/", null, null, true);

        $this->get = filter_input_array(INPUT_GET);
        $this->post = filter_input_array(INPUT_POST);
        $this->cookie = filter_input_array(INPUT_COOKIE);
        $this->server = filter_input_array(INPUT_SERVER);
        $this->globals = $GLOBALS;
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
     * @return mixed the filtered data, or <b>NULL</b> if the filter fails.
     */
    public function getSession($key)
    {
        return isset($_SESSION[$key]) ? filter_var($_SESSION[$key]) : null;
    }

    /**
     * Set Session Key.
     * @param string $key
     * @param mixed $value
     */
    public function setSession($key, $value)
    {
        $_SESSION[$key] = filter_var($value);
    }

    /**
     * Delete Session Key
     * @param string $key
     */
    public function delSession($key)
    {
        unset($_SESSION[$key]);
    }

    public function lockSession()
    {
        session_write_close();
    }
}