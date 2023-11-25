<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BGS</title>
  <link rel="icon" href="/assets/paypal.svg">
  <link href="../css/sign-in.css" rel="stylesheet">
  <link href="/assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/styles.css" rel="stylesheet">

  <style>
    .contents {
      display: block;
      text-align: center;
      padding-top: 40px;
      padding-bottom: 40px;
      background-color: #f5f5f5;
      height: 100%;
    }
    
  </style>
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
  <main class="form-signin w-100 m-auto">
    <form action="./login.php" method="post">
      <!--<img class="mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">-->
      <h1 class="h3 mb-3 fw-normal">로그인</h1>

      <div class="form-floating">
        <input type="text" class="form-control" name="id" placeholder="아이디">
        <label for="floatingInput">아이디</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" name="pass" placeholder="비밀번호">
        <label for="floatingPassword">비밀번호</label>
      </div>

      <!-- <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> 자동로그인
        </label>
      </div> -->
      <button class="w-100 btn btn-lg btn-primary bg-warning text-black" type="submit">로그인</button>
      <div>
        <p></p>
        <p><a style="text-decoration:none" href="../idfind/idfind_form.php" title="Find-id">아이디찾기</a>  |  <a style="text-decoration:none" href="../pwfind/pwfind_form.php" title="Find-pw">비밀번호찾기</a>  |  <a style="text-decoration:none" href="../member/member_form.php" title="sign-up">회원가입</a></p>
      </div>
    </form>
  </main>

  <!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Core theme JS-->
  <script src="js/scripts.js"></script>
</body>
</html>