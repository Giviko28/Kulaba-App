function updateImg(id) {
   const mainImg = document.querySelector('#mainImg');
   const image = document.querySelector("#img" + id).getAttribute("src");
   mainImg.src = image;
}