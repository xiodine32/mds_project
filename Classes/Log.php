<?php

/**
 * Created at: 19/04/16 15:34
 */
class Log
{
    const LOG_PATH = __DIR__ . "/Logs/";

    private function __construct()
    {
    }

    /**
     * @param string $text,... unlimited
     */
    public static function d($text)
    {
        self::l("DEBUG", func_get_args(), debug_backtrace());
    }

    private static function l($type, $arguments, $backtrace)
    {
        $interesting = [];
        foreach ($backtrace as $bt) {
            if (!isset($bt['class']))
                $bt['class'] = '';
            if (!isset($bt['type']))
                $bt['type'] = '';
            $interesting[] = [
                "file" => substr($bt['file'], 31),
                "line" => $bt['line'],
                "class" => $bt['class'],
                "call" => $bt["class"] . $bt["type"] . $bt["function"]
            ];
        }
        foreach ($arguments as &$argument) {
            if (is_array($argument))
                $argument = '[' . implode(", ", $argument) . ']';
            if (is_string($argument))
                $argument = str_replace("\n", "", $argument);
        }
        unset($argument);


        $str = "{$type} % [{$interesting[1]['file']}:{$interesting[1]['line']}" .
            " - " .
            "{$interesting[0]['file']}:{$interesting[0]['line']}]: {$interesting[1]['call']} => " .
            join(" | ", $arguments) . "\n";

        $basename = basename($interesting[0]['file'], '.php');
        $date = date('Y-m-d');

        if (!is_dir(self::LOG_PATH . $date))
            mkdir(self::LOG_PATH . $date);

        file_put_contents(self::LOG_PATH . "{$date}/{$basename}.log", $str, FILE_APPEND);
    }

    /**
     * @param $text,... string
     */
    public static function w($text)
    {
        self::l("WARNING", func_get_args(), debug_backtrace());
    }

    /**
     * @param $text,... string
     */
    public static function e($text)
    {
        self::l("ERROR", func_get_args(), debug_backtrace());
    }


}