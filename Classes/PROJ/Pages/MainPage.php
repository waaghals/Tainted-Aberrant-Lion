<?php

namespace PROJ\Pages;

abstract class MainPage {

    abstract function getContent();

    function shouldShowHeader() {
        return true;
    }

    function shouldShowFooter() {
        return true;
    }

    function isHtml() {
        return true;
    }

    protected $parameters;

    function __construct() {
        //Nothing to do here
    }

    function show() {
        $return = null;
        if ($this->isHtml())
            if ($this->shouldShowHeader())
                $return .= $this->getHeader();

        $return .= $this->getContent();

        if ($this->isHtml())
            if ($this->shouldShowFooter())
                $return .= $this->getFooter();

        return $return;
    }

    function setURLParameters($parameters) {
        $this->parameters = $parameters;
    }

    function getHeader() {
        $header = new \PROJ\View\Header();
        return $header->getContent();
    }

    function getFooter() {
        $footer = new \PROJ\View\Footer();
        return $footer->getContent();
    }

}

?>