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

    /**
     * Request constructor.
     * @param array $get
     * @param array $post
     * @param array $cookie
     * @param array $server
     */
    public function __construct($get, $post, $cookie, $server)
    {
        // start SESSION
        session_start();

        $this->get = $this->curate($get);
        $this->post = $this->curate($post);
        $this->cookie = $cookie;
        $this->server = $server;
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