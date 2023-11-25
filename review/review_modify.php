<?php
  require_once("../lib/dbconn.php");
  session_start();
  $num=$_GET['id'];
  $sql= "SELECT * FROM review where num ='$num'";
  $result= $conn->query($sql);
  $row=$result->fetch_assoc();
  $userid = $_SESSION['userid'];
  $userlevel = $_SESSION['userlevel'];
?>
<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>리뷰 쓰기</title>
    <link rel="icon" href="/assets/paypal.svg">
  <link href="../css/styles.css" rel="stylesheet">
  <link href="/assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/review_write (1).css" rel="stylesheet">
  <link rel="stylesheet" href="../css/star_rate.css">
  </head>
  <body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container px-4 px-lg-5">
        <a class="navbar-brand fw-bolder" href="../index.html">BGS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="../index.php">홈</a></li>
                        <li class="nav-item"><a class="nav-link active" href="../foodpage.php">마이페이지</a></li>
                        <li class="nav-item"><a class="nav-link active" href="../search/search2.php">검색</a></li>
                        <li class="nav-item"><a class="nav-link active" href="../main3.php">위치변경</a></li>
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
    <form class="writeForm" action="./modify.php?num=<?=$num?>" method="post" enctype="multipart/form-data">
      <div class="ReviewWritingPage_row">
        <strong class="restaurant_name">천원국수</strong>
        <div class="subMessageWrap">
          <span class="subMessage">에 대한 솔직한 리뷰를 써주세요.</span>
        </div>
      </div>
      <div class="ReviewWritingPage_contentWrap">
        <div class="ReviewWritingPage_formWrap">
          <div class="ReviewWritingPage_editorWrap">
            <div class="ReviewEditor">
              <div class="ReviewEditor_writeWrap">
              <div class="ReviewWritingPage_recommendWrap">
                <div class="ReviewWritingPage_recommend">  
                  <fieldset class="rate">
                    <input type="radio" id="rating10" name="rating" value="10"><label for="rating10" title="5점"></label>
                    <input type="radio" id="rating9" name="rating" value="9"><label class="half" for="rating9" title="4.5점"></label>
                    <input type="radio" id="rating8" name="rating" value="8"><label for="rating8" title="4점"></label>
                    <input type="radio" id="rating7" name="rating" value="7"><label class="half" for="rating7" title="3.5점"></label>
                    <input type="radio" id="rating6" name="rating" value="6"><label for="rating6" title="3점"></label>
                    <input type="radio" id="rating5" name="rating" value="5"><label class="half" for="rating5" title="2.5점"></label>
                    <input type="radio" id="rating4" name="rating" value="4"><label for="rating4" title="2점"></label>
                    <input type="radio" id="rating3" name="rating" value="3"><label class="half" for="rating3" title="1.5점"></label>
                    <input type="radio" id="rating2" name="rating" value="2"><label for="rating2" title="1점"></label>
                    <input type="radio" id="rating1" name="rating" value="1"><label class="half" for="rating1" title="0.5점"></label>
                  </fieldset>
                  <input type="hidden" name="id" value="<?=$num?>">
                  <input type="hidden" name="userid" value="<?= $_SESSION['userid'] ?>">
                  <input type="hidden" name="name" value="<?= $_SESSION['username'] ?>">
                </div>
              </div>
                <textarea
                  class="ReviewEditor_write"
                  name="story"
                ><?=$row['story']?></textarea>
              </div>
              <p class="ReviewEditor_TextLengthStateBox">
                <span class="ReviewEditor_TextLength">0</span>
                <span class="ReviewEditor_TextLengthStateDivider">/</span>
                <span class="ReviewEditor_MaxTextLength">10,000</span>
              </p>
            </div>
          </div>
          <div class="ReviewWritingPage_pictureWrap">
            <div class="ReviewPictureCounter">
              <span class="ReviewPictureCounter_Length">0</span>
              <span class="ReviewPictureCounter_Divider">/</span>
              <span class="ReviewPictureCounter_MaxLength">30</span>
            </div>
            <div class="ReviewPictureContainer">
              <ul class="ReviewPictureContainer_pictureList">
                <li
                  class="ReviewPictureContainer_pictureItem pictureItem_button"
                >
                  <button class="ReviewPictureContainer_AddButton" type="button">
                    <i class="ReviewPictureContainer_AddIcon"></i>
                  </button>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="ReviewWritingPage_ButtonsWrap">
        <div class="ReviewWritingPage_Buttons">
          <button class="ReviewWritingPage_CancelButton">취소</button>
          <button class="ReviewWritingPage_SubmitButton" type="submit">리뷰 올리기</button>
        </div>
      </div>
    </form>
    </div>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <!-- 리뷰 쓰기 페이지 JS -->
    <script src="../js/review_modify.js"></script>
  </body>
</html>
