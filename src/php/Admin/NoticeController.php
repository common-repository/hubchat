<?php namespace Hubchat\WordPressPlugin\Admin;

class NoticeController
{
    public function __construct(
        $hubchatOptions,
        $setupNoticeView,
        $discussionSettingsNoticeView
    ) {
        $this->hubchatOptions = $hubchatOptions;
        $this->setupNoticeView = $setupNoticeView;
        $this->discussionSettingsNoticeView = $discussionSettingsNoticeView;
    }

    public function showNotices()
    {
        $communitySlug = $this->hubchatOptions->getCommunitySlug();

        if (empty($communitySlug) &&
            get_current_screen()->base === 'plugins') {
            return $this->setupNoticeView->render();
        } elseif (!empty($communitySlug) &&
            get_current_screen()->base === 'options-discussion') {
            return $this->discussionSettingsNoticeView->render();
        }

        return '';
    }
}
