<?php

/**
 * Created at: 14/04/16 15:14
 */
abstract class ViewComposite extends View
{
    private $beforeView;
    private $afterView;

    public function __construct($name, $isPartial)
    {
        $this->beforeView = "";
        $this->afterView = "";
        parent::__construct($name, $isPartial);
    }

    /**
     * @return string
     */
    public function getBeforeView()
    {
        return $this->beforeView;
    }

    /**
     * @param string $beforeView
     */
    public function setBeforeView($beforeView)
    {
        $this->beforeView = $beforeView;
    }

    /**
     * @return string
     */
    public function getAfterView()
    {
        return $this->afterView;
    }

    /**
     * @param string $afterView
     */
    public function setAfterView($afterView)
    {
        $this->afterView = $afterView;
    }

    protected function includeItem($item)
    {
        if ($item === $this->getName()) {
            $this->beforeView();
        }
        parent::includeItem($item);
        if ($item === $this->getName()) {
            $this->afterView();
        }
    }

    private function beforeView()
    {
        echo $this->beforeView;
    }

    private function afterView()
    {
        echo $this->afterView;
    }

}