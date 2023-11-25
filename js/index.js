let layer_wrap = document.querySelector('.layer_wrap');
let Modal = document.querySelector('.Modal');
let closeButton = document.querySelector('.btn_layer_close');

document.querySelector('.btn_fillter').addEventListener('click', function () {
  layer_wrap.style.display = 'block';
  Modal.style.display = 'block';
});

document
  .querySelector('.btn_layer_close')
  .addEventListener('click', function () {
    layer_wrap.style.display = 'none';
    Modal.style.display = 'none';
  });

document.addEventListener('click', (event) => {
  if (event.target == Modal) {
    layer_wrap.style.display = 'none';
    Modal.style.display = 'none';
  }
});

let area_list = document.querySelectorAll('.area_list1');
let filter_list = document.querySelectorAll('.filter_list1');

for (let i = 0; i < area_list.length; i++) {
  area_list[i].addEventListener('click', function () {
    for (let j = 0; j < area_list.length; j++) {
      area_list[j].classList.remove('on');
    }
    this.classList.add('on');

    if (i === 0) {
      filter_list[4].style.display = 'block';
    } else {
      filter_list[4].style.display = 'none';
    }
  });
}

for (let i = 0; i < filter_list.length; i++) {
  filter_list[i].addEventListener('click', function () {
    for (let j = 0; j < filter_list.length; j++) {
      filter_list[j].classList.remove('on');
    }
    this.classList.add('on');
  });
}

document.addEventListener('DOMContentLoaded', function () {
  // URL에서 쿼리 스트링을 파싱하는 함수
  function getQueryStringParams(query = window.location.search) {
    return new URLSearchParams(query);
  }

  const params = getQueryStringParams();
  const selectedArea = params.get('area');
  const selectedSort = params.get('sort');

  let spanText_area = Array.from(document.querySelectorAll('.area_list1 span')).map(span => span.textContent);
  let spanText_filter = Array.from(document.querySelectorAll('.filter_list1 span')).map(span => span.textContent);

  // 선택된 필터에 'on' 클래스 적용
  if (selectedArea) {
    for (let i = 0; i < spanText_area.length; i++) {
      if (spanText_area[i] === selectedArea) {
        area_list[i].click();
      }
    }
  } else {
    area_list[0].click();
  }

  if (selectedSort) {
    for (let i = 0; i < spanText_filter.length; i++) {
      if (spanText_filter[i] === selectedSort) {
        filter_list[i].click();
      }
    }
  } else {
    filter_list[0].click();
  }
});

const searchInput = document.querySelector('.HomeSearchInput');
const searchRecently = document.querySelector('.search-recently');

searchInput.addEventListener('click', function () {
  searchRecently.style.display = 'block';
});

document.addEventListener('click', (event) => {
  if (event.target === searchInput || event.target === searchRecently) {
    return;
  }

  if (searchRecently.style.display === 'block') {
    searchRecently.style.display = 'none';
  }
});