<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BGS</title>
  <link rel="icon" href="/assets/paypal.svg">
  <link href="../css/styles.css" rel="stylesheet">
  <link href="/assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/idfind2.css" rel="stylesheet">
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
                    <ul class="navbar-nav">
                    <a style="font-size: 17px" class="navbar-brand" href="../login/login_form2.php">로그인</a></li>
                    </ul>
                </div>
            </div>
        </nav>
  </header>

  <div id="container">
    <!-- headname -->
    <div id="headName">
      <h1 id="page_title">아이디 찾기</h1>
    </div>
    <!-- headname -->
    <!-- content -->
    <div id="content">
      <div id="tabMenu">
        <input type="radio" id="tab1" name="tabs" onclick="show_phone()" checked>
        <label for="tab1">휴대폰 인증</label>
        <input type="radio" id="tab2" name="tabs" onclick="show_email()">
        <label for="tab2">이메일 인증</label>
      </div>
      <form id="idfind_form_phone" name="idfind_form_phone" action="idfind_find.php" method="post">
        <!-- 이름 입력 -->
        <div class="find_row">
          <strong class="find_title">
            <label for="name">이름</label>
          </strong>
          <span class="ps_box">
            <input type="text" id="name" name="name" title="이름" class="int" placeholder="이름 입력" maxlength="40" required>
          </span>
        </div>
        <!-- 이름 입력 -->
        <!-- 전화번호 입력 -->
        <div class="find_row">
          <strong class="find_title">
            <label for="phoneNo">전화번호</label>
          </strong>
          <span class="ps_box">
            <input type="text" id="phnum" name="phnum" title="전화번호" class="int" placeholder="전화번호" maxlength="16" required>
          </span>
        </div>
        <!-- 전화번호 입력 -->
        <div class="btn_area">
          <button type="submit" id="btnFind" class="btn_type bg-warning text-black">배고파계정 찾기</button>
        </div>
      </form>
      <form id="idfind_form_email" name="idfind_form_email" action="idfind_emailfind.php" method="post">
        <!-- 이름 입력 -->
        <div class="find_row">
          <strong class="find_title">
            <label for="name">이름</label>
          </strong>
          <span class="ps_box">
            <input type="text" id="name2" name="name2" title="이름" class="int" placeholder="이름 입력" maxlength="40" required>
          </span>
        </div>
        <!-- 이름 입력 -->
        <!-- 이메일 입력 -->
        <div class="find_row">
          <strong class="find_title">
            <label for="email">이메일</label>
          </strong>
          <span class="ps_box">
            <input type="text" id="email" name="email" title="전화번호" class="int" placeholder="이메일 입력" maxlength="16" required>
          </span>
        </div>
        <!-- 이메일 입력 -->
        <div class="btn_area">
          <button type="submit" id="btnFind" class="btn_type bg-warning text-black">배고파계정 찾기</button>
        </div>
      </form>
    </div>
    <!-- content -->
  </div>

  <script>
    var form1 = document.querySelector('#idfind_form_phone');
    var form2 = document.querySelector('#idfind_form_email');

    function show_phone() {
      form1.style.display = "block";
      form2.style.display = "none";
    }

    function show_email() {
      form1.style.display = "none";
      form2.style.display = "block";
    }
  </script>

  <!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Core theme JS-->
  <script src="js/scripts.js"></script>
</body>
</html>