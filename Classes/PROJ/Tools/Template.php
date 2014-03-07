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
        $this->viewLocation = realpath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "View");
        $this->template = $this->viewLocation . DIRECTORY_SEPARATOR . $template . ".phtml";
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

        include basename($this->template);

        return ob_get_clean();
    }

}
