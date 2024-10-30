<?php

$hubchatHost = getenv('HUBCHAT_HOST');

$config = array(
    'hubchatHost' => $hubchatHost ?: 'https://www.hubchat.com',
    'mixpanelToken' => getenv('HUBCHAT_MIXPANEL_TOKEN') ?: 'b42f9521b6008a9598a7460575f502ee'
);
