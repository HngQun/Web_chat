const form = document.querySelector(".typing-area"),
  incoming_id = form.querySelector(".incoming_id").value,
  inputField = form.querySelector(".input-field"),
  sendBtn = form.querySelector("button"),
  chatBox = document.querySelector(".chat-box"),
  form2 = document.querySelector(".chat_img");

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

sendBtn.onclick = async () => {
  try {
    const formData = new FormData(form);
    const response = await fetch("core/insert-chat.php", {
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

function fetchChat() {
  fetch("core/get-chat.php", {
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
