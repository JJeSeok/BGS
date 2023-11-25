<?php 
    //로그인을 하면 session에 정보를 저장하고 각 페이지들에서 모두 사용하고자 함.
    //로그인에 띠라 화면구성이 다르기에 세션에 저장되어 있는 회원정보 중 id, name, level 값 읽어오기
    session_start(); //세션을 저장하든 읽어오든 사용하고자 하면 이 함수로 시작

    $userid="";
    $username="";
    $userlevel=""; //회원등급 : 1~9등급 [1등급:관리자, 9등급:신규회원]
    $userphnum="";
    
    if( isset($_SESSION['userid'])) $userid= $_SESSION['userid'];
    if( isset($_SESSION['username'])) $username= $_SESSION['username'];
    if( isset($_SESSION['userphnum'])) $userlevel= $_SESSION['userphnum'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>baegopa</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link rel="stylesheet" href="../css/styles.css">
    <!-- member_form.php전용 스타일 -->
    <link rel="stylesheet" href="../css/member.css">
    <script>
        // 서밋 버튼 이미지 클릭시
        function submitForm(){
            
            // 비밀번호 비어 있는가?
            if(!document.member_form.pass.value){
                alert("비밀번호를 입력하세요.");
                document.member_form.pass.focus();
                return;
            }
             // 비밀번호 확인 비어 있는가?
             if(!document.member_form.pass_confirm.value){
                alert("비밀번호 확인을 입력하세요.");
                document.member_form.pass_confirm.focus();
                return;
            }
             // 이름 비어 있는가?
             if(!document.member_form.name.value){
                alert("이름을 입력하세요.");
                document.member_form.name.focus();
                return;
            }
            // 비밀번호와 비밀번호 확인 칸의 입력값이 같은지 비교
            if(document.member_form.pass.value != document.member_form.pass_confirm.value){
                alert("비밀번호가 일치하지 않습니다.\n다시 입력해 주세요.");
                document.member_form.pass.focus();
                // 커서가 이동하고 그곳에 써있는 글씨가 선택되어 있음.
                document.member_form.pass.select();
                return;
            }
            // form요소를 직접 submit하는 메소드
            document.member_form.submit(); //겟 엘리먼트 안하고 폼, 인풋을 name속성이 document 배열로 찾을 수 있음.
            
        }

        // 초기화 버튼 이미지 클릭시
        function resetForm(){
            document.member_form.id.value="";
            document.member_form.pass.value="";
            document.member_form.pass_confirm.value="";
            document.member_form.name.value="";
            document.member_form.phnum.value="";
            document.member_form.email1.value="";
            document.member_form.email2.value="";

            // 첫번째 입력 요소로 이동
            document.member_form.id.focus();
        }

    </script>

</head>
<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand fw-bolder" href="#!">배고파</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="../index.php">홈</a></li>
                        <li class="nav-item"><a class="nav-link active" href="../like.php">좋아요</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">마이페이지</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#!">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                                <li><a class="dropdown-item" href="../message/message_form.php">쪽지</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link active" href="../search.php">검색</a></li>
                    </ul>
                    <ul class="navbar-nav">
                        <a style="font-size: 17px" class="navbar-brand" href='http://google.com/maps'>
                        map
                        </a>
                    </ul>

                </div>
            </div>
        </nav>
    <header class="bg-warning py-2">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-black">
                    <h1 class="display-4 fw-bolder">정보수정</h1>
                    <p class="lead fw-normal text-white-50 mb-0"></p>
                </div>
            </div>
    </header>


    <!-- 로그인 되어 있는 회원의 정보를 읽어오는 php 코드 작성 -->
    <?php
            include "../lib/dbconn.php";
            //로그인 되어있는 회원의 정보를 읽어오는 쿼리문 
            $sql="SELECT * FROM member WHERE id='$userid'";
            $result = mysqli_query($conn,$sql);
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);//연관배열 = [이름명]
            $pass = $row['pass'];
            $phnum = $row['phnum'];
            $email = explode("@",$row['email']); //배열이 만들어짐 
            $email1=$email[0];
            $email2=$email[1];

            mysqli_close($conn);

    ?>

    <section>
        <div id="main_content">
            <div id="join_box">
                <!-- DB의 member테이블에 저장하는 member_modify.php에 입력값들 전달하도록 -->
                <form action="./member_modify.php?id=<?=$userid?>" method="post" name="member_form">
                    
                    <!-- 각 줄마다 라벨, 인풋요소 영역으로 나누어 지므로 col1, col2 클래스지정으로 스타일링 -->
                    <div class="form id">
                        <div class="col1">아이디</div>
                        <div class="col2"> <?= $userid ?> </div>
                    </div>
                    <div class="form">
                        <div class="col1">비밀번호</div>
                        <div class="col2"><input type="password" name="pass" value="<?=$pass?>"></div>
                    </div>
                    <div class="clear"></div>
                    <div class="form">
                        <div class="col1">비밀번호 확인</div>
                        <div class="col2"><input type="password" name="pass_confirm" value="<?=$pass?>"></div>
                    </div>
                    <div class="clear"></div>
                    <div class="form">
                        <div class="col1">이름</div>
                        <div class="col2"><input type="text" name="name" value="<?=$username?>"></div>
                    </div>
                    <div class="form">
                        <div class="col1">전화번호</div>
                        <div class="col2"><input type="text" name="phnum" value="<?=$phnum?>"></div>
                    </div>
                    <div class="clear"></div>
                    <div class="form email">
                        <div class="col1">이메일</div>
                        <div class="col2">
                            <input type="text" name="email1" value="<?=$email1?>">@<input type="text" name="email2" value="<?=$email2?>">
                        </div>
                    </div>
                    <div class="clear"></div>
                    <!-- input요소의 submit, reset으로 만들면 이미지로 못 만듬 -->
                    <!-- input요소의 타입 중 image 타입으로 하면 이미지 버튼이면서 submit 기능 -->
                    <!-- 값을 전송할 때 값이 비어있는지 검증하는 작업도 하고 싶어서.. -->
                    <!-- Javascript를 이용해서 submit()해보기 -->
                    <div class="bottom_line"></div>
                    <div class="buttons">
                        <img src="../img/button_save.gif" style="cursor:pointer" onclick="submitForm()">&nbsp;
                        <img src="../img/button_reset.gif" style="cursor:pointer" onclick="resetForm()">
                    </div>
                </form>
            </div>

        </div>
    </section>

     <!-- Footer-->
    <footer class="py-5 bg-warning">
        <div class="container"><p class="m-0 text-center text-black">Copyright &copy; Your Website 2022</p></div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
        
</body>
</html>