const form = document.querySelector(".typing-area"),
  incoming_id = form.querySelector(".incoming_id").value,
  inputField = form.querySelector(".input-field"),
  sendBtn = form.querySelector("button"),
  chatBox = document.querySelector(".chat-box");

form.onsubmit = (e) => {
  e.preventDefault();
};

function scrollToBottom() {
  chatBox.scrollTop = chatBox.scrollHeight;
}

inputField.focus();
inputField.onkeyup = () => {
  if (inputField.value != "") {
    sendBtn.classList.add("active");
  } else {
    sendBtn.classList.remove("active");
  }
};

// sendBtn.onclick = () => {
//   let xhr = new XMLHttpRequest();
//   xhr.open("POST", "core/insert-chatgr.php", true);
//   xhr.onload = () => {
//     if (xhr.readyState === XMLHttpRequest.DONE) {
//       if (xhr.status === 200) {
//         inputField.value = "";
//         scrollToBottom();
//       }
//     }
//   };
//   let formData = new FormData(form);
//   xhr.send(formData);
// };

sendBtn.onclick = async () => {
  try {
    const formData = new FormData(form);
    const response = await fetch("core/insert-chatgr.php", {
      method: "POST",
      body: formData,
    });
    
    if (response.ok) {
      inputField.value = "";
      scrollToBottom();
    }
  } catch (error) {
    console.error("Request failed:", error);
  }
};


chatBox.onmouseenter = () => {
  chatBox.classList.add("active");
};

chatBox.onmouseleave = () => {
  chatBox.classList.remove("active");
};

// setInterval(() => {
//   let xhr = new XMLHttpRequest();
//   xhr.open("POST", "core/get-chatgr.php", true);
//   xhr.onload = () => {
//     if (xhr.readyState === XMLHttpRequest.DONE) {
//       if (xhr.status === 200) {
//         let data = xhr.response;
//         chatBox.innerHTML = data;
//         if (!chatBox.classList.contains("active")) {
//           scrollToBottom();
//         }
//       }
//     }
//   };
//   xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//   xhr.send("incoming_id=" + incoming_id);
// }, 500);

function fetchChat() {
  fetch("core/get-chatgr.php", {
    method: "POST",
    headers: {
      "Content-type": "application/x-www-form-urlencoded",
    },
    body: "incoming_id=" + incoming_id,
  })
    .then((response) => {
      if (response.ok) {
        return response.text();
      } else {
        throw new Error("Request failed with status: " + response.status);
      }
    })
    .then((data) => {
      chatBox.innerHTML = data;
      if (!chatBox.classList.contains("active")) {
        scrollToBottom();
      }
    })
    .catch((error) => {
      console.error("Request failed:", error);
    });
}

setInterval(fetchChat, 500);

