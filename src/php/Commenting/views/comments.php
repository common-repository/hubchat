<?php

global $post;
$forumSlug = get_option('hubchat_community_slug');
$embeddedId = $post->ID;
$embeddedTitle = $post->post_title;

?>

<!-- id attribute is an anchor for direct linking
to comments from eg. the home page. -->
<div id="comments" class="hubchat-comments"
  data-forum-slug="<?php echo htmlspecialchars($forumSlug); ?>"
  data-embedded-id="<?php echo htmlspecialchars($embeddedId); ?>"
  data-embedded-title="<?php echo htmlspecialchars($embeddedTitle); ?>"
  data-style="{&quot;margin&quot;: &quot;&quot;}">
</div>
