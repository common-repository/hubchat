<?php namespace Hubchat\WordPressPlugin\Admin;

class IframeUrl
{
    public function __construct($hubchatHost, $siteUrl, $backgroundColor)
    {
        $this->hubchatHost = $hubchatHost;
        $this->siteUrl = $siteUrl;
        $this->backgroundColor = $backgroundColor;
    }

    public function build($communitySlug = null)
    {
        $params = array(
            'siteUrl' => $this->siteUrl,
            'backgroundColor' => $this->backgroundColor
        );
        if (!empty($communitySlug)) {
            $params['communitySlug'] = $communitySlug;
        }
        $query = http_build_query($params);
        return "{$this->hubchatHost}/embedded/wordpress?{$query}";
    }
}
