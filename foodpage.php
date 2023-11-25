<?php
 include "./lib/dbconn.php";   
 session_start(); //세션을 저장하든 읽어오든 사용하고자 하면 이 함수로 시작

 $userid="";
 $username="";
 $userlevel=""; //회원등급 : 1~9등급 [1등급:관리자, 9등급:신규회원]
 $userpoint="";
    
 if( isset($_SESSION['userid'])) $userid= $_SESSION['userid'];
 if( isset($_SESSION['username'])) $username= $_SESSION['username'];
 if( isset($_SESSION['userlevel'])) $userlevel= $_SESSION['userlevel'];
 if( isset($_SESSION['userphnum'])) $userpoint= $_SESSION['userphnum'];
 $num=$_GET['no'];
 $sql="SELECT * from food_img where fdnum='$num'";
 $result= mysqli_query($conn,$sql);
 $sql2="SELECT AVG(star_rate) from review where id='$num'";
 $result2= mysqli_query($conn,$sql2);
 $row2=$result2->fetch_assoc();
 $avg_math = $row2['AVG(star_rate)'];
 $avg_math_formatted = number_format($avg_math, 1);
 $sql7 = "UPDATE food SET star_num = $avg_math_formatted WHERE num = '$num'";
 mysqli_query($conn, $sql7);
 $sql3="SELECT * from food where num='$num'";
 $result3=mysqli_query($conn,$sql3);
 $row3=$result3->fetch_assoc();
 $sql4="SELECT * from food_menu where fdnum='$num'";
 $result4=mysqli_query($conn,$sql4);
 $sql5= "SELECT * FROM review where id='$num'&& userid NOT IN(SELECT yourid FROM blind where myid='$userid')";
 $result5= $conn->query($sql5);
 $lat=$row3['lat'];
 $lng=$row3['lng'];
 $url2 = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&key=AIzaSyAgknUPj1dae6P2qe5Z7FNuxTn7sinn5_4&language=ko";

 $res2 = file_get_contents($url2); // API 응답 받아오기
 $response2 = json_decode($res2, true); // JSON 데이터 파싱
 $formatted_address2 = $response2['results'][0]['formatted_address']; //지번

 $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&key=AIzaSyAgknUPj1dae6P2qe5Z7FNuxTn7sinn5_4&language=ko&result_type=street_address";

 $res = file_get_contents($url); // API 응답 받아오기
 $response = json_decode($res, true); // JSON 데이터 파싱
 $formatted_address = $response['results'][0]['formatted_address']; //도로명

 $sql10= "SELECT * FROM like_board where food_id='$num'&& id='$userid'";
 $result10= $conn->query($sql10);
 $row10 = $result10 -> fetch_assoc();

 $sq = "SELECT COUNT(*) AS goodcount FROM review WHERE id='$num'&& star_rate>=4 && star_rate<=5 && userid NOT IN(SELECT yourid FROM blind where myid='$userid')";
 $res = mysqli_query($conn, $sq);
 $ro = $res -> fetch_assoc();

 $sq2 = "SELECT COUNT(*) AS goodcount FROM review WHERE id='$num'&& star_rate>=2 && star_rate<4 && userid NOT IN(SELECT yourid FROM blind where myid='$userid')";
 $res2 = mysqli_query($conn, $sq2);
 $ro2 = $res2 -> fetch_assoc();

 $sq3 = "SELECT COUNT(*) AS goodcount FROM review WHERE id='$num'&& star_rate>=0 && star_rate<2 && userid NOT IN(SELECT yourid FROM blind where myid='$userid')";
 $res3 = mysqli_query($conn, $sq3);
 $ro3 = $res3 -> fetch_assoc();
 
 $sq4 = "SELECT COUNT(*) AS likeview FROM like_board WHERE food_id='$num'";
 $res4 = mysqli_query($conn, $sq4);
 $ro4 = $res4 -> fetch_assoc();

 $total=$ro['goodcount']+$ro2['goodcount']+$ro3['goodcount'];
?>
<!DOCTYPE html>
<html lang="ko">
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgknUPj1dae6P2qe5Z7FNuxTn7sinn5_4&callback=initMap&libraries=&v=weekly"
      defer
      src="https://maps.googleapis.com/maps/api/geocode/api/js?key=AIzaSyAgknUPj1dae6P2qe5Z7FNuxTn7sinn5_4&callback=initMap&libraries=&v=weekly"
      defer>
    </script>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?=$row3['name']?></title>
  <link rel="icon" href="/assets/paypal.svg">
  <link href="css/styles.css" rel="stylesheet">
  <link href="./css/food_page.css" rel="stylesheet">
