var textarea = document.querySelector('.ReviewEditor_write');
var charCount = document.querySelector('.ReviewEditor_TextLength');
var maxChars = 10000;

textarea.addEventListener("input", function() {
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

pictureList.addEventListener("change", function(event) {
  var inputElement = event.target;
  var fileList = inputElement.files;

  var file = fileList[0];
  var reader = new FileReader();
  reader.onload = function(event) {
    var imageURL = event.target.result;
    var imageElement = document.createElement("div");
    picture_create(imageElement);
    imageElement.style.backgroundImage = `url(${imageURL})`;
    imageElement.classList.add("ReviewPictureContainer_PreviewImage");

    var listItem = document.createElement("li");
    listItem.classList.add("ReviewPictureContainer_pictureItem");
    listItem.classList.add("pictureItem_picture");
    listItem.appendChild(imageElement);
    pictureList.appendChild(listItem);
    
    picture_sort();
  };

  reader.readAsDataURL(file);
});

function picture_sort() {
  var pictureItem_button = document.querySelector('.pictureItem_button');
  var pictureItem_picture = document.getElementsByClassName('pictureItem_picture');
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
      pictureItem_button.style.display = "block";
    } else {
      pictureItem_button.style.display = "none";
      picture_counter.style.left = `${x - pictureSize + Counter_left}px`;
      picture_counter.style.top = `${y + Counter_top}px`;
    }
    pictureCount.textContent = count;
  }

  pictureList.style.height = y + pictureSize + 'px';

  var pictureItems = document.querySelectorAll('.pictureItem_picture');
  var inputElement = document.getElementsByClassName('picture-input');
  
  pictureItems.forEach(function(item) {
    var removeButton = item.querySelector('.picture_removeButton');
    var inputItem;
    for (var i = 0; i < pictureItems.length; i++) {
      if (pictureItems[i] == item) {
        inputItem = inputElement[i];
      }
    }
    removeButton.addEventListener('click', function() {
      item.remove();
      inputItem.remove();
      picture_sort();
    });
  });
}

function picture_create(imageElement) {
  var pictureLayer = document.createElement("div");
  pictureLayer.classList.add("picture_Layer");
  imageElement.appendChild(pictureLayer);

  var removeButton = document.createElement("button");
  removeButton.type="button";
  removeButton.classList.add("picture_removeButton");
  pictureLayer.appendChild(removeButton);

  var removeIcon = document.createElement("i");
  removeIcon.type="icon";
  removeIcon.classList.add("picture_removeIcon");
  removeButton.appendChild(removeIcon);

  var extendButton = document.createElement("button");
  extendButton.type="button";
  extendButton.classList.add("picture_extendButton");
  pictureLayer.appendChild(extendButton);

  var extendIcon = document.createElement("i");
  extendButton.type="icon";
  extendIcon.classList.add("picture_extendIcon");
  extendButton.appendChild(extendIcon);

  return imageElement;
}
