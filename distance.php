<?php
include "./lib/dbconn.php";
session_start();
if( isset($_SESSION['lat'])|| isset($_SESSION['lat'])){
    $lat=$_SESSION['lat'];
    $lng=$_SESSION['lng'];
}
else{
$apiKey = 'AIzaSyAgknUPj1dae6P2qe5Z7FNuxTn7sinn5_4'; // 발급받은 API 키
$url = 'https://www.googleapis.com/geolocation/v1/geolocate?key=' . $apiKey;
$data = array('considerIp' => 'true'); // API 요청 데이터
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

$result2 = curl_exec($ch); // API 응답 받아오기

curl_close($ch);

$response = json_decode($result2, true); // JSON 데이터 파싱

$lat = $response['location']['lat']; // 현재 위치 위도
$lng = $response['location']['lng']; // 현재 위치 경도
}
// 쿼리문
$sql= "SELECT *, (6371 * acos(cos(radians($lat)) * cos(radians(lat)) * cos(radians(lng) - radians($lng)) + sin(radians($lat)) * sin(radians(lat)))) AS distance
FROM food ORDER BY distance ASC";
$result= mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<?php 
    //로그인을 하면 session에 정보를 저장하고 각 페이지들에서 모두 사용하고자 함.
    //로그인에 띠라 화면구성이 다르기에 세션에 저장되어 있는 회원정보 중 id, name, level 값 읽어오기
     //세션을 저장하든 읽어오든 사용하고자 하면 이 함수로 시작

    $userid="";
    $username="";
    $userlevel=""; //회원등급 : 1~9등급 [1등급:관리자, 9등급:신규회원]  
    $userpoint="";
    
    if( isset($_SESSION['userid'])) $userid= $_SESSION['userid'];
    if( isset($_SESSION['username'])) $username= $_SESSION['username'];
    if( isset($_SESSION['userlevel'])) $userlevel= $_SESSION['userlevel'];
    if( isset($_SESSION['userphnum'])) $userphnum= $_SESSION['userphnum'];
    if( isset($_SESSION['lat'])) $userlat=$_SESSION['lat'];
?>
<html lang="ko">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>baegopa</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="./css/styles.css" rel="stylesheet" />
        <link href="./css/search.css" rel="stylesheet" />
        <link href="./css/main2.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand fw-bolder" href="#!">BGS</a>
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
        <!-- Header-->
        <header class="bg-warning py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-black">
                <fieldset class="main-search">
                <form method='post' action='./search/search3.php' name='search'>
                    <legend>전체 검색</legend>
                    <label class="search-word" for="main-search">
                        <span class="search-icon">검색 :</span>
                        <input id="main-search" class="HomeSearchInput" name="main-search" type="text" maxlength="50" placeholder="지역, 식당 또는 음식"/>
                    </label>
                    <input class="btn-search" type="submit" value="검색" />
                </form>    
                </fieldset>
                </div>
            </div>
        </header>
        <div class="category_fillter_box">
      <div class="swiper_container">
        <ul class="swiper_wrap">
          <li class="swiper_slide">
            <a class="btn_fillter">
              <span>필터</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="layer_wrap">
      <div class="Modal"></div>
      <div class="layer_filter_box">
        <div class="layer_header">
          <h2>필터</h2>
        </div>
        <div class="layer_area_cont">
          <div class="area_cont1">
            <div class="layer_header1">
              <h2>지역 선택</h2>
            </div>
            <div class="area_box">
              <div class="area_list">
                <ul>
                  <li class="area_list1">
                    <a href="#">
                      <span>내위치</span>
                    </a>
                  </li>
                  <li class="area_list1">
                    <a href="./index_area.php?area=서울&&sort=추천순">
                      <span>서울</span>
                    </a>
                  </li>
                  <li class="area_list1">
                    <a href="./index_area.php?area=경기도&&sort=추천순">
                      <span>경기도</span>
                    </a>
                  </li>
                  <li class="area_list1">
                    <a href="./index_area.php?area=강원도&&sort=추천순">
                      <span>강원도</span>
                    </a>
                  </li>
                  <li class="area_list1">
                    <a href="./index_area.php?area=경상도&&sort=추천순">
                      <span>경상도</span>
                    </a>
                  </li>
                  <li class="area_list1">
                    <a href="./index_area.php?area=전라도&&sort=추천순">
                      <span>전라도</span>
                    </a>
                  </li>
                  <li class="area_list1">
                    <a href="./index_area.php?area=충청남도&&sort=추천순">
                      <span>충청남도</span>
                    </a>
                  </li>
                  <li class="area_list1">
                    <a href="./index_area.php?area=충청북도&&sort=추천순">
                      <span>충청북도</span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="layer_header1">
              <h2>정렬</h2>
            </div>
            <div class="filter_box">
              <div class="filter_list">
                <ul>
                  <li class="filter_list1">
                    <a href="./index.php">
                      <span>추천순</span>
                    </a>
                  </li>
                  <li class="filter_list1">
                    <a href="./joayo/joayo.php?sort=좋아요순">
                      <span>좋아요순</span>
                    </a>
                  </li>
                  <li class="filter_list1">
                    <a href="./views/views.php?sort=조회순">
                      <span>조회순</span>
                    </a>
                  </li>
                  <li class="filter_list1">
                    <a href="./star/star.php?sort=인기순">
                      <span>인기순</span>
                    </a>
                  </li>
                  <li class="filter_list1">
                    <a href="./distance.php?sort=거리순">
                      <span>거리순</span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <a href="#" class="btn_layer_close"> </a>
      </div>
    </div>   
        <section class="py-5"> 
            <div class="container px-2 px-lg-3 mt-6">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php
                    while ($row = $result -> fetch_assoc()){
                        $renum=$row['num'];
                        $sql2="SELECT AVG(star_rate) from review where id='$renum'";
                        $result2= mysqli_query($conn,$sql2);
                        $row2=$result2->fetch_assoc();
                        $avg_math = $row2['AVG(star_rate)'];
                        $avg_math_formatted = number_format($avg_math, 1);  
                        $rating=$avg_math_formatted;           
                    ?> 
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="./fimg/<?=$row['image']?>" alt="..." />
                            <!-- Product details -->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder"><?=$row['name']?></h5>
                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                    <?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $rating) {
                                                echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                            </svg>';
                                            } elseif ($i == ceil($rating) && $rating != floor($rating)) {
                                                echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-half" viewBox="0 0 16 16">
                                                <path d="M5.354 5.119 7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.537.537 0 0 1 16 6.32a.548.548 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.52.52 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.58.58 0 0 1 .085-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.565.565 0 0 1 .162-.505l2.907-2.77-4.052-.576a.525.525 0 0 1-.393-.288L8.001 2.223 8 2.226v9.8z"/>
                                            </svg>';
                                            } else {
                                                echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                                            </svg>';
                                            }
                                        }
                                    ?>   
                                    </div>
                                    <!-- Product price-->
                                    <?=$row['area_do']?> <?=$row['area_si']?>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="./count.php?no=<?= $row['num']?>">더보기</a></div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
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
        <script src="js/index.js"></script>
    </body>
</html>