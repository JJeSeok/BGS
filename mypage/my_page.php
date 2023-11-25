<?php
include "../lib/dbconn.php";
session_start();
  if( !(isset( $_SESSION[ 'userid' ] )) ) {
    echo "
            <script>
                alert('로그인후 사용해주세요');
                history.back();
            </script>
                ";
            exit;
  }

  include "../lib/dbconn.php";

 $userid="";
 $username="";
 $userlevel=""; //회원등급 : 1~9등급 [1등급:관리자, 9등급:신규회원]
 $userpoint="";
    
 if( isset($_SESSION['userid'])) $userid= $_SESSION['userid'];
 if( isset($_SESSION['username'])) $username= $_SESSION['username'];
 if( isset($_SESSION['userlevel'])) $userlevel= $_SESSION['userlevel'];
 if( isset($_SESSION['email'])) $useremail= $_SESSION['email'];
 if( isset($_SESSION['phnum'])) $userphnum= $_SESSION['phnum'];

$birth = $_SESSION['birth'];
$year = substr($birth, 0, 4);
$month = substr($birth, 4, 2);
$day = substr($birth, 6, 2);

$sql="SELECT COUNT(*) AS count FROM like_review WHERE like_id = '$userid'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$count = $row['count'];
$sql2="SELECT COUNT(*) AS count FROM hate_review WHERE userid = '$userid'";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();
$sql3="SELECT COUNT(*) AS count FROM like_board WHERE id = '$userid'";
$result3 = $conn->query($sql3);
$row3 = $result3->fetch_assoc();
$sql5= "SELECT * FROM review where userid = '$userid'";
$result5= $conn->query($sql5);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BGS</title>
  <link rel="icon" href="../assets/paypal.svg">
  <link href="../css/styles.css" rel="stylesheet">
  <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/my_page.css" rel="stylesheet">
