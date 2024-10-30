<?php namespace Hubchat\WordPressPlugin;

class View
{
    public $templatePath;

    public function __construct($templatePath)
    {
        $this->templatePath = $templatePath;
    }

    public function render($params = array())
    {
        extract($params);
        ob_start();
        require $this->templatePath;
        return ob_get_clean();
    }
}
