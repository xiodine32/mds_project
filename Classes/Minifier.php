<?php


/**
 * Created at: 14/04/16 16:55
 */
class Minifier
{
    const CACHE_PATH = __DIR__ . "/../content/cache/";
    private static $ch = null;
    /**
     * Minifier constructor.
     */
    private function __construct()
    {
//        define("DISABLE_MINIFY_JUICY", 1);
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
     * @see Minifier::minify
     * @param $text string
     * @param $contentPath string
     * @param bool $extraJuice
     * @return false|string
     */
    public function css($text, $contentPath, $extraJuice = true)
    {
        return $this->minify(true, $text, $contentPath, $extraJuice);
    }

    /**
     * MAIN ACCESS POINT
     * ===
     *
     * Returns path of the minified file
     * @param $isCSS boolean
     * @param $text string
     * @param $contentPath string
     * @param bool $extraJuice
     * @return string
     */
    public function minify($isCSS, $text, $contentPath, $extraJuice = true)
    {
        if (defined("DISABLE_MINIFY_JUICY"))
            $extraJuice = false;
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
            $this->executeCSS($text, $cachePath, $extraJuice);

            return $contentPath;
        }

        $this->executeJS($text, $cachePath, $extraJuice);
        return $contentPath;
    }

    private function executeCSS($text, $cachePath, $extraJuice)
    {
        if ($extraJuice) {
            $text = (new \CSSmin())->run($text);
        }

        file_put_contents($cachePath, $text);
    }

    private function executeJS($text, $cachePath, $extraJuice)
    {

        $return = $text;

        if ($extraJuice) {
            if (self::$ch == null)
                self::$ch = curl_init();
            curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(self::$ch, CURLOPT_POST, true);
            curl_setopt(self::$ch, CURLOPT_POSTFIELDS, http_build_query(["js_code" => $text]));
            curl_setopt(self::$ch, CURLOPT_URL, "http://marijnhaverbeke.nl/uglifyjs/");
            curl_setopt(self::$ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            $return = curl_exec(self::$ch);
        }
        file_put_contents($cachePath, $return);
    }

    /**
     * Returns path of the minified file
     * @see Minifier::minify
     * @param $text string
     * @param $contentPath string
     * @param bool $extraJuice
     * @return false|string
     */
    public function js($text, $contentPath, $extraJuice = true)
    {
        return $this->minify(false, $text, $contentPath, $extraJuice);
    }
}