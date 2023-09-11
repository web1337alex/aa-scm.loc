<?
function getAddPostContent($postObj)
    {
        $postItem = [];
        $postItem['visible'] = get_field('visible_post', $postObj->ID);
        $postItem['content_post'] = get_field('content_post', $postObj->ID);
        $postItem['image'] = get_the_post_thumbnail_url($postObj->ID);
        $postItem['title'] = $postObj->post_title;
        if ($postItem['visible']['price'] == true) {
            $postItem['price'] = $postItem['content_post']['price'];
        }
        if ($postItem['visible']['params'] == true) {
            $postItem['params'] = $postItem['content_post']['params'];
        }
        if ($postItem['visible']['date'] == true) {
            $postItem['date'] = get_the_date('d.m.Y', $postObj->ID);
        }
        if ($postItem['visible']['desc'] == true) {
            $postItem['desc'] = get_the_excerpt($postObj->ID);
        }
        if ($postItem['visible']['video'] == true) {
            $postItem['video'] = $postItem['content_post']['video'];
        }
        if ($postItem['visible']['new_labels'] == true) {
            $postItem['new_labels'] = $postItem['content_post']['new_labels'];
        }

        $postItem['title'] = get_the_title($postObj->ID);
        $postItem['url'] = get_permalink($postObj->ID);

        return $postItem;
    }
?>