</head>
<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container px-4 px-lg-5">
        <a class="navbar-brand fw-bolder" href="./index.php">BGS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="./index.php">홈</a></li>
                <li class="nav-item"><a class="nav-link active" href="./like.php">좋아요</a></li>
                <li class="nav-item"><a class="nav-link active" href="./mypage/my_page.php">마이페이지</a></li>
                <li class="nav-item"><a class="nav-link active" href="./main3.php">위치변경</a></li>
            </ul>
            <ul class="navbar-nav">
                     <!-- 로그인 안되었을 때 -->
                        <?php if(!$userid){  ?>
                            <a style="font-size: 17px" class="navbar-brand" href="./member/member_form.php">회원가입</a></li>
                            <a style="font-size: 17px" class="navbar-brand" href="./login/login_form2.php">로그인</a></li>
                        <?php }else{ ?>
                            <a style="font-size: 17px" class="navbar-brand" href="./login/logout.php">로그아웃</a></li>
                        <?php }?>

                        <!-- 관리자모드로 로그인되었을 때 추가로.. -->
                        <?php if($userlevel==1){?>
                            <a style="font-size: 17px" class="navbar-brand" href="./admin/admin_form.php">관리자모드</a></li>
                        <?php } ?>
                    </ul>   
        </div>
      </div>
    </nav>
  </header>

  <div id="container">
    <!-- 레스토랑 상세 이미지 슬라이드 -->
    <div id="images">
      <div id="imgShow">
        <?php
        while($row=$result -> fetch_assoc()){
        ?>    
        <div class="imgwrap">
          <img src="./fimg/<?=$row['db_filename']?>" alt="">
        </div>
        <?php
        } ?>
      </div>
    </div>
    <div id="content">
      <div id="lside_wrap">
        <div id="inner">
          <!-- 레스토랑 상세 -->
          <div id="restaurant_detail">
            <div class="restaurant_header">
              <div class="restaurant_title">
                <div class="title_wrap">
                  <h1 class="restaurant_name"><?=$row3['name']?></h1>
                  <strong class="rate_point"><?=$avg_math_formatted?></strong>
                  <p class="branch">순천향대점</p>
                </div>
                <div class="restaurant_action_button">
                  <button class="review_writing_button" onclick="window.location.href='./review/review_write.php?numb=<?=$num?>'">
                    <i class="review_writing_button_icon"></i>
                    <span class="button_text">리뷰쓰기</span>
                  </button>
                  <button id="star_button" class="star_button">
                    <?php
                      if(!$row10){
                        ?>
                        <a href='./like/like.php?no=<?= $num?>'><i id="star_icon" class="star_button_icon"></i></a>
                        <?php
                      }
                      else{
                        ?>
                        <a href='./like/cancle.php?no=<?= $num?>'><i id="star_icon" class="star_button_icon2"></i></a>
                        <?php
                      }
                    ?>
                    <span class="button_text">가고싶다</span>
                  </button>
                </div>
              </div>
              <div class="status">
                <span class="cnt">
                  <i class="eye_fill"></i>
                  <span><?=$row3['count']?></span>
                </span>
                <span class="cnt">
                  <i class="pencil_fill"></i>
                  <span><?=$total?></span>
                </span>
                <span class="cnt">
                  <i class="star_fill"></i>
                  <span><?=$ro4['likeview']?></span>
                </span>
              </div>
            </div>
            <!-- 상세 정보 -->
            <table class="info no_menu">
              <caption>레스토랑 상세 정보</caption>
              <tbody>
                <tr class="only_desktop">
                  <th>주소</th>
                  <td>
                     <?=$formatted_address?><!-- 도로명 -->
                    <span class="restaurant_infoAddress_rectangle">지번</span>
                    <span class="restaurant_infoAddress_text"><?=$formatted_address2?></span><!-- 지번 -->
                  </td>
                </tr>
                <tr class="only_desktop">
                  <th>전화번호</th>
                  <?php
                  if($row3['tnum']){
                  ?><td><?=$row3['tnum']?></td><?php
                  }
                  else{
                    ?><td>정보가 없습니다.</td><?php
                  }
                  ?>
                <tr>
                  <th>음식 종류</th>
                  <?php
                  if($row3['type']){
                  ?><td><?=$row3['type']?></td><?php
                  }
                  else{
                    ?><td>정보가 없습니다.</td><?php
                  }
                  ?>
                </tr>
                <tr>
                  <th>주차</th>
                  <?php
                  if($row3['tnum']){
                  ?><td><?=$row3['tnum']?></td><?php
                  }
                  else{
                    ?><td>정보가 없습니다.</td><?php
                  }
                  ?>
                </tr>
                <tr>
                  <th>영업시간</th>
                  <?php
                  if($row3['time']){
                  ?><td><?=$row3['time']?></td><?php
                  }
                  else{
                    ?><td>정보가 없습니다.</td><?php
                  }
                  ?>
                </tr>
                <tr>
                  <th>메뉴</th>
                  <?php
                  if($row3['tnum']){
                      ?><td>
                      <?php
                    while($row4=$result4 -> fetch_assoc()){
                    ?>    
                    <ul class="restaurant_MenuList">
                      <li class="restaurant_MenuItem">
                        <span class="restaurant_Menu"><?=$row4['menu']?></span>
                        <span class="restaurant_MenuPrice"><?=$row4['price']?>원</span>
                      </li>
                    </ul>
                    <?php
                    } ?>
                  </td>
                  <?php
                  }
                  else{
                    ?><td>정보가 없습니다.</td><?php
                  }
                  ?>
                </tr>
              </tbody>
            </table>
            <p class="update">업데이트 : <?=$row3['regist_day']?></p>
          </div>
          <!-- 식당 소개 -->
          <div id="restaurant_introduce">
            <div class="restaurant_introduce_section">
              <h3 class="restaurant_introduce_title">식당 소개</h3>
              <div class="restaurant_introduce_content">
                <?php
                if($row3['restaurant_introduction']){
                  ?>
                  <p class="restaurantOwner_comment"><?=$row3['restaurant_introduction']?></p>
                  <?php
                }
                else{
                  ?>
                  <p class="restaurantOwner_comment">식당 소개를 입력해주세요.</p>
                  <?php
                }
                ?>

              </div>
            </div>
          </div>
          <!-- 리뷰 목록 -->
          <div id="restaurant_reviewList">
            <div class="restaurant_reviewList_header">
              <h2 class="restaurant_reviewList_title">
                <span class="only_mobile"><?=$row3['name']?></span>
                <span class="only_mobile">의 리뷰</span>
                <span class="only_desktop">리뷰</span>
                <span class="restaurant_reviewList_count" style="color: #7f7f7f;"><?=$total?></span>
              </h2>
              <ul class="restaurant_reviewList_filterList only_desktop">
                <li class="restaurant_reviewList_filterItem">
                  <button class="restaurant_reviewList_filterButton restaurant_reviewList_filterButton-Selected">
                    전체
                    <span class="restaurant_reviewList_count"><?=$total?></span>
                  </button>
                </li>
                <li class="restaurant_reviewList_filterItem">
                  <button class="restaurant_reviewList_filterButton">
                    맛있다
                    <span class="restaurant_reviewList_count"><?=$ro['goodcount']?></span>
                  </button>
                </li>
                <li class="restaurant_reviewList_filterItem">
                  <button class="restaurant_reviewList_filterButton">
                    괜찮다
                    <span class="restaurant_reviewList_count"><?=$ro2['goodcount']?></span>
                  </button>
                </li>
                <li class="restaurant_reviewList_filterItem">
                  <button class="restaurant_reviewList_filterButton" style="padding-right: 0;">
                    별로
                    <span class="restaurant_reviewList_count"><?=$ro3['goodcount']?></span>
                  </button>
                </li>
              </ul>
            </div>
            <ul id="review_content" class="restaurant_reviewList_content">
            <?php
            while($row5=$result5->fetch_assoc()){
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
                <div class="restaurant_reviewItem_link">
                  <div class="restaurant_reviewItem_user">
                    <div class="restaurant_reviewItem_userPicturewrap">
                      <img class="restaurant_reviewItem_userPicture" src="../review/image/그림01.jpg" alt="user profile picture">
                    </div>
                    <span class="restaurant_reviewItem_userNickname"><?= $row5['name']?></span>
                    <ul class="restaurant_reviewItem_userStat">
                    <?php  
                        if(!$row9&&$row8){ ?>
                          <li><button class="restaurant_reviewItem_userStatItem userStatItem_like_1" onclick="window.location.href='./review/like_review_cancle.php?like=<?=$renum?>&like_id=<?=$row5['userid']?>'"><?=$row11['likecount']?></button></li>
                          <li><button class="restaurant_reviewItem_userStatItem userStatItem_hate"><?=$row12['hatecount']?></button></li>
                        <?php }
                        else if($row9&&!$row8){?>
                          <li><button class="restaurant_reviewItem_userStatItem userStatItem_like"><?=$row11['likecount']?></button></li>
                          <li><button class="restaurant_reviewItem_userStatItem userStatItem_hate_1" onclick="window.location.href='./review/hate_review_cancle.php?hate=<?=$renum?>&hate_id=<?=$row5['userid']?>'"><?=$row12['hatecount']?></button></li>
                        <?php }
                        else if(!$row9&&!$row8){
                          ?>
                          <li><button class="restaurant_reviewItem_userStatItem userStatItem_like" onclick="window.location.href='./review/like_review.php?like=<?=$renum?>&like_id=<?=$row5['userid']?>'"><?=$row11['likecount']?></button></li>
                          <li><button class="restaurant_reviewItem_userStatItem userStatItem_hate" onclick="window.location.href='./review/hate_review.php?hate=<?=$renum?>&hate_id=<?=$row5['userid']?>'"><?=$row12['hatecount']?></button></li>
                        <?php
                        }
                    ?>
                    </ul>
                    <?php
                    if($userid!=$row5['userid']){
                      ?>
                      <button class="restaurant_reviewItem_userBlind only_desktop" onclick="window.location.href='./blind.php?yourid=<?=$row5['userid']?>'">블라인드</button>
                      <?php
                    }
                    ?>
                  </div>
                  <a class="restaurant_reviewItem_content" href="naver.com" style="text-decoration:none;">
                    <div class="restaurant_reviewItem_textWrap">
                      <p class="restaurant_reviewItem_text"><?= $row5['story']?></p>
                      <span class="restaurant_reviewItem_Date"><?= $row5['redate']?></span>
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
                          <img class="restaurant_reviewItem_Picture" src="./review/image/<?=$row6['db_filename']?>">
                        </button>
                      </li>
                      <?php
                      }
                      ?>
                    </ul>
                  </a>
                  <?php
                  if($rating >= 4 && $rating <= 5){
                    ?>
                  <div class="restaurant_reviewItem_Rating Rating_Recommend">
                    <span class="restaurant_reviewItem_RatingText">맛있다</span>
                    <?php
                    if($userid!=$row5['userid']){
                      ?>
                      <button class="restaurant_reviewItem_userBlind only_mobile" onclick="window.location.href='./blind.php?yourid=<?=$row5['userid']?>'">블라인드</button>
                      <?php
                    }
                    ?>
                    <span class="only_desktop">
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $rating) {
                            ?><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ff792a" class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                          </svg><?php
                        } elseif ($i == ceil($rating) && $rating != floor($rating)) {
                            ?><span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ff792a" class="bi bi-star-half fw-bolder" viewBox="0 0 16 16">
                            <path d="M5.354 5.119 7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.537.537 0 0 1 16 6.32a.548.548 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.52.52 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.58.58 0 0 1 .085-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.565.565 0 0 1 .162-.505l2.907-2.77-4.052-.576a.525.525 0 0 1-.393-.288L8.001 2.223 8 2.226v9.8z"/>
                          </svg><?php
                        } else {
                            ?><span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ff792a" class="bi bi-star" viewBox="0 0 16 16">
                            <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                          </svg><?php
                        }
                    }
                    ?>
                    </span>   
                  </div>
                  <?php
                  }
                  else if($rating >= 2 && $rating < 4){
                    ?>
                    <div class="restaurant_reviewItem_Rating Rating_Recommend2">
                    <span class="restaurant_reviewItem_RatingText">괜찮다</span>
                    <?php
                    if($userid!=$row5['userid']){
                      ?>
                      <button class="restaurant_reviewItem_userBlind only_mobile" onclick="window.location.href='./blind.php?yourid=<?=$row5['userid']?>'">블라인드</button>
                      <?php
                    }
                    ?>
                    <span class="only_desktop">
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $rating) {
                            ?><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ff792a" class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                          </svg><?php
                        } elseif ($i == ceil($rating) && $rating != floor($rating)) {
                            ?><span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ff792a" class="bi bi-star-half fw-bolder" viewBox="0 0 16 16">
                            <path d="M5.354 5.119 7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.537.537 0 0 1 16 6.32a.548.548 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.52.52 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.58.58 0 0 1 .085-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.565.565 0 0 1 .162-.505l2.907-2.77-4.052-.576a.525.525 0 0 1-.393-.288L8.001 2.223 8 2.226v9.8z"/>
                          </svg><?php
                        } else {
                            ?><span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ff792a" class="bi bi-star" viewBox="0 0 16 16">
                            <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                          </svg><?php
                        }
                    }
                    ?>
                    </span>   
                  </div>
                    <?php
                  }
                  else{
                    ?>
                    <div class="restaurant_reviewItem_Rating Rating_Recommend3">
                    <span class="restaurant_reviewItem_RatingText">별로</span>
                    <?php
                    if($userid!=$row5['userid']){
                      ?>
                      <button class="restaurant_reviewItem_userBlind only_mobile" onclick="window.location.href='./blind.php?yourid=<?=$row5['userid']?>'">블라인드</button>
                      <?php
                    }
                    ?>
                    <span class="only_desktop">
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $rating) {
                            ?><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ff792a" class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                          </svg><?php
                        } elseif ($i == ceil($rating) && $rating != floor($rating)) {
                            ?><span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ff792a" class="bi bi-star-half fw-bolder" viewBox="0 0 16 16">
                            <path d="M5.354 5.119 7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.537.537 0 0 1 16 6.32a.548.548 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.52.52 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.58.58 0 0 1 .085-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.565.565 0 0 1 .162-.505l2.907-2.77-4.052-.576a.525.525 0 0 1-.393-.288L8.001 2.223 8 2.226v9.8z"/>
                          </svg><?php
                        } else {
                            ?><span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ff792a" class="bi bi-star" viewBox="0 0 16 16">
                            <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                          </svg><?php
                        }
                    }
                    ?>
                    </span>  
                  </div>
                    <?php
                  }
                  ?>
                </div>
              </li>        
            <?php
            }
            ?>
            </ul>
            <div id="moreButton" class="restaurant_reviewList_moreButton" role="button">더보기</div> 
          </div>
        </div>
      </div>
      <div id="rside_wrap">
        <div id="column_side">
          <div class="map_container" id="map">
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  
      let map;
      function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
          center: { lat: <?php echo $row3['lat']; ?>, lng: <?php echo $row3['lng']; ?>},          
          zoom: 17,
          disableDefaultUI: true
        });
      
        const myLatLng = { lat: <?php echo $row3['lat']; ?>, lng: <?php echo $row3['lng']; ?> };
        
        new google.maps.Marker({
        position: myLatLng,
        map,
        title: "<?php echo $row3['name']; ?>",
    
    });

      }
  </script> 
  <!-- Core theme JS-->
  <script src="js/scripts.js"></script>
  <script>
    var filterButtons = document.getElementsByClassName('restaurant_reviewList_filterButton');
    var reviewContainer = document.getElementById('review_content');
    var reviews = Array.from(reviewContainer.getElementsByClassName('restaurant_reviewList_reviewItem'));
    var recommends = reviewContainer.getElementsByClassName('restaurant_reviewItem_RatingText');
    var loadMoreButton = document.getElementById('moreButton');
    const visibleReviews = 5;
    var currentIndex = 0;
    var filteredReviews = [];
    var currentFilter = "전체";

    for (var i = 0; i < filterButtons.length; i++) {
      filterButtons[i].addEventListener('click', function() {
        for (var j = 0; j < filterButtons.length; j++) {
          filterButtons[j].classList.remove('restaurant_reviewList_filterButton-Selected');
        }
        
        var fillter = this.textContent;
        this.classList.add('restaurant_reviewList_filterButton-Selected');
        if (fillter.includes('전체')) {
          filterReviews('전체');
        } else if (fillter.includes('맛있다')) {
          filterReviews('맛있다');
        } else if (fillter.includes('괜찮다')) {
          filterReviews('괜찮다');
        } else if (fillter.includes('별로')) {
          filterReviews('별로');
        }
      })
    }

    function filterReviews(filter) {
      currentFilter = filter;
      currentIndex = 0;
      for (var i = 0; i < reviews.length; i++) {
        reviews[i].style.display = "none";
      }

      filteredReviews = [];

      if (filter === "전체") {
        filteredReviews = reviews;
      } else {
        var j = 0;
        for (var i = 0; i < reviews.length; i++) {
          if (filter === recommends[i].textContent) {
            filteredReviews[j++] = reviews[i];
          }
        }
      }
      showReviews();
    }

    function showReviews() {
      for (var i = currentIndex; i < currentIndex + visibleReviews; i++) {
        if (filteredReviews[i]) {
          filteredReviews[i].style.display = 'block';
        }
      }

      currentIndex += visibleReviews;

      if (currentIndex >= filteredReviews.length) {
        loadMoreButton.style.display = 'none';
      } else {
        loadMoreButton.style.display = 'flex';
      }
    }

    loadMoreButton.addEventListener('click', showReviews);

    window.onload = function() {
      filterButtons[0].click();
    };
  </script>
</body>
</html>