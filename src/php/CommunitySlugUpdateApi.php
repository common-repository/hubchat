<?php namespace Hubchat\WordPressPlugin;

class CommunitySlugUpdateApi
{
    protected $options;

    public function __construct($options, $router, $nonceName)
    {
        $this->options = $options;
        $this->router = $router;
        $this->nonceName = $nonceName;
    }

    public function bootstrap()
    {
        $this->router->post(
            'update_hubchat_community_slug',
            array($this, 'handleCommunitySlugUpdateRequest')
        );
    }

    public function handleCommunitySlugUpdateRequest($input)
    {
        // Verify the nonce (aka CSRF token). Stops execution if
        // a valid nonce is not present in the request.
        check_ajax_referer($this->nonceName);

        if (current_user_can('manage_options') &&
            isset($input['slug'])) {
            $this->options->updateCommunitySlug($input['slug']);
        }
    }
}
