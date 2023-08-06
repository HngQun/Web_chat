// var paragraphs = document.getElementsByTagName("p");

// function toggleMessage(details) {
//   for (var i = 0; i < paragraphs.length; i++) {
//     paragraphs[i].addEventListener("click", function () {
//       // Lấy ID của phần tử <p> được click
//       var clickedParagraphId = this.id;
//       console.log(clickedParagraphId);
//       let xhr = new XMLHttpRequest();
//       xhr.open("POST", "core/hide.php", true);
//       xhr.send("id="+clickedParagraphId);
//     });
//   }
// }

var paragraphs = document.getElementsByTagName("p");

function toggleMessage(details) {
  for (var i = 0; i < paragraphs.length; i++) {
    paragraphs[i].addEventListener("click", function () {
      // Lấy ID của phần tử <p> được click
      var clickedParagraphId = this.id;
      console.log(clickedParagraphId);
      
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "core/hide.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // Thiết lập tiêu đề "Content-Type"
      xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
          // Xử lý phản hồi từ máy chủ
          console.log(xhr.responseText);
        }
      };
      xhr.send("id=" + encodeURIComponent(clickedParagraphId)); // Sử dụng cú pháp query string
      
    });
  }
}


