<?php

/**
 * Created by PhpStorm.
 * User: xiodine
 * Date: 4/10/2016
 * Time: 6:24 PM
 */
class ViewContent extends View
{

    private $metadataType;
    private $fileContent;
    private $fileName;

    /**
     * ContentView constructor.
     * @param string $metadataType
     * @param string $fileContent
     */
    public function __construct($metadataType, $fileContent, $fileName)
    {
        $this->metadataType = $metadataType;
        $this->fileContent = $fileContent;
        $this->fileName = $fileName;

        // always partial view.
        parent::__construct("", true);
    }

    protected function includeItem($item)
    {
        if (substr($item, -5) !== "/.php") {
            return;
        }
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=\"{$this->fileName}\"");
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($this->fileContent));
        echo $this->fileContent;
    }
}