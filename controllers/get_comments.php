<?php

$post_id = $post['id'];

/*$sql = "SELECT
    c.id,
    c.user_id,
    c.comment,
    c.comment_id,
    u.username,
    COALESCE(user_like.is_liked, 0) AS isLiked,
    COALESCE(like_count.total_likes, 0) AS likes
FROM comments AS c

INNER JOIN users AS u
    ON u.id = c.user_id

-- Get the current user's like status
LEFT JOIN user_comment_likes AS user_like
    ON user_like.comment_id = c.id
    AND user_like.user_id = ?

-- Get total likes for the comment
LEFT JOIN (
    SELECT
        comment_id,
        COUNT(*) AS total_likes
    FROM user_comment_likes
    WHERE is_liked = 1
    GROUP BY comment_id
) AS like_count
    ON like_count.comment_id = c.id

WHERE c.comment_id IS NULL";*/

$sql="SELECT
    c.id,
    c.user_id,
    c.comment,
    c.comment_id,
    u.username,

    COALESCE(user_like.is_liked, 0) AS isLiked,
    COALESCE(like_count.total_likes, 0) AS likes,
    COALESCE(reply_count.total_replies, 0) AS total_replies

FROM comments AS c

INNER JOIN users AS u
    ON u.id = c.user_id

-- Get the current user's like status
LEFT JOIN user_comment_likes AS user_like
    ON user_like.comment_id = c.id
    AND user_like.user_id = ?

-- Get total likes for the comment
LEFT JOIN (
    SELECT
        comment_id,
        COUNT(*) AS total_likes
    FROM user_comment_likes
    WHERE is_liked = 1
    GROUP BY comment_id
) AS like_count
    ON like_count.comment_id = c.id

-- Get total replies for the comment
LEFT JOIN (
    SELECT
        comment_id,
        COUNT(*) AS total_replies
    FROM comments
    WHERE comment_id IS NOT NULL
    GROUP BY comment_id
) AS reply_count
    ON reply_count.comment_id = c.id

WHERE c.comment_id IS NULL AND c.post_id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $_SESSION['user_id'], $post_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$comments = mysqli_fetch_all($result, MYSQLI_ASSOC);

$tree = [];

foreach($comments as &$comment) {
    
    $comment['replies'] = array();
    
    if ($comment['comment_id'] === null) {
        $tree[$comment['id']] = $comment;    
    }
    else{
        $tree[$comment['id']] = $comment;
        $tree[$comment['comment_id']]['replies'][$comment['id']] =  $comment;
    }
}


function addReplies(&$tree, &$tree_node){
    foreach($tree_node['replies'] as $reply_node){        
        $tree_node['replies'][$reply_node['id']] = addReplies($tree, $tree[$reply_node['id']]);
    }
    return $tree_node;
}

foreach($tree as &$tree_node){
    if( ! empty($tree_node['replies']) ){
        $tree_node[$tree_node['id']] = addReplies($tree, $tree_node);            
    }    

}

$json_array = json_encode($tree, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

?>

<?php

/*
function print_comment($post_id, $depth, &$comment){
    $spaces = str_repeat("&nbsp;&nbsp;&nbsp;", $depth); 
    echo $spaces."".$comment['id']." . ".$comment['comment']."<span onclick='toggleReplyForm(".$comment['id'].")'>Reply</span><br/>";
    echo "<form style='display:none' id='reply_form_".$comment['id']."' method='post' action='/blog_api/public/post_reply'>".$spaces."<input type='hidden' name='comment_id' value='".$comment['id']."'/>".$spaces."<input type='hidden' name='blog_id' value='".$post_id."'/>".$spaces."<input type='text' name='reply' placeholder='Reply...' required/><input type='submit' value='Post'/></form>";
    echo "<br/>";
    
    if (! empty($comment['replies'])){
        $depth = $depth+3;    
        foreach($comment['replies'] as $c){
            print_comment($post_id, $depth, $c);
        }
    }
}

<!--
<script>
    function toggleReplyForm(comment_id){
        let form = document.getElementById('reply_form_'+comment_id);
        if (form.style.display === "none") {
            form.style.display = "block";
        } else {
            form.style.display = "none";
        }
    }
</script>
-->

foreach ($tree as $comment) {
    $depth = 0;
    if(! $comment['comment_id']){
        //print_comment($post_id, $depth, $comment);
    }
    
}
*/
/*
SELECT p.id, p.comment, CASE WHEN COUNT(r.id) = 0 THEN JSON_ARRAY() ELSE JSON_ARRAYAGG( JSON_OBJECT( 'id', r.id, 'comment', r.comment ) ) END AS replies FROM comments p LEFT JOIN comments r ON r.comment_id = p.id GROUP BY p.id, p.comment;
*/

?>


