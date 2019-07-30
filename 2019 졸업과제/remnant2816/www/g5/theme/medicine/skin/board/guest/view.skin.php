<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 글 내용보기 페이지는 의미가 없으므로 다른 페이지로 redirect 시킴. 관리자는 볼수 있게 한다.
//if (!$c) {
//	goto_url('./board.php?bo_table='.$bo_table);
//	exit();
//}

include_once(G5_LIB_PATH.'/thumbnail.lib.php');
?>

<link rel="stylesheet" href="<?php echo $board_skin_url ?>/style.css">
<div style="margin:0 0 10px 2px;">
<a href="<?=G5_BBS_URL;?>/board.php?bo_table=<?=$bo_table;?>">목록으로</a>
</div>
<!-- 게시물 읽기 시작 { -->
        <div class="guestwrap">
        <div class="list">
            <div class="left">
                <?php if ($is_checkbox) { ?>
                <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
                <?php } ?>
                <?php echo date("y-m-d", strtotime($view['wr_datetime'])) ?>
            </div>
            <div class="right">
                <div class="auther"><?php echo $view['name'] ?></div>
                <div style="width:600px; word-break:break-all; white-space:pre-wrap"><?php echo $view['wr_subject'] ?></div>
                <div style="margin-top:10px; font-size:11px;">
                    <?php if ($update_href) { ?><a href="<?php echo $update_href ?>" >수정</a><?php } ?>
            <?php if ($delete_href) { ?><a href="<?php echo $delete_href ?>" onclick="del(this.href); return false;">삭제</a><?php } ?>
                </div>
            </div>
        </div>
        </div>


<article id="bo_v" style="width:<?php echo $width; ?>">

	<?php
	include_once(G5_SNS_PATH."/view.sns.skin.php");
	?>

	<?php
	// 코멘트 입출력
	include_once('./view_comment.php');
	?>

	<!-- 링크 버튼 시작 { -->
	<div id="bo_v_bot">
		<?php echo $link_buttons ?>
	</div>
	<!-- } 링크 버튼 끝 -->

</article>
<!-- } 게시판 읽기 끝 -->

<script>
<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
	$("a.view_file_download").click(function() {
		var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

		if(confirm(msg)) {
			var href = $(this).attr("href")+"&js=on";
			$(this).attr("href", href);

			return true;
		} else {
			return false;
		}
	});
});
<?php } ?>

function board_move(href)
{
	window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

<script>
// 이미지 등비율 리사이징
$(window).load(function() {
	view_image_resize();
});

var now = new Date();
var timeout = false;
var millisec = 200;
var tid;

$(window).resize(function() {
	now = new Date();
	if (timeout === false) {
		timeout = true;

		if(tid != null)
			clearTimeout(tid);

		tid = setTimeout(resize_check, millisec);
	}
});

function resize_check() {
	if (new Date() - now < millisec) {
		if(tid != null)
			clearTimeout(tid);

		tid = setTimeout(resize_check, millisec);
	} else {
		timeout = false;
		view_image_resize();
	}
}

$(function() {
	$("a.view_image").click(function() {
		window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
		return false;
	});

	// 추천, 비추천
	$("#good_button, #nogood_button").click(function() {
		var $tx;
		if(this.id == "good_button")
			$tx = $("#bo_v_act_good");
		else
			$tx = $("#bo_v_act_nogood");

		excute_good(this.href, $(this), $tx);
		return false;
	});
});

function view_image_resize()
{
	var $img = $("#bo_v_atc img");
	var img_wrap = $("#bo_v_atc").width();
	var win_width = $(window).width() - 35;
	var res_width = 0;

	if(img_wrap < win_width)
		res_width = img_wrap;
	else
		res_width = win_width;

	$img.each(function() {
		var img_width = $(this).width();
		var img_height = $(this).height();
		var this_width = $(this).data("width");
		var this_height = $(this).data("height");

		if(this_width == undefined) {
			$(this).data("width", img_width); // 원래 이미지 사이즈
			$(this).data("height", img_height);
			this_width = img_width;
			this_height = img_height;
		}

		if(this_width > res_width) {
			$(this).width(res_width);
			var res_height = Math.round(res_width * $(this).data("height") / $(this).data("width"));
			$(this).height(res_height);
		} else {
			$(this).width(this_width);
			$(this).height(this_height);
		}
	});
}

function excute_good(href, $el, $tx)
{
	$.post(
		href,
		{ js: "on" },
		function(data) {
			if(data.error) {
				alert(data.error);
				return false;
			}

			if(data.count) {
				$el.find("strong").text(number_format(String(data.count)));
				if($tx.attr("id").search("nogood") > -1) {
					$tx.text("이 글을 비추천하셨습니다.");
				} else {
					$tx.text("이 글을 추천하셨습니다.");
				}
			}
		}, "json"
	);
}
</script>
<!-- } 게시글 읽기 끝 -->