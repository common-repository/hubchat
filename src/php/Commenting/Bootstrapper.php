<?php namespace Hubchat\WordPressPlugin\Commenting;

class Bootstrapper
{
    public function __construct($commentCountView, $hubchatOptions, $hubchatClientApiUrl)
    {
        $this->commentCountView = $commentCountView;
        $this->hubchatOptions = $hubchatOptions;
        $this->hubchatClientApiUrl = $hubchatClientApiUrl;
    }

    public function bootstrap()
    {
        add_filter('comments_number', array($this, 'injectCommentCountMarkup'));
        add_filter('comments_template', array($this, 'overrideCommentsTemplate'));
        add_filter('respond_link', array($this, 'filterRespondLink'));
        add_action('wp_enqueue_scripts', array($this, 'enqueueHubchatJS'));
        add_filter('get_comments_number', array($this, 'fakeCommentCount'));
    }

    public function enqueueHubchatJS()
    {
        // TODO: Add cache busting
        wp_enqueue_script(
            'hubchat-api',
            $this->hubchatClientApiUrl,
            array(),
            null,
            true
        );
    }

    public function injectCommentCountMarkup()
    {
        global $post;
        return $this->commentCountView->render(array(
            'communitySlug' => $this->hubchatOptions->getCommunitySlug(),
            'embeddedId' => $post->ID
        ));
    }

    public function overrideCommentsTemplate()
    {
        return __DIR__ . '/views/comments.php';
    }

    /** @SuppressWarnings("unused") */
    public function filterRespondLink($link, $postId = null)
    {
        return get_permalink($postId) . '#comments';
    }

    public function fakeCommentCount()
    {
        // Returning the proper count here would require a request to the
        // Hubchat API. We can't do that (for now), so return zero to make
        // eg. themes depending on the get_comments_number() function
        // behave somewhat sensibly.
        return 0;
    }
}
