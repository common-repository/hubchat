<?php namespace Hubchat\WordPressPlugin\Admin;

class Controller
{
    public function __construct(
        $iframeUrl,
        $adminPageView,
        $hubchatOptions
    ) {
        $this->iframeUrl = $iframeUrl;
        $this->adminPageView = $adminPageView;
        $this->hubchatOptions = $hubchatOptions;
    }

    public function showAdminPage()
    {
        $communitySlug = $this->hubchatOptions->getCommunitySlug();
        $params = array('iframeUrl' => $this->iframeUrl->build($communitySlug));
        return $this->adminPageView->render($params);
    }
}
