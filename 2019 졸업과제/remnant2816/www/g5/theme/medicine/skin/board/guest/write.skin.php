<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<link rel="stylesheet" href="<?php echo $board_skin_url ?>/style.css">

<section id="bo_w">

	<!-- 게시물 작성/수정 시작 { -->
	<form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" style="width:<?php echo $width; ?>">
	<input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
	<input type="hidden" name="w" value="<?php echo $w ?>">
	<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
	<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
	<input type="hidden" name="sca" value="<?php echo $sca ?>">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="spt" value="<?php echo $spt ?>">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<?php
	$option = '';
	$option_hidden = '';
	if ($is_notice || $is_html || $is_secret || $is_mail) {
		$option = '';
		if ($is_secret) {
			if ($is_admin || $is_secret==1) {
				$option .= "\n".'<input type="checkbox" id="secret" name="secret" value="secret" '.$secret_checked.'>'."\n".'<label for="secret">비밀글</label>';
			} else {
				$option_hidden .= '<input type="hidden" name="secret" value="secret">';
			}
		}
	}

	echo $option_hidden;
	?>
        
    <div class="guestwrap">
    <div class="writewrap">
        <!-- <div>
            <?php if ($is_name) { ?>
            <label for="wr_name">NAME<strong class="sound_only">필수</strong></label><input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="input" style="width:100px;">
            <?php } ?>
            <?php if ($is_password) { ?>
            <label for="wr_password">PASS<strong class="sound_only">필수</strong></label><input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="input" style="width:100px;">
            <?php } ?>
            <?php if ($is_homepage) { ?>
            <label for="wr_homepage">HOME</label><input type="text" name="wr_homepage" value="<?php echo $homepage ?>" id="wr_homepage" class="input" style="width:150px;"></td>
            </tr>
            <?php } ?>
        </div> -->
        <div style="display:none;">
			<?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출  ?>
        </div>
        <div style="margin-top:10px;">
            <textarea name="wr_subject" id="wr_subject" required  style="width:100%; height:60px; border:solid 1px #EEEEEE;"><?php echo $subject ?></textarea>
        </div>
        <div style="margin-top:5px;">
            <label><input type="checkbox" name="secret" value="secret" <?if ($write['wr_option']=="secret") {echo "checked";}?>> 비밀글</label>

			<!-- 190508 여분필드 wr_1 에 타겟블로그 값 넣어 -->
            <label><input type="hidden" name="wr_1" value='<? echo $owner ?>'></label>
			<!-- 190508 여분필드 wr_1 에 타겟블로그 값 넣어 -->

            <div style="float:right;"><input type="submit" value="write" id="btn_submit" accesskey="s" style="background:#fff; border:0;"></div>
        </div>
    </div>
    </div>
        
        
        
        

	<div class="btn_confirm" style="display:none;">
		<input type="submit" value="글쓰기" id="btn_submit" accesskey="s" class="btn_submit">
		<a href="./board.php?bo_table=<?php echo $bo_table ?>" class="btn_cancel">취소</a>
	</div>
	</form>

	<script>
	<?php if($write_min || $write_max) { ?>
	// 글자수 제한
	var char_min = parseInt(<?php echo $write_min; ?>); // 최소
	var char_max = parseInt(<?php echo $write_max; ?>); // 최대
	check_byte("wr_content", "char_count");

	$(function() {
		$("#wr_content").on("keyup", function() {
			check_byte("wr_content", "char_count");
		});
	});

	<?php } ?>
	function html_auto_br(obj)
	{
		if (obj.checked) {
			result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
			if (result)
				obj.value = "html2";
			else
				obj.value = "html1";
		}
		else
			obj.value = "";
	}

	function fwrite_submit(f)
	{
		<?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

		var subject = "";
		var content = "";
		$.ajax({
			url: g5_bbs_url+"/ajax.filter.php",
			type: "POST",
			data: {
				"subject": f.wr_subject.value,
				"content": f.wr_content.value
			},
			dataType: "json",
			async: false,
			cache: false,
			success: function(data, textStatus) {
				subject = data.subject;
				content = data.content;
			}
		});

		if (subject) {
			alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
			f.wr_subject.focus();
			return false;
		}

		if (content) {
			alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
			if (typeof(ed_wr_content) != "undefined")
				ed_wr_content.returnFalse();
			else
				f.wr_content.focus();
			return false;
		}

		if (document.getElementById("char_count")) {
			if (char_min > 0 || char_max > 0) {
				var cnt = parseInt(check_byte("wr_content", "char_count"));
				if (char_min > 0 && char_min > cnt) {
					alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
					return false;
				}
				else if (char_max > 0 && char_max < cnt) {
					alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
					return false;
				}
			}
		}

		<?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

		document.getElementById("btn_submit").disabled = "disabled";

		return true;
	}
	</script>
</section>
<!-- } 게시물 작성/수정 끝 -->

<script>
	$(document).ready(function () {
		// 190508 페이지 파싱 >> 헤더, 푸터 없애기
		$("#hd").remove();
		$("#ft").remove();
		$("#wrapper > #cnt_title").html("");
		$("#cnt_title").remove();
		

		// 내용 칸에 쩜(.) 넣기
		$("#wr_content").text(".");
	});
</script>

<?php
$admin_href = "";
// 최고관리자 또는 그룹관리자라면
if ($member['mb_id'] && ($is_admin == 'super' || $group['gr_admin'] == $member['mb_id']))
	$admin_href = G5_ADMIN_URL.'/board_form.php?w=u&amp;bo_table='.$bo_table;

include_once(G5_BBS_PATH.'/list.php');
?>
