<?php 
    //로그인을 하면 session에 정보를 저장하고 각 페이지들에서 모두 사용하고자 함.
    //로그인에 띠라 화면구성이 다르기에 세션에 저장되어 있는 회원정보 중 id, name, level 값 읽어오기
    session_start(); //세션을 저장하든 읽어오든 사용하고자 하면 이 함수로 시작

    $userid="";
    $username="";
    $userlevel=""; //회원등급 : 1~9등급 [1등급:관리자, 9등급:신규회원]
    $userpoint="";

    if( isset($_SESSION['userid'])) $userid= $_SESSION['userid'];
    if( isset($_SESSION['username'])) $username= $_SESSION['username'];
    if( isset($_SESSION['userlevel'])) $userlevel= $_SESSION['userlevel'];
    if( isset($_SESSION['userpoint'])) $userpoint= $_SESSION['userpoint'];

?>

<!-- 헤더 영역의 로고와 회원가입/로그인 표시 영역 -->
        <div id="top">
            <!-- 1. 로고영역 -->
            <!-- include되면 삽입된 문서의 위치를 기준으로 -->
            <h3><a href="../index.php">배고파</a></h3> 

            <!-- 2. 회원가입/로그인 버튼 표시 영역 -->
            <ul id="top_menu">
                <!-- 로그인 안되었을 때 -->
                <?php if(!$userid){  ?>
                    <li><a href="../member/member_form.php">회원가입</a></li>
                    <li> | </li>
                    <li><a href="../login/login_form.php">로그인</a></li>
                <?php }else{ ?>
                    <li><a href="../login/logout.php">로그아웃</a></li>
                    <li> | </li>
                    <li><a href="../login/member_modify_form.php">정보수정</a></li>
                <?php }?>

                <!-- 관리자모드로 로그인되었을 때 추가로.. -->
                <?php if($userlevel==1){?>
                    <li> | </li>
                    <li><a href="../admin/admin.php">관리자모드</a></li>
                <?php } ?>
            </ul>
        </div>

        <!-- 헤더 영역의 네비게이션 메뉴 영역 -->
        <div id="menu_bar">
            <ul>
                <li><a href="../index.php">HOME</a></li>
                <li><a href="../message/message_form.php">쪽지</a></li>
                <li><a href="../board/board_list.php">게시판</a></li>
                <li><a href="../index.php">사이트완성</a></li>
            </ul>
        </div>