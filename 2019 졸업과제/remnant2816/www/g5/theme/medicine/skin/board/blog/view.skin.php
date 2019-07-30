<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<!-- 게시물 읽기 시작 { -->

<!-- 190517 로딩페이지 -->
<div id="loading"><img id="loading-image" src="http://remnant2816.cafe24.com/g5/theme/medicine/img/loading.gif" alt="Loading..." /></div>


<article id="bo_v" style="width:<?php echo $width; ?>">
    <header>
        <h2 id="bo_v_title">
            <?php if ($category_name) { ?>
            <span class="bo_v_cate"><?php echo $view['ca_name']; // 분류 출력 끝 ?></span> 
            <?php } ?>
            <span class="bo_v_tit">
            <?php
            echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력
            ?></span>
            <span id="bo_v_title_sub" style="font-weight: bold; font-size:20px; letter-spacing: 1px"></span>

    	</h2>
    </header>


        <?php 
			$mb = get_member($view['mb_id']); // 현재 글 ID 멤버 정보
		    $mb_id = $mb['mb_id'];
		    $mb_kakao = $mb['mb_10']; // mb_10에 카카오 플친 URL 저장

		if($mb_kakao != "") {  // 카카오 플친 링크가 있으면 아이콘 생성 
		?>
        		<div id="topmenu_kakaotalk" align="right">
                	<a href="<?php echo $mb_kakao ?>" target ="_blank" >
                    	<img src="http://remnant2816.cafe24.com/g5/theme/medicine/img/kakao.jpg" 
                    	alt="kakaotalk" width="50" height="50" />
                </a>
        		</div>
    	<?php } ?>


    <section id="bo_v_info">
    <div>
        <ul id="blog_menu">
            <li>Home</li>
            <li>Profile</li>

            <?php 
            // 현재 로그인된 회원정보 $logon
            $logon = get_member($member['mb_id']);
            $now_nick = $logon['mb_nick'];
            // 현재 게시글 글쓴이 정보
            $mb = get_member($view['mb_id']);
            $blog_nick = $mb['mb_nick'];

             ?>
            <li>Item</li> 
            <li>Request</li>
            <li>MyStorage</li>       
        
        <?php 
            if($now_nick == $blog_nick) {	// if 시작 
             ?>
            <li>Setting</li>
        <?php } // if 종료 ?>
        </ul>

    </div>
    </section>

    <section id="bo_v_atc">
        <h2 id="bo_v_atc_title">본문</h2>
        <!-- 본문 내용 시작 { -->

<style>

</style>

        <div id="blog_wrap">
<!--190507 blog 게시판과 blog_main 게시판의 wr_id를 똑같게해야됨 . -->
<div id="home_div" class="_blog_">
    <div class="center" style="min-height: 300px"> 



     <?php
    // 190510 블로그 & 썸네일 동기화 : wr_subject(BLOG TITLE)로 동기화.
    // TEST 실패.. >> 수정해야함 
    // $blog_title = cut_str(get_text($view['wr_subject']), 70);
    // echo $blog_title . "test";

    $sql = "select * from g5_write_blog_main WHERE wr_id =" . $wr_id . "";
    // $sql = "select * from g5_write_blog_main WHERE wr_subject =" . $blog_title . "";
    $result = sql_query($sql);
    $row = sql_fetch_array($result);
        
    preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $row['wr_content'], $img);
    echo "<a href=''>"
            ."<img width='500' src='"
                .$img[1][0] // blog_main 게시판의 각 게시글의 첫번째 img의 src를 불러옴
            ."'/>"
        ."</a>";


        // 190516 등록된 사진이 없을 때, 사진등록 링크div 생성
	    if( !(isset($img[1][0])) ){
	    	echo '<div style="position:fixed; right:50px;top:190px; background: #FFA700AA; width:100px;height:70px; border-radius:10px; padding:5px; text-align: center">
				<a href="http://remnant2816.cafe24.com/g5/bbs/write.php?bo_table=blog_main" id="btn_photo">	<i class="fas fa-images fa-3x"></i><br/><strong>메인사진등록</strong>
				</a>
			</div>';
	    }
    
    ?>
    </div>
    <div class="b_bottom">
        <div class="b_left">
            <span>블로그 소개</span>
        </div>
        <div class="b_right">
            <span>
            <?php 
                $sql = "select * from g5_write_blog WHERE wr_id =" . $wr_id . "";
                $result = sql_query($sql);
                $row = sql_fetch_array($result);

                echo $row['wr_content'];
            ?>
            </span>
        </div>
    </div>
</div>
<div id="profile_div" class="_blog_">
    <div> <h4>Profile</h4> </div>
    
    <?php 
        $mb = get_member($view['mb_id']);
        // echo "member 변수 가져오기 테스트 : ".$mb['mb_1'];
        // echo "medicine/skin/outlogin/main/outlogin.skin.2.php";
     ?>

    <div style="height:200px">
        <div class="b_left"><span>개인정보 / 사업자정보</span></div>
        <div class="b_right"><?php echo $mb['mb_2']; ?></div>
    </div>
    <div style="height:200px">
        <div class="b_left"><span>위치</span></div>
        <div class="b_right"><?php echo $mb['mb_3']; ?></div>
    </div>
    <div style="height:200px">
        <div class="b_left"><span>소개</span></div>
        <div class="b_right"><?php echo $mb['mb_4']; ?></div>
    </div>
</div>


<!-- 190501 item 리스트 ( div#item_div > table#item_list) -->
 <?php 
// 현재 로그인된 회원정보 $logon
$logon = get_member($member['mb_id']);
$now_nick = $logon['mb_nick'];
// 현재 게시글 글쓴이 정보
$blogger = get_member($view['mb_id']);
$blog_nick = $blogger['mb_nick'];

 ?>
<div id="item_div">
	
<table class="item_list">
<thead>
  <tr>
    <th>No</th>
    <th>Item ID</th>
    <th>Item 이름</th>
    
    <?php 
    	$col_num = $mb['mb_5'];
    	$col_name = $mb['mb_6'];
    	$cols = array();
    	$cols = explode(",", $col_name);

    	for($i=0; $i<$col_num; $i++){
    		echo "<th>".$cols[$i]."</th>";
    	}


     ?>

  </tr>
  <tr class="filter"> <!-- 190501 필터 -->
    <td><a id="btn_filter"><i class="fas fa-filter"></i></a></td>
    <?php 
    // 190515 사용자가 설정한 column갯수 만큼 필터 생성
		for($i=0; $i<$col_num+2; $i++){
    		echo "<td><div contenteditable='true' placeholder='*''></div></td>";
    	}
     ?>
  </tr>
  <label> 찾고자하는 값을 입력한 후, 왼쪽의 버튼<i class="fas fa-filter"></i>을 누르시면 Item이 검색됩니다. </label>
</thead>
<tbody id="item_data">
    <?php 
    //190510 블로그 개설 게시판에서, wr_id를 가져와
    // wr_id와 $row['wr_id']가 같으면 >> $owner 변수에 wr_subject(블로그이름) 넣어줌
    // TEST OK : 새로 회원가입하고 블로그 개설 테스트 성공.
    $sql = "SELECT wr_id, wr_subject FROM g5_write_blog";
    $result = sql_query($sql);
    for($i =0; $row = sql_fetch_array($result); $i++){
        if($wr_id == $row['wr_id']) // wr_id 가 
            $owner = $row['wr_subject'];
    }

        // BLOG 게시판에 게시글번호(wr_id)에 따라 각 BLOG의 item의 출력함.
        $sql = "select * from g5_item where i_owner = '$owner'";
        $result = sql_query($sql);

        for($i = 0; $row = sql_fetch_array($result); $i++){
            echo "<tr>";
            echo "<td>".($i+1)."</td>";
            echo "<td class='f_id'>".$row['i_id']."</td>";
            echo "<td class='f_name'>".$row['i_name']."</td>";
	           

	        // 190516 사용자가 설정한 column갯수($col_num)만큼 item table의 column 생성
			 if($col_num > 0){
		            echo "<td class='f_status'>".$row['i_status']."</td>";
		            if($col_num > 1) {
		            echo "<td class='f_target'>".$row['i_target']."</td>";
			            if($col_num > 2) {
			            echo "<td class='f_begin'>".$row['i_begin']."</td>";
			            	if($col_num > 3) {
				            echo "<td class='f_end'>".$row['i_end']."</td>";
					            if($col_num > 4) {
					            echo "<td class='f_etc1'>".$row['i_etc1']."</td>";
						            if($col_num > 5) {
						            echo "<td class='f_etc2'>".$row['i_etc2']."</td>";
							            if($col_num > 6) {
							            echo "<td class='f_etc3'>".$row['i_etc3']."</td>";
							        }
							    }
							}
						}
					}
				}
	        }
            echo "</tr>";
        }

    ?>
</tbody>



<?php 

// 현재 로그인된 회원과 블로거의 닉네임이 같다면 Item, MyStorage, Setting 메뉴 추가 
if($now_nick == $blog_nick) {   // ITEM_DIV : if 시작 
?>

<tfoot>
    <form action="http://remnant2816.cafe24.com/g5/theme/medicine/db_controller.php" method="post" name="form" onsubmit="return check()">
        <input type="hidden" name="i_owner" value="<?php echo $owner?>" />
        <input type="hidden" name="wr_id" value="<?php echo $wr_id?>" />
    <tr>
        <td><button id="btn_insert" type="submit" name="submit" /><i class="fas fa-sign-in-alt"></i></td>  
        <td>Item 추가</td>
        <td><input type="text" name="i_name" value=""/></td> 
        <?php 
        	if($col_num > 0) {
        		echo '<td><input type="text" name="i_status" value=""/></td>';
        		if($col_num > 1) {
        			echo '<td><input type="text" name="i_target" value=""/></td>';
        			if($col_num > 2) {
        				echo '<td><input type="text" name="i_begin" value=""/></td>';
        				if($col_num > 3) {
        					echo '<td><input type="text" name="i_end" value=""/></td>';
        					if($col_num > 4) {
        						echo '<td><input type="text" name="i_etc1" value=""/></td>';
        						if($col_num > 5) {
        							echo '<td><input type="text" name="i_etc2" value=""/></td>';
        							if($col_num > 6) {
        								echo '<td><input type="text" name="i_etc3" value=""/></td>';
        							}
        						}
        					}
        				}
        			}
        		}
        	}
         ?>

            <script type="text/javascript"> // 폼 검증 스크립트
            function check(){
                var frm = document.form;
                }
            </script>
    </tr>
    <!-- 190510 db_controller.php 작업이 완료되지 않아서, 일단 UPDATE 기능은 보류... -->
<!--
    <tr>
        <label> 수정할 Item의 ID을 입력하고, 수정할 내용을 입력한 후에 버튼<i class="fas fa-edit"></i>을 누르시면 Item 내용이 수정됩니다. </label>
        <td><button type="submit" name="submit" /><i class="fas fa-edit"></i></td>
        <td><input type="text" name="update_id" value="" placeholder="ID for EDIT" /></td>
        <td><input type="text" name="i_name" value=""/></td> 
        <td><input type="text" name="i_status" value=""/></td>
        <td><input type="text" name="i_target" value=""/></td>
        <td><input type="text" name="i_begin" value=""/></td>
        <td><input type="text" name="i_end" value=""/></td>
        <td><input type="text" name="i_etc1" value=""/></td>
        <td><input type="text" name="i_etc2" value=""/></td>
        <td><input type="text" name="i_etc3" value=""/></td>
    </tr>
-->
    <tr>
        <td><button id="btn_delete" type="submit" name="submit" /><i class="fas fa-trash-alt"></i></td>
        <td>Item 삭제</td>
        <td><input type="text" name="delete_id" value="" placeholder="삭제할 Item의 ID" /></td>
        <td colspan="7"></td>
    </tr>
</tfoot>
<?php } // ITEM_DIV if 종료 
?>

</table>
	<!-- 190512 DB 설정 -->
	<div style="position:fixed; right:80px;top:210px; background: #21bbb1; width:70px;height:50px; border-radius:10px; padding:5px; text-align: center">
		<a id="btn_dbsetting"><i class="fas fa-database fa-2x"></i>&nbsp;<i class="fas fa-cogs fa-2x"></i><br/><strong>DB설정</strong></a>
	</div>
</div>





<div id="request_div" class="_blog_">
    <!-- 190508 방명록 : guest 게시판 글 긁어오기 -->
    <div>
<?php 
    function parsing_data($url, $data) {
    $agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36';
    $curlsession = curl_init ();
    curl_setopt ($curlsession, CURLOPT_URL, $url); // 파싱 주소 url
    //curl_setopt ($curlsession, CURLOPT_SSL_VERIFYPEER, FALSE); // 인증서 체크같은데 true 시 안되는 경우가 많다.
    //curl_setopt ($curlsession, CURLOPT_SSLVERSION,3); // SSL 버젼 (https 접속시에 필요)
    curl_setopt ($curlsession, CURLOPT_HEADER, 0);
    curl_setopt ($curlsession, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($curlsession, CURLOPT_POST, 0); // POST = 1, GET = 0
    curl_setopt ($curlsession, CURLOPT_POSTFIELDS, "".$data.""); // POST 일경우 data 값을 받아 넣을수있음
    curl_setopt ($curlsession, CURLOPT_USERAGENT, $agent);
    curl_setopt ($curlsession, CURLOPT_REFERER, "http://windowshyun.tistory.com"); // 일부 사이트의 경우 referer 을 확인할 수 있다.
    curl_setopt ($curlsession, CURLOPT_TIMEOUT, 120); // 해당 웹사이트가 오래걸릴수 있으므로 2분동안 타임아웃 대기
    $buffer = curl_exec ($curlsession);
    $cinfo = curl_getinfo($curlsession);
    curl_close($curlsession);
 
    if ($cinfo['http_code'] != 200){
        return $cinfo['http_code'];
    }
 
    return $buffer;
}

$content = parsing_data("http://remnant2816.cafe24.com/g5/bbs/write.php?bo_table=guest&page=1&owner=".$owner, "");
echo $content;

?>
    </div>
</div>



<!-- 유효데이터 관리 -->
<div id="mylink" class="_blog_">




	<div style="width:30%; height: 100%; float:left">
		유효 데이터 트리
		<div id="data_wrapper">
			<ul>
	            <li>유효데이터 예시</li>
	            <li>공유경제에 대해서
	                <ul>
	                    <li>공유경제란</li>
	                    <li>공유경제의 목표</li>
	                    <li>공유경제의 가치</li>
	                    <li>테스트1</li>
	                    <li>테스트2</li>
	                </ul>
	           </li>
	           <li>SharingEconomy 플랫폼
	                <ul>
	                    <li>개인정보 관리 약관</li>
	                    <li>블로그 사용방법
	                        <ul>
	                            <li>Item 공유하기</li>
	                            <li>나만의 데이터 창고</li>
                                <li>카톡 플러스친구 연동</li>
	                        </ul>
	                    </li>
	                </ul>
	            </li>
	        </ul>
            
            <?php 
                $mb_nick = $mb['mb_nick'];
                // 190516 멤버 닉네임이 d_owner인 유효 데이터를 가져와
                $sql = "SELECT * FROM g5_valid_data WHERE d_owner = '$mb_nick'";
                $result = sql_query($sql);
                $data = array();

                for($i = 0; $row = sql_fetch_array($result); $i++){
                    $data[$i] = $row;
                    // $data 배열에 DB 정보 저장
                    // echo $data[$i]['d_subject'];
                }

                function has_children($rows,$id) {
                    foreach ($rows as $row) {
                        if ($row['d_pid'] == $id)
                            return true;
                    }
                    return false;
                }
                function build_menu($rows,$parent=0)
                {  
                  $print = "<ul>";
                  foreach ($rows as $row)
                  {
                    if ($row['d_pid'] == $parent){
                        // d_category가 folder이면 클래스 추가
                        if($row['d_category'] == "folder"){
                            $print.= "<li class='valid_folder'>{$row['d_subject']}";
                            $print.= "<div class='div_con'>{$row['d_content']}</div>";
                        }
                        else {
                            $print.= "<li>{$row['d_subject']}";
                            $print.= "<div class='div_con'>{$row['d_content']}</div>";
                        }
                      if (has_children($rows,$row['d_id']))
                        $print.= build_menu($rows,$row['d_id']);
                      $print.= "</li>";
                    }
                  }
                  $print.= "</ul>";

                  return $print;
                }
                echo build_menu($data); 
            ?>


	    </div>
	</div>

	<div style="width:70%; height: 100%; float:left">
		<div style="height:100%">
<!-- 19.5.23 iframe : 블로거의 valid data 만 나오도록 필터링 -->
<style type="text/css">#my-iframe {display:block;border:none;height:100%;width:100%;overflow-x:none;}</style>

<iframe id="my-iframe" src="http://remnant2816.cafe24.com/g5/bbs/board.php?bo_table=valid&sca=&sop=and&sfl=wr_name%2C1&stx=<?php echo $mb_nick?>" scrolling="" frameborder="none"></iframe>
		</div>
	</div>




<?php 
if($now_nick == $blog_nick) {   // 유효데이터 추가: if 시작 
 ?>
    <!-- 19.5.15 유효 데이터 추가 form -->
    <div>
    <table class="item_list" id="valid_table">
<tfoot>
    <form action="http://remnant2816.cafe24.com/g5/theme/medicine/valid_controller.php" method="post" name="form" onsubmit="return check()">
        <input type="hidden" name="d_owner" value="<?php echo $mb_nick?>" />
    <tr>
        <td>ADD</td>
        <td>Folder / Data</td>
        <td>상위 노드</td>
        <td>Name</td>
        <td>Content</td>
        <td>URL</td>
    </tr>
    <tr>
        <td><button type="submit" name="submit" /><i class="fas fa-sign-in-alt"></i></td>  
        <td>
            <input type="radio" name="d_type" value="folder">Folder
            <input type="radio" name="d_type" value="data">Data
        </td>
        <td><input type="text" name="d_category" value="" placeholder="상위 노드 이름을 입력하세요" /></td> 
        <td><input type="text" name="d_subject" value=""/></td>
        <td><input type="text" name="d_content" value=""/></td>
        <td><input type="text" name="d_url" value=""/></td>
    </form>
            <script type="text/javascript"> // 폼 검증 스크립트
            function check(){
                var frm = document.form;
                }
            </script>
    </tr>
<!--     <tr>
        <td><button id="btn_delete" type="submit" name="submit" /><i class="fas fa-trash-alt"></i></td>
        <td>Item 삭제</td>
        <td><input type="text" name="delete_id" value="" placeholder="삭제할 Item의 ID" /></td>
        <td colspan="7"></td>
    </tr> -->
</tfoot>
    </table>
    </div>

<?php 
    } // 유효데이터 추가 if 종료 : 블로그 onwer만 수정하도록
 ?>

</div>



<?php 
if($now_nick == $blog_nick) {   // SETTING_DIV : if 시작 
 ?>
<!-- 블로그 세팅 : css, sns -->
<div id="setting_div" class="_blog_">

    <?php 
     $mb = get_member($view['mb_id']); // 현재 로그인된 ID 멤버 정보
     $mb_id = $mb['mb_id'];
     $mb_kakao = $mb['mb_10']; // mb_10에 카카오 플친 URL 저장

    ?>
    <!-- 190520 카카오톡 플러스친구 아이콘은 메인화면에 생기도록 수정 -->
    
    <div div style="width:50%; height: 100%; float:left">
        <div>
            <a href="https://accounts.kakao.com/login/kakaoforbusiness?continue=https://center-pf.kakao.com/" target ="_blank" class="btn_b04 btn"> 카카오톡 플러스친구 생성하러가기 </a>
        </div>

        <div>
            <form action="http://remnant2816.cafe24.com/g5/theme/medicine/kakao.php" method="post" name="form" onsubmit="return check()">
                <input type="hidden" name="mb_id" value="<?php echo $mb_id ?>"/>
                <input type="text" name="mb_10" placeholder ="플러스친구 url 입력 " value="<?php echo $mb_kakao ?>" style="width:250px;height:45px;font-size:15px;"/>
                <input type="submit" value="URL 저장" id="btn_submit" accesskey="s" class="btn_submit btn"/>
            </form>
        </div>

        <div>
            <p><br/><br/>"플러스친구 > 관리자 센터 > 홍보하기" 메뉴에서 홈URL 링크를 복사에서 입력해주세요.</p>
        </div>
    </div>
    <div style="width:50%; height: 100%; float:left">
        CSS Customizing
    </div>
</div>






<!-- 190512 DB 세팅 div  -->
<div id="db_div" class="_blog_">
    DB SETTINGS
    <form action="http://remnant2816.cafe24.com/g5/theme/medicine/db_setting.php" method="post" name="form" onsubmit="return check()">
    
	<?php 
	 $mb = get_member($view['mb_id']); // 현재 로그인된 ID 멤버 정보
	 $column_num = $mb['mb_5'];
	 $column_name = $mb['mb_6'];
	 $mb_id = $mb['mb_id'];
	 ?>
		<input type="hidden" name="mb_id" value="<?php echo $mb_id?>" />


     <div id="db_table_wrapper">
        <table class="item_list" style="width:70%">
            <tr style="width:100%">
                <th style="width:20%">추가할 열(Column) 갯수</th>
                <th style="width:70%">열(Column) 이름 설정</th>
                <th style="width:10%" rowspan="3"><div id="db_save" style="height:100%; padding:35px 0 35px 0"><button style="background: transparent; border: none;" type="submit" name="submit" /> 설정 저장<br/> <i class="far fa-save fa-3x"></i></div></th>
            </tr>
            <tr style="width:100%">
                <td style="background:#66DDD0; width:20%">기본 Column(ID, Name)을 제외하고, 7개까지 추가할 수 있습니다.</td>
                <td style="background:#66DDD0;width:70%">콤마 , 를 사용하여, 각 Column값을 구분하여 설정해주세요.</td>
            </tr>
            <tr>
                <td style="display: none;"></td>
                <td style="width:20%"><input type="number" name="column_num" value="<?php echo $column_num ?>" min="0" max="7"/></td>
                <td style="width:70%"><input type="text" name="column_name" value="<?php echo $column_name ?>" placeholder="Item종류,Item연식,Item칼라,..." /></td>
            </tr>
        </table>
    </div>  
	</form>
</div>


<?php } // MYSTORAGE_DIV, SETTING_DIV  if문 끝 
?>




        </div>
        </div>

        <!-- } 본문 내용 끝 -->
    </section>

</article>
<!-- } 게시판 읽기 끝 -->
<!-- 게시글 보기 끝 -->


<script>
// 190516 로딩페이지
$(window).load(function() {    
	setTimeout(function(){
		$('#loading').hide();  
	},1500);
});



// 190507 미니홈피 새창에서 header, footer 제거
$(document).ready(function(){
    $("#hd").remove();
    $("#ft").remove();
    $("cnt_title").remove();


    // 190516 유효데이터 스크립트
	 //[1] 리스트의 기본 모양 지정 : <ul>를 자식으로 가지지 않는 li의 블릿기호는 파일이미지
    $('#data_wrapper li:not(:has(ul))').css({ cursor: 'default', 'list-style-image':'url(http://remnant2816.cafe24.com/g5/theme/medicine/img/file.png)'});
   
    //[2] 자식 요소를 갖는 li에 대해서는 블릿이미지를 닫힌폴더 이미지로 지정
    $('#data_wrapper li:has(ul)') //자식 요소(ul)를 갖는 요소(li)에 대해서
        .css({cursor: 'pointer', 'list-style-image':'url(http://remnant2816.cafe24.com/g5/theme/medicine/img/close.png)'})
        .children().hide(); //자식요소 숨기기
       
    //[3] +로 설정된 항목에 대해서 click이벤트 적용
    $('#data_wrapper li:has(ul)').click(function(event){
        if(this == event.target){
            //숨겨진 상태면 보이고 "열림"으로 설정, 그렇지 않으면 숨기고 "닫힘"으로 설정
              if ($(this).children().is(':hidden')) {
                // 보이기
                console.log("Open Directory");
                $(this).css('list-style-image', 'url(http://remnant2816.cafe24.com/g5/theme/medicine/img/open.png)').children().slideDown();
               $('#data_wrapper li:not(:has(ul))').css({ cursor: 'default', 'list-style-image':'url(http://remnant2816.cafe24.com/g5/theme/medicine/img/file.png)'});
            }
            else {
                // 숨기기
                console.log("Close Directory");
                $(this).css('list-style-image', 'url(http://remnant2816.cafe24.com/g5/theme/medicine/img/close.png)').children().slideUp();
            }
        }
        return false;          
    });





    // 190507 미니홈피 Tap 메뉴 클릭시 
    $("#blog_wrap > div").css("display", "none"); // 일단 다 안보이게
    $("#home_div").css("display", "block");
    $("#bo_v_title_sub").html("Home");
    $("#blog_menu li:nth-child(1)").click(function(){
        $("#blog_wrap > div").css("display", "none"); // 일단 다 안보이게
        $("#blog_wrap > div:nth-child(1)").css("display","block");
        $("#bo_v_title_sub").html("Home");
    });
    $("#blog_menu li:nth-child(2)").click(function(){
        $("#blog_wrap > div").css("display", "none"); // 일단 다 안보이게
        $("#blog_wrap > div:nth-child(2)").css("display","block");
        $("#bo_v_title_sub").html("Profile");
    });
    $("#blog_menu li:nth-child(3)").click(function(){
        $("#blog_wrap > div").css("display", "none"); // 일단 다 안보이게
        $("#blog_wrap > div:nth-child(3)").css("display","block");
        $("#bo_v_title_sub").html("Item"); 
    });
    $("#blog_menu li:nth-child(4)").click(function(){
        $("#blog_wrap > div").css("display", "none"); // 일단 다 안보이게
        $("#blog_wrap > div:nth-child(4)").css("display","block");
        $("#bo_v_title_sub").html("Request");
    });
    $("#blog_menu li:nth-child(5)").click(function(){
        $("#blog_wrap > div").css("display", "none"); // 일단 다 안보이게
        $("#blog_wrap > div:nth-child(5)").css("display","block");
        $("#bo_v_title_sub").html("MyStorage");
    });
	$("#blog_menu li:nth-child(6)").click(function(){
        $("#blog_wrap > div").css("display", "none"); // 일단 다 안보이게
        $("#blog_wrap > div:nth-child(6)").css("display","block");
        $("#bo_v_title_sub").html("Setting");
    });
    // 190512 DB설정 버튼추가
    $("#btn_dbsetting").click(function(){
    	$("#blog_wrap > div").css("display", "none"); // 일단 다 안보이게
        $("#blog_wrap > div:nth-child(7)").css("display","block");
        $("#bo_v_title_sub").html("DB 설정");
    });


    // 190517 유효데이터의 file을 클릭시, 해당 d_content를 담은 div가 보이게 (display:block)

    $('#data_wrapper li:not(:has(ul))').on("click",function(){
    	$('#data_wrapper li:not(:has(ul)) > div').css("display","none");
    	$(this).children().css("display","block");
    });
  
});






// 190502 필터 jquery 
var cnt = 15; // (수정요) 나중에 DB 에서 row의 갯수를 가져와야해 
var i=0;
var itemArray = new Array(); // ITEM 리스트를 담을 배열

function makeObject(){

    for(var i=0; i<cnt; i++){
        var item = new Object();
        var tdArr = new Array();
        var id = "#item_data tr:nth-child(" + (i+1) +")";
        //console.log("id : " + id);
        var tr = $(id);
        var td = tr.children();

        item.id = td.eq(1).text();
        item.name = td.eq(2).text();
        console.log("name : " + item.name);
        item.status = td.eq(3).text();
        item.target = td.eq(4).text();
        item.begin = td.eq(5).text();
        item.end = td.eq(6).text();
        item.etc1 = td.eq(7).text();
        item.etc2 = td.eq(8).text();
        item.etc3 = td.eq(9).text();

        itemArray[i] = item;
    }
    console.log(itemArray);
}

function initList(){
    $("#item_data tr").css("display","table-row");
}


// 190502 20:00 필터버튼 클릭시 
$("#btn_filter").on("click", function(){

    makeObject();
    initList();

    // 필터 입력값 넣기
    var id =  $(".filter td:nth-child(2)").text();
    var name = $(".filter td:nth-child(3)").text();
    var status = $(".filter td:nth-child(4)").text();
    var target = $(".filter td:nth-child(5)").text();
    var begin =  $(".filter td:nth-child(6)").text();
    var end = $(".filter td:nth-child(7)").text();
    var etc1 =  $(".filter td:nth-child(8)").text();
    var etc2 =  $(".filter td:nth-child(9)").text();
    var etc3 =  $(".filter td:nth-child(10)").text();

    var tmpArray = itemArray; // 필터링을 위한 임시 배열에 기존배열 삽입
    var show_count = 0;
    
    console.log("Filter ID : " + id);
    console.log("Filter Name : " + name);
    console.log("Filter Status : " + status);
    console.log("Filter Target : " + target);
    console.log("Filter Begin : " + begin);
    console.log("Filter End : " + end);
    console.log("Filter ETC1 : " + etc1);
    console.log("Filter ETC2 : " + etc2);
    console.log("Filter ETC3 : " + etc3);

    // 0. Item ID 필터
    for(var i=0;i<cnt;i++){
        if(id != "" && id != tmpArray[i].id) //필터값과 배열값이 다르면 css 안보이게
        {
            var id = "#item_data tr:nth-child(" + (i+1) +")";
            $(id).css("display","none");
        }
    }
    // 1. Item Name 필터
    for(var i=0;i<cnt;i++){
        if(name != "" && !(tmpArray[i].name.includes(name))) 
        {
            var id = "#item_data tr:nth-child(" + (i+1) +")";
            $(id).css("display","none");
        }
    }
    // 2. Status 필터
    for(var i=0;i<cnt;i++){
        if(status != "" && !(tmpArray[i].status.includes(status)))
        {
            var id = "#item_data tr:nth-child(" + (i+1) +")";
            $(id).css("display","none");
        }
    }
    // 3. Target 필터
    for(var i=0;i<cnt;i++){
        if(target != "" && !(tmpArray[i].target.includes(target))) 
        {
            var id = "#item_data tr:nth-child(" + (i+1) +")";
            $(id).css("display","none");
        }
    }
    // 4. Begin 필터
    for(var i=0;i<cnt;i++){
        if(begin != "" && !(tmpArray[i].begin.includes(begin))) 
        {
            var id = "#item_data tr:nth-child(" + (i+1) +")";
            $(id).css("display","none");
        }
    }
    // 5. finish 필터
    for(var i=0;i<cnt;i++){
        if(end != "" && !(tmpArray[i].end.includes(end)))
        {
            var id = "#item_data tr:nth-child(" + (i+1) +")";
            $(id).css("display","none");
        }
    }
    // 6. etc1 필터
    for(var i=0;i<cnt;i++){
        if(etc1 != "" && !(tmpArray[i].etc1.includes(etc1)))
        {
            var id = "#item_data tr:nth-child(" + (i+1) +")";
            $(id).css("display","none");
        }
    }
    // 7. etc2 필터
    for(var i=0;i<cnt;i++){
        if(etc2 != "" && !(tmpArray[i].etc2.includes(etc2)))
        {
            var id = "#item_data tr:nth-child(" + (i+1) +")";
            $(id).css("display","none");
        }
    }
    // 8. etc3 필터
    for(var i=0;i<cnt;i++){
        if(etc3 != "" && !(tmpArray[i].etc3.includes(etc3)))
        {
            var id = "#item_data tr:nth-child(" + (i+1) +")";
            $(id).css("display","none");
        }
    }
    // 테이블 first column "NO"의 번호 재정렬
    /*
    $("#item_data tr").each(function (index, item) {
        if( $(item).css("display") == "table-row" ) {
            console.log("SHOW!");
            show_count++;
            $(item + " td").eq(1).html(index);
        }
    });*/

});



$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });
    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});
</script>
<!-- } 게시글 읽기 끝 -->