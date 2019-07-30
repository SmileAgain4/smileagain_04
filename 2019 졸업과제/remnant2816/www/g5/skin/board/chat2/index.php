<?php
include_once('./_common.php');
include_once('./_head.sub.php');

add_javascript('<script src="./js/app.min.js"></script>');
add_stylesheet('<link rel="stylesheet" href="./css/style.css">');
?>

<div id="chat_wrap" class="wrap_chat">
    <div>
        <div class="header">
            <div class="title_area">채 팅</div>
        </div>
    </div>
    <div>
        <div class="cont_chat">
            <ul>
            </ul>
        </div>
        <div class="box_chat">
            <div class="frame_msg">
                <textarea id="msgInputArea" class="tf_msg"></textarea>
            </div>
        </div>
    </div>
</div>

<script>
var userId = "<?php echo $member['mb_id'] ?>";
var usernick = "<?php echo $member['mb_nick'] ?>";
var userlevel = "<?php echo $member['mb_level'] ?>";
</script>

<script>
<?php
$mb_img = '';
$member_img = G5_DATA_PATH.'/member_image/'.substr($member['mb_id'],0,2).'/'.$member['mb_id'].'.gif';
if (is_file($member_img)) {
    $mb_img = str_replace(G5_DATA_PATH, G5_DATA_URL, $member_img);
}
?>
var userId = '<?php echo $member['mb_id']; ?>';
var profile_img = '<?php echo $mb_img; ?>';
var chat_use = false;
</script>
<script src="./js/chatApp.js?ver=<?php echo G5_JS_VER ?>"></script>