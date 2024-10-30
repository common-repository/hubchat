<?php namespace Hubchat\WordPressPlugin;

class HubchatOptions
{
    public function getCommunitySlug()
    {
        return get_option('hubchat_community_slug');
    }

    public function updateCommunitySlug($slug)
    {
        update_option('hubchat_community_slug', $slug);
    }

    public function clear()
    {
        delete_option('hubchat_community_slug');
    }
}