</head>
<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container px-4 px-lg-5">
        <a class="navbar-brand fw-bolder" href="../index.php">BGS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="../index.php">홈</a></li>
                <li class="nav-item"><a class="nav-link active" href="../like.php">좋아요</a></li>
                <li class="nav-item"><a class="nav-link active" href="../mypage/my_page.php">마이페이지</a></li>
            </ul>
            <ul class="navbar-nav">
                     <!-- 로그인 안되었을 때 -->
                        <?php if(!$userid){  ?>
                            <a style="font-size: 17px" class="navbar-brand" href="../member/member_form.php">회원가입</a></li>
                            <a style="font-size: 17px" class="navbar-brand" href="../login/login_form2.php">로그인</a></li>
                        <?php }else{ ?>
                            <a style="font-size: 17px" class="navbar-brand" href="../login/logout.php">로그아웃</a></li>
                        <?php }?>

                        <!-- 관리자모드로 로그인되었을 때 추가로.. -->
                        <?php if($userlevel==1){?>
                            <a style="font-size: 17px" class="navbar-brand" href="../admin/admin_form.php">관리자모드</a></li>
                        <?php } ?>
            </ul>
        </div>
      </div>
    </nav>
  </header>
  <div id="container">
    <div id="myInfo">
      <div id="inner">
        <div class="profile">
          <div class="profile_name">
          <?php if($userlevel==9){?>
            <div class="honor_level_bronze"></div>
          <?php }
          else if($userlevel==8){?>
            <div class="honor_level_silver"></div>
          <?php }
          else if($userlevel==7){?>
            <div class="honor_level_gold"></div>
          <?php }
          else {?>
            <div class="honor_level_platinum"></div>
          <?php }
          ?>  
            <div class="user_name">
              <strong class="user_nameStyle"><?=$username?></strong>
            </div>
            <div class="user_photo">
              <img class="user_photoStyle" src="../review/image/그림01.jpg" alt="userphoto">
            </div>
          </div>
          <div class="profile_center_wrap"></div>
          <div class="profile_action_button_wrap">
            <button class="profile_action_button">전체등급 보기</button>
            <button class="profile_action_button">개인 정보 수정</button></a>
          </div>
        </div>
        <div class="side_wrap">
          <div class="inside_wrap">
            <button class="inside_action_button1">
              <div class="inside_button_div1">
                좋아요<span class="compact_right only_desktop"></span>
              </div>
              <div class="inside_button_div2">
                <?=$count?><span class="inside_button_div_font">개</span>
              </div>
              <span class="compact_right only_mobile"></span>
            </button>
          </div>
          <div class="inside_wrap">
            <button class="inside_action_button1">
              <div class="inside_button_div1">
                싫어요<span class="compact_right only_desktop"></span>
              </div>
              <div class="inside_button_div2">
                <?=$row2['count']?><span class="inside_button_div_font">개</span>
              </div>
              <span class="compact_right only_mobile"></span>
            </button>
          </div>
          <div class="inside_wrap">
            <button class="inside_action_button1">
              <div class="inside_button_div1">
                찜목록<span class="compact_right only_desktop"></span>
              </div>
              <div class="inside_button_div2">
                <?=$row3['count']?><span class="inside_button_div_font">개</span>
              </div>
              <span class="compact_right only_mobile"></span>
            </button>
          </div>
        </div>
        <div class="side_wrap">
          <div class="inside_wrap">
            <button class="inside_action_button2">
              <div class="inside_button_div1">
                방문식당<span class="compact_right only_desktop"></span>
              </div>
              <div class="inside_button_div3">알아보기</div>
              <span class="compact_right only_mobile"></span>
            </button>
          </div>
          <div class="inside_wrap">
            <button class="inside_action_button2">
              <div class="inside_button_div1">
                블라인드한 목록<span class="compact_right only_desktop"></span>
              </div>
              <div class="inside_button_div3">알아보기</div>
              <span class="compact_right only_mobile"></span>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div id="content">
      <div id="lside_wrap">
        <div class="mypage_ep only_desktop">마이배고파</div>
        <ul class="side_list">
          <li class="side_listItem">
            <a class="side_listName">
              맛집리뷰<span class="compact_right only_desktop"></span>
            </a>
          </li>
          <li class="side_listItem">
            <a class="side_listName">
              찜목록<span class="compact_right only_desktop"></span>
            </a>
          </li>
          <li class="side_listItem">
            <a class="side_listName">
              방문식당<span class="compact_right only_desktop"></span>
            </a>
          </li class="side_listItem">
          <li>
            <a class="side_listName">
              블라인드 목록<span class="compact_right only_desktop"></span>
            </a>
          </li>
        </ul>
      </div>
      <div class="rside_wrap">
        <div class="list_header">
          <div class="listName_wrap">
            <h2 class="list_name">맛집 리뷰</he>
          </div>
        </div>
        <div class="list_center_wrap only_desktop">
        </div>
        <ul id="review_content" class="restaurant_reviewList_content">
          <?php
          while($row5 = $result5->fetch_assoc()){
            $renum=$row5['num'];
            $sql8= "SELECT * FROM like_review where renum='$renum'&& userid='$userid'";
            $result8= $conn->query($sql8);
            $row8 = $result8 -> fetch_assoc();
            $sql9= "SELECT * FROM hate_review where renum='$renum'&& userid='$userid'";
            $result9= $conn->query($sql9);
            $row9 = $result9 -> fetch_assoc();
            $sql11 = "SELECT COUNT(*) AS likecount FROM like_review WHERE renum='$renum'";
            $result11 = mysqli_query($conn, $sql11);
            $row11 = $result11 -> fetch_assoc();
            $sql12 = "SELECT COUNT(*) AS hatecount FROM hate_review WHERE renum='$renum'";
            $result12 = mysqli_query($conn, $sql12);
            $row12 = $result12 -> fetch_assoc();
            $rating=$row5['star_rate'];
          ?>
          <li class="restaurant_reviewList_reviewItem">
            <a class="restaurant_reviewItem_link">
              <div class="restaurant_reviewItem_user">
                <div class="restaurant_reviewItem_userPicturewrap">
                  <img class="restaurant_reviewItem_userPicture" src="../review/image/그림01.jpg" alt="user profile picture">
                </div>
                <span class="restaurant_reviewItem_userNickname"><?=$row5['name']?></span>
                <ul class="restaurant_reviewItem_userStat">
                  <li class="restaurant_reviewItem_userStatItem userStatItem_like"><?=$row11['likecount']?></li>
                  <li class="restaurant_reviewItem_userStatItem userStatItem_hate"><?=$row12['hatecount']?></li>
                </ul>
              </div>
              <div class="restaurant_reviewItem_content">
                <div class="restaurant_reviewItem_textWrap">
                  <p class="restaurant_reviewItem_text"><?=$row5['story']?></p>
                  <span class="restaurant_reviewItem_Date"><?=$row5['redate']?></span>
                </div>
                <ul class="restaurant_reviewItem_PictureList">
                <?php
                      $renum=$row5['num'];
                      $sql6= "SELECT * FROM image where renum=$renum";
                      $result6= $conn->query($sql6);
                      while($row6=$result6->fetch_assoc()){
                      ?>
                      <li class="restaurant_reviewItem_PictureItem">
                        <button class="restaurant_reviewItem_PictureButton">
                          <img class="restaurant_reviewItem_Picture" src="../review/image/<?=$row6['db_filename']?>">
                        </button>
                      </li>
                      <?php
                      }
                      ?>
                </ul>
              </div>
              <?php
                  if($rating >= 4 && $rating <= 5){
                    ?>  
                    <div class="restaurant_reviewItem_Rating Rating_Recommend">
                    <span class="restaurant_reviewItem_RatingText">맛있다</span>
                    <div class="restaurant_reviewItem_managementWrap">
                      <button class="restaurant_reviewItem_management" type="button">
                      <span class="managementButton"></span>
                      </button>
                      <div class="managementWrap" style="display: none;">
                    <div class="managementList">
                      <div class="modify">
                        <button class="modifyButton" type="button" onclick="window.location.href='../review/review_modify.php?id=<?=$row5['num']?>'">
                          수정하기
                        </button>
                      </div>
                      <span class="modifyIcon"></span>
                    </div>
                    <button
                      class="managementList deleteButton"
                      type="button"
                      onclick="window.location.href='../review/delete.php?numb=<?=$row5['num']?>'"
                    >
                      삭제하기
                      <span class="deleteIcon"></span>
                    </button>
                  </div>
                    </div>
                  </div>
                  <?php
                  }
                  else if($rating > 2 && $rating < 4){
                    ?>
                    <div class="restaurant_reviewItem_Rating Rating_Recommend2">
                    <span class="restaurant_reviewItem_RatingText">괜찮다</span>
                    <div class="restaurant_reviewItem_managementWrap">
                      <button class="restaurant_reviewItem_management" type="button">
                      <span class="managementButton"></span>
                      </button>
                      <div class="managementWrap" style="display: none;">
                    <div class="managementList">
                      <div class="modify">
                        <button class="modifyButton" type="button" onclick="window.location.href='../review/review_modify.php?id=<?=$row5['num']?>'">
                          수정하기
                        </button>
                      </div>
                      <span class="modifyIcon"></span>
                    </div>
                    <button
                      class="managementList deleteButton"
                      type="button"
                      onclick="window.location.href='../review/delete.php?numb=<?=$row5['num']?>'"
                    >
                      삭제하기
                      <span class="deleteIcon"></span>
                    </button>
                  </div>
                    </div> 
                  </div>
                    <?php
                  }
                  else{
                    ?>
                    <div class="restaurant_reviewItem_Rating Rating_Recommend3">
                    <span class="restaurant_reviewItem_RatingText">별로</span>
                    <div class="restaurant_reviewItem_managementWrap">
                      <button class="restaurant_reviewItem_management" type="button">
                      <span class="managementButton"></span>
                      </button>
                      <div class="managementWrap" style="display: none;">
                    <div class="managementList">
                      <div class="modify">
                        <button class="modifyButton" type="button" onclick="window.location.href='../review/review_modify.php?id=<?=$row5['num']?>'">
                          수정하기
                        </button>
                      </div>
                      <span class="modifyIcon"></span>
                    </div>
                    <button
                      class="managementList deleteButton"
                      type="button"
                      onclick="window.location.href='../review/delete.php?numb=<?=$row5['num']?>'"
                    >
                      삭제하기
                      <span class="deleteIcon"></span>
                    </button>
                  </div>
                    </div>
                  </div>
                    <?php
                  }
                  ?>
            </a>
          </li>
          <?php
          }
          ?>
        </ul>
      </div>
      <div class="rside_wrap">
        <div class="list_header">
          <div class="listName_wrap">
            <h2 class="list_name">찜 목록</he>
          </div>
        </div>
        <div class="likeList_content">
          <?php
          $sq1= "SELECT COUNT(*) as total_rows FROM like_board where id='$userid' ";
          $res1= mysqli_query($conn,$sq1);
          $ro1=$res1->fetch_assoc();
          ?>
          <span class="likeList_count">총 <?=$ro1['total_rows']?>개</span>
          <?php
          ?>
          <?php
          $sq1= "SELECT * FROM like_board where id='$userid' ";
          $res1= mysqli_query($conn,$sq1);
          while($ro1=$res1->fetch_assoc()){
            $food_id=$ro1['food_id'];
            $sq2= "SELECT * FROM food where num='$food_id' ";
            $res2= mysqli_query($conn,$sq2);
            $ro2=$res2->fetch_assoc();
          ?>
          <div class="likeList_wrap">
            <a href="../fimg/<?=$ro2['image']?>">
              <img src="../fimg/<?=$ro2['image']?>" alt="천원국수" class="restaurant_img">
            </a>
            <p class="likeList_restaurant">
              <a href="../fimg/<?=$ro2['image']?>">
                <span class="restaurant_name"><?=$ro2['name']?></span>
              </a>
              <span>대한민국 <?=$ro2['area_do']?> <?=$ro2['area_si']?></span>
            </p>
            <button class="star_button" onclick="window.location.href='../like/cancle.php?no=<?=$food_id?>'">
              <i class="star_button_icon-check"></i>
            </button>
          </div>
          <?php
          }
          ?>
        </div>
      </div>
      <div class="rside_wrap">
        <div class="list_header">
          <div class="listName_wrap">
            <h2 class="list_name">방문식당</he>
          </div>
        </div>
        <div class="visitList_content">
          <?php
          $sq6 = "SELECT COUNT(DISTINCT id) as total_rows FROM review Where userid='$userid'";
          $res6 = mysqli_query($conn, $sq6);
          $ro6=$res6->fetch_assoc();
          ?>
          <span class="visitList_count">총 <?=$ro6['total_rows']?>개</span>
          <?php
          ?>
          <?php
          $sq4="SELECT DISTINCT id FROM review WHERE userid = '$userid'";
          $res4=mysqli_query($conn,$sq4);
          while($ro4=$res4->fetch_assoc()){
          $id=$ro4['id'];
          $sq5="SELECT * FROM food WHERE num = '$id' LIMIT 1";
          $res5=mysqli_query($conn,$sq5);
          $ro5=$res5->fetch_assoc();
          ?>
          <div class="visitList_wrap">
            <a href="../fimg/<?=$ro5['image']?>">
              <img src="../fimg/<?=$ro5['image']?>" alt="천원국수" class="restaurant_img">
            </a>
            <p class="visitList_restaurant">
              <a href="../fimg/<?=$ro5['image']?>">
               <span class="restaurant_name"><?=$ro5['name']?></span>
              </a>
              <span>대한민국 <?=$ro5['area_do']?> <?=$ro5['area_si']?></span> 
            </p>
          </div>
          <?php
          }
          ?>
        </div>
      </div>
      <div class="rside_wrap">
        <div class="list_header">
          <div class="listName_wrap">
            <h2 class="list_name">블라인드 목록</h>
          </div>
        </div>
        <div class="blindList_content">
          <?php
          $sq3= "SELECT COUNT(*) as total_rows FROM blind where myid='$userid' ";
          $res3= mysqli_query($conn,$sq3);
          $ro3=$res3->fetch_assoc();
          ?>
          <span class="blindList_count">총 <?=$ro3['total_rows']?>개</span>
          <?php
          ?>
          <?php
          $sq3= "SELECT * FROM blind where myid='$userid' ";
          $res3= mysqli_query($conn,$sq3);
          while($ro3=$res3->fetch_assoc()){
            $yourid = $ro3['yourid'];
          ?>
          <div class="blindList_wrap">
            <a>
              <img src="../review/image/그림01.jpg" alt="김서하바보다" class="blind_userPicture">
            </a>
            <p class="blindList_user">
              <a>
                <span class="blind_userName"><?=$yourid?></span>
              </a>
            </p>
            <button class="blind_button" onclick="window.location.href='../blind_delete.php?yourid=<?=$ro3['yourid']?>'">블라인드 풀기</button>
          </div>
          <?php
          }
          ?>
        </div>
      </div>
      <div class="rside_wrap">
        <div class="list_header">
          <div class="listName_wrap">
            <h2 class="list_name">개인 정보 수정</h2>
          </div>
        </div>
        <div class="pwCheck_content">
          <h4 class="pwCheck_text">비밀번호 재확인</h4>
          <p class="pwCheck_subtext">회원님의 정보를 안전하게 보호하기 위해 비밀번호를 다시 한번 확인해주세요.</p>
        </div>
        <form action="#">
          <div class="pwCheck_wrap">
            <!-- 아이디 -->
            <div class="userId_wrap">
              <div class="userId_text">
                <label for="userId" class="userId">아이디</label>
              </div>
              <div class="userId_text2">
                <div class="userId_text3">
                  <div class="userId_text4">
                    <input data-testid="input-box" id="userId" name="userId" type="text" readonly class="userId_input" value="<?=$_SESSION['userid']?>">
                  </div>
                </div>
              </div>
              <div class="userId_text5"></div>
            </div>
            <!-- 비밀번호 -->
            <div class="userId_wrap">
              <div class="userId_text">
                <label for="password" class="userId">비밀번호<span class="userId_text6">*</span></label>
              </div>
              <div class="userId_text2 passwordInput">
                <div class="userId_text3">
                  <div class="userId_text4">
                    <input data-testid="input-box" id="password" name="password" placeholder="현재 비밀번호를 입력해 주세요" type="password" autocomplete="off" class="userId_input" value ="">
                  </div>
                </div>
              </div>
              <div class="userId_text5"></div>
            </div>
          </div>
          <!-- 버튼 -->
          <div class="pwCheckButton_wrap">
            <button class="pwCheck_button" type="button">
              <span class="pwCheckButton_text">확인</span>
            </button>
          </div>
        </form>
      </div>
      <div class="rside_wrap">
        <div class="list_header">
          <div class="listName_wrap">
            <h2 class="list_name">개인 정보 수정</h2>
          </div>
        </div>
        <div class="infoModify_wrap">
          <form action="../login/member_modify.php?id=<?=$_SESSION['userid']?>" method="post">
            <!-- 아이디 -->
            <div class="userId_wrap">
              <div class="userId_text">
                <label for="userId1" class="userId">아이디</label>
              </div>
              <div class="userId_text2">
                <div class="userId_text3">
                  <div class="userId_text4">
                    <input data-testid="input-box" id="userId1" name="userId1" type="text" readonly class="userId_input" value="<?=$_SESSION['userid']?>">
                  </div>
                </div>
              </div>
              <div class="userId_text5"></div>
            </div>
            <!-- 현재 비밀번호 -->
            <div class="userId_wrap">
              <div class="userId_text">
                <label for="originalPassword" class="userId">현재 비밀번호</label>
              </div>
              <div class="userId_text2">
                <div class="userId_text3">
                  <div class="userId_text4">
                    <input data-testid="input-box" id="originalPassword" name="originalPassword" placeholder="비밀번호를 입력해 주세요" type="password" autocomplete="off" class="userId_input" value ="">
                  </div>
                </div>
              </div>
              <div class="userId_text5"></div>
            </div>
            <!-- 새 비밀번호 -->
            <div class="userId_wrap">
              <div class="userId_text">
                <label for="newPassword" class="userId">새 비밀번호</label>
              </div>
              <div class="userId_text2">
                <div class="userId_text3">
                  <div class="userId_text4">
                    <input data-testid="input-box" id="newPassword" name="newPassword" placeholder="새 비밀번호를 입력해 주세요" type="password" autocomplete="off" class="userId_input" value ="">
                  </div>
                </div>
              </div>
              <div class="userId_text5"></div>
            </div>
            <!-- 새 비밀번호 확인 -->
            <div class="userId_wrap">
              <div class="userId_text">
                <label for="newPasswordConfirm" class="userId">새 비밀번호 확인</label>
              </div>
              <div class="userId_text2">
                <div class="userId_text3">
                  <div class="userId_text4">
                    <input data-testid="input-box" id="newPasswordConfirm" name="newPasswordConfirm" placeholder="새 비밀번호를 다시 입력해 주세요" type="password" autocomplete="off" class="userId_input" value ="">
                  </div>
                </div>
              </div>
              <div class="userId_text5"></div>
            </div>
            <!-- 이름 -->
            <div class="userId_wrap">
              <div class="userId_text">
                <label for="name" class="userId">이름</label>
              </div>
              <div class="userId_text2">
                <div class="userId_text3">
                  <div class="userId_text4">
                    <input data-testid="input-box" id="name" name="name" placeholder="이름을 입력해 주세요" type="text" class="userId_input" value ="<?=$_SESSION['username']?>">
                  </div>
                </div>
              </div>
              <div class="userId_text5"></div>
            </div>
            <!-- 이메일 -->
            <div class="userId_wrap">
              <div class="userId_text">
                <label for="email" class="userId">이메일</label>
              </div>
              <div class="userId_text2">
                <div class="userId_text3">
                  <div class="userId_text4">
                    <input data-testid="input-box" id="email" name="email" placeholder="이메일을 입력해 주세요" type="text" class="userId_input" value ="<?=$_SESSION['email']?>">
                  </div>
                </div>
              </div>
              <div class="userId_text5"></div>
            </div>
            <!-- 휴대폰 -->
            <div class="userId_wrap">
              <div class="userId_text">
                <label for="mobileNumber" class="userId">휴대폰</label>
              </div>
              <div class="userId_text2 ">
                <div class="userId_text3">
                  <div class="userId_text4">
                    <input data-testid="input-box" id="mobileNumber" name="mobileNumber" placeholder="숫자만 입력해 주세요" type="text" class="userId_input" value ="<?=$_SESSION['phnum']?>">
                  </div>
                </div>
              </div>
              <div class="userId_text5"></div>
            </div>
            <!-- 성별 -->
            <div class="userId_wrap">
              <div class="userId_text">
                <label class="userId">성별</label>
              </div>
              <div class="userId_text2">
                <div class="userGender_wrap">
                  <label class="userGender_label" for="gender-man">
                    <input data-testid="radio-MALE" id="gender-man" name="gender" type="radio" class="userGender_radio" value="M"> 
                    <span class="userGender_radio2">
                      <div class="userGender_radio3"></div>
                    </span>
                    <span aria-labelledby="gender-man" class="userGender_text">남자</span>
                  </label>
                  <label class="userGender_label" for="gender-woman">
                    <input data-testid="radio-FEMALE" id="gender-woman" name="gender" type="radio" class="userGender_radio" value="F"> 
                    <span class="userGender_radio2">
                      <div class="userGender_radio3"></div>
                    </span>
                    <span aria-labelledby="gender-woman" class="userGender_text">여자</span>
                  </label>
                </div>
              </div>
              <div class="userId_text5"></div>
            </div>
            <!-- 생년월일 -->
            <div class="userId_wrap">
              <div class="userId_text">
                <label for="birthYear" class="userId">생년월일</label>
              </div>
              <div class="userId_text2 ">
                <div class="userBirth_wrap">
                  <div class="userBirth_date">
                    <div class="userBirth_date2">
                      <input data-testid="input-box" name="birthYear" placeholder="YYYY" type="text" class="userBirth_date3" value="<?=$year?>">
                    </div>
                  </div>
                  <span class="userBirth_date4"></span>
                  <div class="userBirth_date">
                    <div class="userBirth_date2">
                      <input data-testid="input-box" name="birthMonth" placeholder="MM" type="text" class="userBirth_date3" value="<?=$month?>">
                    </div>
                  </div>
                  <span class="userBirth_date4"></span>
                  <div class="userBirth_date">
                    <div class="userBirth_date2">
                      <input data-testid="input-box" name="birthDay" placeholder="DD" type="text" class="userBirth_date3" value="<?=$day?>">
                    </div>
                  </div>
                </div>
              </div>
              <div class="userId_text5"></div>
            </div>
            <!-- 버튼 -->
            <div class="infoButton_wrap">
              <button class="infoDelete_button" type="button" onclick>
                <span class="infoButton_text">탈퇴하기</span>
              </button>
              <button class="infoModify_button" type="submit">
                <span class="infoButton_text">회원정보수정</span>
              </button>
            </div>
          </form>
        </div>
      </div>
      <div class="rside_wrap">
        <div class="list_header">
          <div class="listName_wrap">
            <h2 class="list_name">전체등급</he>
          </div>
        </div>
        <div class="userRating_wrap">
          <div class="userRating"></div>
        </div>
      </div>
    </div>
  </div>
    </div>
  </div>
  
  
  

  <!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Core theme JS-->
  <script src="../js/scripts.js"></script>
  <!-- 마이페이지 JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="../js/mypages.js"></script>
  <script>
      let gender = '<?php echo $_SESSION['gender'];?>';
      const genderMan = document.querySelector('#gender-man');
      const genderWoman = document.querySelector('#gender-woman');
      const userGender_radio2 = document.querySelectorAll('.userGender_radio2');
      const userGender_radio3 = document.querySelectorAll('.userGender_radio3');
      if(gender == 'M'){
        genderMan.checked = true;
        let gendertext = '남자';
      }
      else{
      genderWoman.checked = true;
      let gendertext = '여자';
      }

      if (gendertext === '남자') {
        userGender_radio2[0].className = 'userGender_radio2_click';
        userGender_radio3[0].className = 'userGender_radio3_click';
      } else if (gendertext === '여자') {
        userGender_radio2[1].className = 'userGender_radio2_click';
        userGender_radio3[1].className = 'userGender_radio3_click';
      }

      genderMan.addEventListener('click', function () {
        genderMan.checked = true;

        userGender_radio2[0].className = 'userGender_radio2_click';
        userGender_radio3[0].className = 'userGender_radio3_click';
        userGender_radio2[1].className = 'userGender_radio2';
        userGender_radio3[1].className = 'userGender_radio3';
      });

      genderWoman.addEventListener('click', function () {
        genderWoman.checked = true;

        userGender_radio2[1].className = 'userGender_radio2_click';
        userGender_radio3[1].className = 'userGender_radio3_click';
        userGender_radio2[0].className = 'userGender_radio2';
        userGender_radio3[0].className = 'userGender_radio3';
      });
  </script>
</body>
</html>