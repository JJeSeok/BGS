<?php
include "../lib/dbconn.php";
session_start();
$userid="";
$username="";
$userlevel=""; //회원등급 : 1~9등급 [1등급:관리자, 9등급:신규회원]
$userpoint="";
if( isset($_SESSION['userid'])) $userid= $_SESSION['userid'];
if( isset($_SESSION['username'])) $username= $_SESSION['username'];
if( isset($_SESSION['userlevel'])) $userlevel= $_SESSION['userlevel'];
if( isset($_SESSION['userphnum'])) $userpoint= $_SESSION['userphnum'];
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>회원가입</title>
  <link rel="icon" href="/assets/paypal.svg">
  <link href="/css/styles.css" rel="stylesheet">
  <link href="/assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/css/sign-up2.css" rel="stylesheet">
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
                        <li class="nav-item"><a class="nav-link active" href="../main3.php">위치변경</a></li>
                    </ul>
                </div>
            </div>
        </nav>
  </header>
  <!-- headname -->
  <div id="headName">
    <h1>BGS</h1>
  </div>
  <!-- headname -->
  <form id="join_form" action="./member_insert.php" method="post">
    <!-- container -->
    <div id="container">
      <div id="content">
        <!-- 아이디, 비밀번호 입력 -->
        <div class="row_group">
          <div class="join_row">
            <h3 class="join_title">
              <label for="id">아이디</label>
            </h3>
            <span class="ps_box">
              <input type="text" id="id" name="id" class="int" title="ID" maxlength="20" required>
            </span>
            <span class="error_next_box" id="idMsg" style="display: none"></span>
          </div>
          <div class="join_row">
            <h3 class="join_title">
              <label for="pass">비밀번호</label>
            </h3>
            <span class="ps_box int_pass">
              <input type="password" id="pass" name="pass" class="int" title="비밀번호 입력" maxlength="20" required>
            </span>
            <span class="error_next_box" id="pwdMsg" style="display: none"></span>
            <h3 class="join_title">
              <label for="pass_confirm">비밀번호 재확인</label>
            </h3>
            <span class="ps_box int_pass">
              <input type="password" id="pass_confirm" name="pass_confirm" class="int" title="비밀번호 재확인 입력" maxlength="20" required>
            </span>
            <span class="error_next_box" id="pwdMsg" style="display: none"></span>
          </div>
        </div>
        <!-- 아이디, 비밀번호 입력 -->
        <!-- 이름, 생년월일 입력 -->
        <div class="row_group">
          <div class="join_row">
            <h3 class="join_title">
              <label for="name">이름</label>
            </h3>
            <span class="ps_box box_right_space">
              <input type="text" id="name" name="name" title="이름" class="int" maxlength="40" required>
            </span>
            <span class="error_next_box" id="nameMsg" style="display: none"></span>
          </div>
          <div class="join_row join_birthday">
            <h3 class="join_title">
              <label for="yy">생년월일</label>
            </h3>
            <div class="bir_wrap">
              <div class="bir_yy">
                <span class="ps_box">
                  <input type="text" id="yy" name="yy" placeholder="년(4자)" aria-label="년(4자)" class="int" maxlength="4" required>
                </span>
              </div>
              <div class="bir_mm">
                <span class="ps_box">
                  <select id="mm" name="mm" class="sel" aria-label="월" required>
                    <option value>월</option>
                    <option value="01">1</option>
                    <option value="02">2</option>
                    <option value="03">3</option>
                    <option value="04">4</option>
                    <option value="05">5</option>
                    <option value="06">6</option>
                    <option value="07">7</option>
                    <option value="08">8</option>
                    <option value="09">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                  </select>
                </span>
              </div>
              <div class="bir_dd">
                <span class="ps_box">
                  <input type="text" id="dd" name="dd" placeholder="일" aria-label="일" class="int" maxlength="2" required>
                </span>
              </div>
            </div>
            <span class="error_next_box" id="birthdayMsg" style="display: none" aria-live="assertive"></span>
          </div>
          <div class="join_row join_sex">
            <h3 class="join_title">
              <label for="gender">성별</label>
            </h3>
            <div class="ps_box gender_code">
              <select id="gender" name="gender" class="sel" aria-label="성별" required>
                <option value selected>성별</option>
                <option value="M">남자</option>
                <option value="F">여자</option>
              </select>
            </div>
          </div>
          <span class="error_next_box" id="genderMsg" style="display: none" aria-live="assertive"></span>
          <div class="join_row">
            <h3 class="join_title">
              <label for="email">이메일</label>
            </h3>
            <span class="ps_box .box_right_space">
              <input type="text" id="email" name="email" placeholder="이메일" aria-label="이메일" class="int" maxlength="100" required>
            </span>
          </div>
          <span class="error_next_box" id="emailMsg" style="display: none" aria-live="assertive"></span>
        </div>
        <!-- 이름, 생년월일 입력 -->
        <!-- 휴대전화 번호 -->
        <div class="join_row">
          <h3 class="join_title">
            <label for="phoneNo">휴대전화</label>
          </h3>
          <span class="ps_box .box_right_space">
            <input type="tel" id="phoneNo" name="phnum" placeholder="전화번호 입력" aria-label="전화번호 입력" class="int" maxlength="16" required>
          </span>
        </div>
        <!-- 휴대전화 번호 -->
        <div class="btn_area">
          <button type="submit" id="btnJoin" class="btn_type bg-warning text-black">
            <span>가입하기</span>
          </button>
        </div>
        <!-- 휴대전화 번호 -->
      </div>
    </div>
    <!-- container -->
  </form>

  <!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Core theme JS-->
  <script src="js/scripts.js"></script>
</body>
</html>