<?php namespace Hubchat\WordPressPlugin;

class WPAjaxRouter
{
    /** @SuppressWarnings(PHPMD.Superglobals) */
    public function post($actionName, $handler)
    {
        add_action("wp_ajax_{$actionName}", function () use ($handler) {
            // Use the $_SERVER superglobal instead of
            // filter_input(INPUT_SERVER, ...), because filter_input has buggy
            // behavior with INPUT_SERVER.
            // See: http://www.php.net/manual/en/function.filter-input.php#77307
            $requestMethod = $_SERVER['REQUEST_METHOD'];
            if ($requestMethod === 'POST') {
                call_user_func($handler, filter_input_array(INPUT_POST));
            }
            wp_die();
        });
    }
}
