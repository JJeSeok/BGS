var textarea = document.querySelector('.ReviewEditor_write');
var charCount = document.querySelector('.ReviewEditor_TextLength');
var maxChars = 10000;

textarea.addEventListener('input', function () {
  var text = textarea.value;
  var count = text.length;
  charCount.textContent = count;

  this.style.height = '150px';
  this.style.height = this.scrollHeight + 'px';

  if (count > maxChars) {
    textarea.value = text.substring(0, maxChars);
    charCount.textContent = maxChars;
  }
});

var fileButton = document.querySelector('.ReviewPictureContainer_AddButton');
var pictureList = document.querySelector('.ReviewPictureContainer_pictureList');
var picture_counter = document.querySelector('.ReviewPictureCounter');
const pictureSize = 98;
const Counter_top = 93;
const Counter_left = 89;

fileButton.addEventListener("click", function() {
  var inputElement = document.createElement("input");
  inputElement.type = "file";
  inputElement.name = "image[]";
  inputElement.classList.add("ReviewPictureContainer_pictureItem");
  inputElement.classList.add("picture-input");
  inputElement.accept = "image/*";
  inputElement.style.display = "none";
  pictureList.appendChild(inputElement);
  inputElement.click();
});

pictureList.addEventListener('change', function (event) {
  var inputElement = event.target;
  var fileList = inputElement.files;

  var file = fileList[0];
  var reader = new FileReader();
  reader.onload = function (event) {
    var imageURL = event.target.result;
    var imageElement = document.createElement('div');
    picture_create(imageElement);
    imageElement.style.backgroundImage = `url(${imageURL})`;
    imageElement.classList.add('ReviewPictureContainer_PreviewImage');

    var listItem = document.createElement('li');
    listItem.classList.add('ReviewPictureContainer_pictureItem');
    listItem.classList.add('pictureItem_picture');
    listItem.appendChild(imageElement);
    addRemoveButton(listItem, inputElement);
    pictureList.appendChild(listItem);

    picture_sort();
  };

  reader.readAsDataURL(file);
});

let deletedImages = [];

function addRemoveButton(item,inputElement) {
  var removeButton = item.querySelector('.picture_removeButton');
  removeButton.addEventListener('click', function () {
    let imageElement = item.querySelector(
      '.ReviewPictureContainer_PreviewImage'
    );
    let backgroundImg = imageElement.style.backgroundImage;
    let imgResult = /url\(.*\/(.*?)["']?\)/.exec(backgroundImg);
    if (imgResult && imgResult[1] && !deletedImages.includes(imgResult[1])) {
      deletedImages.push(imgResult[1]);
    }

    if (inputElement && inputElement.parentNode) {
      inputElement.parentNode.removeChild(inputElement);
    }
    item.remove();
    picture_sort();
  });
}

function picture_sort() {
  var pictureItem_button = document.querySelector('.pictureItem_button');
  var pictureItem_picture = document.getElementsByClassName(
    'pictureItem_picture'
  );
  var pictureCount = document.querySelector('.ReviewPictureCounter_Length');
  var maxPicture = 30;
  var count = pictureItem_picture.length;

  var x = 0;
  var y = 0;
  for (var i = 0; i < count; i++) {
    if (x > 588) {
      y += pictureSize;
      x = 0;
    }

    pictureItem_picture[i].style.transform = `translate(${x}px, ${y}px)`;
    x += pictureSize;
  }

  if (x > 588) {
    y += pictureSize;
    x = 0;

    pictureItem_button.style.transform = `translate(${x}px, ${y}px)`;
    picture_counter.style.left = `${x + Counter_left}px`;
    picture_counter.style.top = `${y + Counter_top}px`;
    pictureCount.textContent = count;
  } else {
    if (count < maxPicture) {
      pictureItem_button.style.transform = `translate(${x}px, ${y}px)`;
      picture_counter.style.left = `${x + Counter_left}px`;
      picture_counter.style.top = `${y + Counter_top}px`;
      pictureItem_button.style.display = 'block';
    } else {
      pictureItem_button.style.display = 'none';
      picture_counter.style.left = `${x - pictureSize + Counter_left}px`;
      picture_counter.style.top = `${y + Counter_top}px`;
    }
    pictureCount.textContent = count;
  }

  pictureList.style.height = y + pictureSize + 'px';

  var pictureItems = document.querySelectorAll('.pictureItem_picture');
  pictureItems.forEach(function (item) {
    addRemoveButton(item);
  });
}

function picture_create(imageElement) {
  var pictureLayer = document.createElement('div');
  pictureLayer.classList.add('picture_Layer');
  imageElement.appendChild(pictureLayer);

  var removeButton = document.createElement('button');
  removeButton.classList.add('picture_removeButton');
  pictureLayer.appendChild(removeButton);

  var removeIcon = document.createElement('i');
  removeIcon.classList.add('picture_removeIcon');
  removeButton.appendChild(removeIcon);

  var extendButton = document.createElement('button');
  extendButton.classList.add('picture_extendButton');
  pictureLayer.appendChild(extendButton);

  var extendIcon = document.createElement('i');
  extendIcon.classList.add('picture_extendIcon');
  extendButton.appendChild(extendIcon);

  return imageElement;
}

document.addEventListener('DOMContentLoaded', function () {
  // URL에서 'reviewId' 쿼리 파라미터를 추출합니다.
  let urlParams = new URLSearchParams(window.location.search);
  let reviewId = urlParams.get('id');

  // reviewId가 있을 경우 AJAX 요청을 실행합니다.
  if (reviewId) {
    fetch('../review/get_image.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: 'reviewId=' + encodeURIComponent(reviewId),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json(); // JSON 형태로 파싱합니다.
      })
      .then((data) => {
        // 받아온 데이터를 처리하여 페이지에 채웁니다.
        // 이미지 URL이 있다면 이미지를 페이지에 표시합니다.
        if (data.image) {
          for (let i = 0; i < data.image.length; i++) {
            var imageElement = document.createElement('div');
            picture_create(imageElement);
            imageElement.style.backgroundImage = `url('../review/image/${data.image[i]}')`;
            imageElement.classList.add('ReviewPictureContainer_PreviewImage');

            var listItem = document.createElement('li');
            listItem.classList.add('ReviewPictureContainer_pictureItem');
            listItem.classList.add('pictureItem_picture');
            listItem.appendChild(imageElement);
            pictureList.appendChild(listItem);
  
            picture_sort();
          }
        }
      })
      .catch((error) => {
        console.error(
          'There has been a problem with your fetch operation:',
          error
        );
      });
  }
});

document.querySelector('.ReviewWritingPage_SubmitButton').addEventListener('click', function() {
  let formData = new FormData();

  deletedImages.forEach(function(filename) {
    formData.append('deletedImages[]', filename);
  });
  for (var pair of formData.entries()) {
    console.log(pair[0] + ', ' + pair[1]);
  }

  fetch('../review/delete_image.php', {
    method: 'POST',
    body: formData
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
  })
  .then(data => {
    // 서버 응답 처리...
    console.log(data);
  })
  .catch(error => {
    console.error('Error during fetch:', error);
  });
});
