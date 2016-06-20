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

        // lifetime in minutes, equals 2 hours.
        $lifetime = 3 * 60;

        session_set_cookie_params($lifetime * 60, "/mds/", null, null, true);
        session_name("RAT");

        session_start();

        // update last time visited cookie
        setcookie(session_name(), session_id(), time() + $lifetime * 60, "/mds/", null, null, true);

        // filter variables
        $this->get = filter_input_array(INPUT_GET);
        $this->post = filter_input_array(INPUT_POST);
        $this->cookie = filter_input_array(INPUT_COOKIE);
        $this->server = filter_input_array(INPUT_SERVER);

        $this->get = $this->sanitize($this->get);
        $this->post = $this->sanitize($this->post);

        // set globals
        $this->globals = $GLOBALS;
    }

    /**
     * Sanitizes array
     * @param $array string[]
     * @return string[]
     */
    private function sanitize($array)
    {
        if (empty($array))
            return $array;

        foreach ($array as &$item) {
            $item = filter_var($item, FILTER_SANITIZE_SPECIAL_CHARS);
        }
        unset($item);
        return $array;
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