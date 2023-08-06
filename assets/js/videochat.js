let APP_ID = "ce05dc9fa9d149eaaabfe3601d7d7770";

let peerConnection;
let localStream;
let remoteStream;

let uid = document.getElementById("myId").value;
let idroom = document.getElementById("idcall").value;
let token = null;
let client = null;
let channel = null;
let isScreenSharing = false;

//máy chủ ICE (Interactive Connectivity Establishment) để tìm kiếm đường dẫn truyền thông
//tốt nhất giữa các thiết bị kết nối.
let servers = {
  iceServers: [
    {
      //máy chủ STUN (Session Traversal Utilities for NAT) được sử dụng để xác định địa chỉ IP
      //và cổng của một thiết bị đằng sau một máy chủ NAT (Network Address Translation)
      urls: ["stun:stun1.1.google.com:19302", "stun:stun2.1.google.com:19302"],
    },
  ],
};

let init = async () => {
  client = await AgoraRTM.createInstance(APP_ID);
  await client.login({ uid, token });

  const channel = client.createChannel(idroom);
  channel.join();

  channel.on("MemberJoined", handlePeerJoined);
  client.on("MessageFromPeer", handleMessageFromPeer);

  localStream = await navigator.mediaDevices.getUserMedia({
    video: true,
    audio: false,
  });
  document.getElementById("user-1").srcObject = localStream;
};

let handlePeerJoined = async (MemberId) => {
  console.log("A new peer has joined this room:", MemberId);
  createOffer(MemberId);
};

let handleMessageFromPeer = async (message, MemberId) => {
  message = JSON.parse(message.text);
  console.log("Message:", message.type);

  if (message.type === "offer") {
    if (!localStream) {
      localStream = await navigator.mediaDevices.getUserMedia({
        video: true,
        audio: false,
      });
      document.getElementById("user-1").srcObject = localStream;
    }

    document.getElementById("offer-sdp").value = JSON.stringify(message.offer);
    createAnswer(MemberId);
  }

  if (message.type === "answer") {
    document.getElementById("answer-sdp").value = JSON.stringify(
      message.answer
    );
    addAnswer();
  }

  if (message.type === "candidate") {
    if (peerConnection) {
      peerConnection.addIceCandidate(message.candidate);
    }
  }
};

let createPeerConnection = async (sdpType, MemberId) => {
  peerConnection = new RTCPeerConnection(servers);

  remoteStream = new MediaStream();

  document.getElementById("user-2").srcObject = remoteStream;

  localStream.getTracks().forEach((track) => {
    peerConnection.addTrack(track, localStream);
  });

  peerConnection.ontrack = async (event) => {
    event.streams[0].getTracks().forEach((track) => {
      remoteStream.addTrack(track);
    });
  };

  peerConnection.onicecandidate = async (event) => {
    if (event.candidate) {
      document.getElementById(sdpType).value = JSON.stringify(
        peerConnection.localDescription
      );
      client.sendMessageToPeer(
        {
          text: JSON.stringify({
            type: "candidate",
            candidate: event.candidate,
          }),
        },
        MemberId
      );
    }
  };
};
//tạo offer
let createOffer = async (MemberId) => {
  createPeerConnection("offer-sdp", MemberId);

  let offer = await peerConnection.createOffer();
  await peerConnection.setLocalDescription(offer);

  document.getElementById("offer-sdp").value = JSON.stringify(offer);
  client.sendMessageToPeer(
    { text: JSON.stringify({ type: "offer", offer: offer }) },
    MemberId
  );
};
//tạo answer
let createAnswer = async (MemberId) => {
  createPeerConnection("answer-sdp", MemberId);

  let offer = document.getElementById("offer-sdp").value;
  if (!offer) return alert("Retrieve offer from peer first...");

  offer = JSON.parse(offer);
  await peerConnection.setRemoteDescription(offer);

  let answer = await peerConnection.createAnswer();
  await peerConnection.setLocalDescription(answer);

  document.getElementById("answer-sdp").value = JSON.stringify(answer);
  client.sendMessageToPeer(
    { text: JSON.stringify({ type: "answer", answer: answer }) },
    MemberId
  );
};

let addAnswer = async () => {
  let answer = document.getElementById("answer-sdp").value;
  if (!answer) return alert("Retrieve answer from peer first...");

  answer = JSON.parse(answer);

  if (!peerConnection.currentRemoteDescription) {
    peerConnection.setRemoteDescription(answer);
  }
};

async function startScreenSharing() {
  try {

    if (!isScreenSharing) {
      screenStream = await navigator.mediaDevices.getDisplayMedia({
        video: true,
        audio: false,
      });

      // Hiển thị stream màn hình lên giao diện người dùng
      document.getElementById("user-1").srcObject = screenStream;
      
      // Dừng stream video từ camera (nếu có)
      // localStream.getVideoTracks().forEach((track) => {
      //   track.enabled = false;
      // });

      // Thêm track video từ màn hình chia sẻ vào localStream
      screenStream.getTracks().forEach((track) => {
        localStream.addTrack(track);
      });

      // Cập nhật trạng thái chia sẻ màn hình
      isScreenSharing = true;
    }
  } catch (error) {
    console.error("Error starting screen sharing:", error);
  }
}

async function returnToVideoCall() {
  // Dừng chia sẻ màn hình nếu đang chia sẻ
  if (isScreenSharing) {
    //localStream.getTracks().forEach((track) => track.stop());
    localStream = await navigator.mediaDevices.getUserMedia({
      video: true,
      audio: false,
    });
    document.getElementById("user-1").srcObject = localStream;
    isScreenSharing = false;
  }
}

$("#myBtn").click(() => {
  init();
});

$("#share").click(() => {
  if (!isScreenSharing) {
    startScreenSharing();
  } else {
    returnToVideoCall();
  }
});

$("#close").click(async () => {
  if (localStream) {
    await localStream.getTracks().forEach((track) => {
      track.stop();
    });
    localStream = null;
  }

  if (remoteStream) {
    await remoteStream.getTracks().forEach((track) => {
      track.stop();
    });
    remoteStream = null;
  }

  if (peerConnection) {
    await peerConnection.close();
    peerConnection = null;
  }

  if (channel) {
    await channel.leave();
    channel = null;
  }

  if (client) {
    await client.logout();
    client = null;
  }
});
