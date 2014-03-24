<?php

namespace PROJ\Tools;

/**
 * Description of Template
 *
 * @author Patrick
 */
class Template {

    protected $template;
    protected $variables = array();
    private $viewLocation;

    /**
     * 
     * @param string $template Name of the template file to use
     */
    public function __construct($template) {
        $this->viewLocation = BASE_PATH . "Classes" . DS . "PROJ" . DS . "Views";
        $this->template = $this->viewLocation . DS . $template . ".phtml";

        if (!file_exists($this->template)) {
            $msgString = "No valid viewFile exists. Tried to find \"%s\" using path \"%s\".";
            $msg = sprintf($msgString, $template, $this->template);
            throw new \Exception($msg);
        }
    }

    public function __get($key) {
        return $this->variables[$key];
    }

    public function __set($key, $value) {
        $this->variables[$key] = $value;
    }

    /**
     * Returns the generated view
     * @return string
     */
    public function __toString() {
        //Create local variables from our array of variables.
        extract($this->variables);
        chdir(dirname($this->template));
        ob_start();

        include $this->template;

        return ob_get_clean();
    }

}
