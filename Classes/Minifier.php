<?php

/**
 * Created at: 14/04/16 16:55
 */
class Minifier
{
    const CACHE_PATH = __DIR__ . "/../content/cache/";

    /**
     * Minifier constructor.
     */
    private function __construct()
    {
    }


    public static function instance()
    {
        static $instance = null;

        if ($instance == null)
            $instance = new Minifier();

        return $instance;
    }


    /**
     * Returns path of the minified file
     * @param $text string
     * @param $contentPath string
     * @return false|string
     */
    public function css($text, $contentPath)
    {
        return $this->minify(true, $text, $contentPath);
    }

    /**
     * Returns path of the minified file
     * @param $isCSS boolean
     * @param $text string
     * @param $contentPath string
     * @return string
     */
    public function minify($isCSS, $text, $contentPath)
    {
        $extension = $isCSS ? ".min.css" : ".min.js";
        $crc = crc32($text);
        $cachePath = self::CACHE_PATH . "{$crc}{$extension}";
        $contentPath = rtrim($contentPath, "/") . "/cache/{$crc}{$extension}";

        // is already minified
        if (is_file($cachePath)) {
            return $contentPath;
        }

        // if css, execute minify CSS
        if ($isCSS) {
            $this->executeCSS($text, $cachePath);

            return $contentPath;
        }

        $this->executeJS($text, $cachePath);
        return $contentPath;
    }

    private function executeCSS($text, $cachePath)
    {
        file_put_contents($cachePath, (new CSSmin(false))->run($text));
    }

    private function executeJS($text, $cachePath)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(["js_code" => $text]));
        curl_setopt($ch, CURLOPT_URL, "http://marijnhaverbeke.nl/uglifyjs/");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        $return = curl_exec($ch);
        file_put_contents($cachePath, $return);
    }

    /**
     * Returns path of the minified file
     * @param $text string
     * @param $contentPath string
     * @return false|string
     */
    public function js($text, $contentPath)
    {
        return $this->minify(false, $text, $contentPath);
    }
}