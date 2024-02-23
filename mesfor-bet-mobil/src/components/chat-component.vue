<template>
  <div class="chat-page" ref="pageRef">
    <header class="chat-header fjsbac safari">
      <img src="@/assets/img/user-shield.webp" alt="" class="chat-title-icon">
      <img src="@/assets/img/return.webp" v-if="selectedUser" class="menu-icons cp" @click="setUserList()"/>
      <img src="@/assets/img/trash-gray.webp" v-if="selectedUser" @click="deleteAllMessages()" class="close cp" alt="">
      <img src="@/assets/img/close.webp" alt="" title="Kapat" @click="closeChat()" class="close">
    </header>
    <div v-if="userList" class="chat-user-scroll">
      <div v-for="(list, index) in chatUsers" :key="index" class="chat-user-list"
        @click="updateMsg(list.user, list.count)">
        <img src="@/assets/img/user-shield-red.webp" alt="" v-if="list.logincheck == 'active'" class="chat-user-icons">
        <img src="@/assets/img/user-shield-green.webp" alt="" v-else class="chat-user-icons">
        <span class="chat-list-title">{{ list.user }}</span>
        <span v-for="(chatcounter, index) in list.count" :key="index">
          <span v-if="chatcounter.count" class="badge chat-count">{{ chatcounter.count }}</span>
        </span>
      </div>
    </div>
     <div v-else class="chat-side">
       <ul id="chatarea" class="chat-area">
         <li v-for="(list,index) in msgHistory" :key="list.id" class="chat-list" @dblclick="deleteMsg(list, index)">
          <div class="chat-list-class" :class="{
            senderClass: list.sender === $store.state.auth.user, readstateClass: list.readed === 'yes' && list.sender === $store.state.auth.user, imageClass: list.type == 'image'
          }">
             <audio v-if="list.type == 'audio'" class="recordSender" controls style="height:30px;width:180px;">
               <source :src="`uploads/${list.msg}`" type="audio/webm">
             </audio>
             <img v-if="list.type == 'image'" :src="`uploads/${list.msg}`" alt="" class="imgMsg">
             <span v-if="list.type == 'text'" class="chat-text">{{ list.msg }}</span>
             <span class="chat-date">{{ moment(list.date).format('MM-DD HH:MM:s') }}</span>
           </div>
         </li>
         <li v-for="list in currentMessage" :key="list.id" class="chat-list">
          <div class="chat-list-class"
          :class="{ senderClass: list.sender === $store.state.auth.user, imageClass: list.type == 'image' }">
             <audio v-if="list.type == 'audio'" class="record" controls style="height:30px;width:180px;">
               <source :src="`uploads/${list.message}`" type="audio/webm">
             </audio>
             <img v-if="list.type == 'image'" :src="`uploads/${list.message}`" alt="" class="imgMsg" />
             <span v-if="list.type == 'text'" class="chat-text">{{ list.message }}</span>
             <span class="chat-date">{{ moment(list.date).format('MM-DD HH:MM:s') }}</span>
             <span v-if="list.onlinestate" class="chatOnlinClass">&#10003;</span>
           </div>
         </li>
       </ul>
       <ul class="emoji-con" v-if="emojiHandle">
         <li v-for="emojilist in emoji" :key="emojilist.id" class="emoji-list">
           <span class="emoji" @click="addEmoji(emojilist.id)">{{
             emojilist.emoji
           }}</span>
         </li>
       </ul>
       <footer class="menu-3 fjsbac p5 bg-b chat-footer safari">
         <input ref="message" v-model="message" type="text" class="chat-input" :placeholder="typing" @keyup="showTyping()"
         @keyup.enter="sendMsg()" @blur="clearTyping()" autofocus />
          <button class="chat-btn cp cl-y" ref="chatBtn" @click="emojiOpen()">
            <span class="chat-emoji-icon cp">&#128578;</span>
          </button>
          
          <span class="dropdown mr10">
            <form @submit.prevent="sendImage()" enctype="multipart/form-data">
              <label for="img">
                <img src="@/assets/img/upload-cloud-yellow.webp" class="menu-icons cp" alt="">
                <input type="file" ref="img" id="img" accept="image/*" @change="selectImg($event)" style="display: none" />
              </label>
            </form>
          </span>
        <!-- <span class="dropdown mr10">
          <form @submit.prevent="sendAudio()" enctype="multipart/form-data">
            <span class="btn-upload logo-1" @mousedown="startAudio($event)" @mouseup="stopAudio($event)" @touchstart="startAudio($event)"
              @touchend="stopAudio($event)">
              <img src="@/assets/img/micro-green.webp" v-if="recordStart" class="menu-icons cp" alt="">
              <img src="@/assets/img/micro-red.webp" v-else class="menu-icons cp" alt="">
            </span>
          </form>
        </span> -->
       </footer>
     </div>
  </div>
</template>

<script>
import axios from "axios"
import { socket } from "@/socket"
export default {
  name: 'Chat',
  inject:['moment'],
  data() {
    return {
      chatUsers: {},
      userList: true,
      message: "",
      currentMessage: [],
      msgHistory: null,
      typing: "",
      selectedUser: '',
      emojiHandle: false,
      selectedImage: null,
      recordedAudio: null,
      type: 'text',
      timeout: '',
      recorder: '',
      recordStart: false,
      emoji: [
        { id: 0, emoji: "😃" },
        { id: 1, emoji: "😉" },
        { id: 2, emoji: "😊" },
        { id: 3, emoji: "🤑" },
        { id: 4, emoji: "😂" },
        { id: 5, emoji: "😪" },
        { id: 6, emoji: "😕" },
        { id: 7, emoji: "😟" },
        { id: 8, emoji: "😮" },
        { id: 9, emoji: "😲" },
        { id: 10, emoji: "😛" },
        { id: 11, emoji: "😜" },
        { id: 12, emoji: "😍" },
        { id: 13, emoji: "😘" },
        { id: 14, emoji: "💘" },
        { id: 15, emoji: "💋" },
        { id: 16, emoji: "💣" },
        { id: 17, emoji: "👍" },
        { id: 18, emoji: "👎" },
        { id: 19, emoji: "💪" },
        { id: 20, emoji: "✌️" },
        { id: 21, emoji: "🖐️" },
        { id: 22, emoji: "👀" },
        { id: 23, emoji: "⚽" },
        { id: 24, emoji: "🏀" },
        { id: 25, emoji: "⚾" },
        { id: 26, emoji: "🏐" },
      ]
    }
  },
  mounted() {
    socket.emit("activeusers", this.$store.state.auth.user);
    this.getChatUser()
    socket.on("new message", (data) => {
      this.typing = "";
      this.currentMessage.push({
        message: data.data.message,
        date: data.data.date,
        sender: data.data.sender,
        onlinestate: data.onlinestate,
        type: data.data.type
      });
      this.scrollToBottom();
    });
    this.checkBrowser()
  },
  methods: {
    checkBrowser(){
      // let isEdge = navigator.userAgent.indexOf('Edge') !== -1 && (!!navigator.msSaveOrOpenBlob || !!navigator.msSaveBlob);
      let isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
      if(isSafari){
        const handleScrollToTop = () => {
          window.scrollTo(0, 0);
        };
        const visualViewport = window.visualViewport;
        let offset = 0;

        if (visualViewport) {
        let viewportWidth = window.innerWidth;
        let viewportHeight = window.innerHeight;
        
        visualViewport.addEventListener("resize", (event) => {
          const $target = event.target;
          const $page = this.$refs.pageRef;
          
          if (viewportWidth !== $target.width) {
          viewportWidth = window.innerWidth;
          viewportHeight = window.innerHeight;
          }
          
          if (viewportHeight - $target.height > 150) {
          handleScrollToTop();
          const adjustment = viewportHeight - $target.height - offset;
          $page.style.bottom = `${adjustment}px`;
          } else if (
          viewportHeight === $target.height ||
          viewportHeight - $target.height <= 150
          ) {
          offset = viewportHeight - $target.height;
          if($page){
            $page.style.bottom = 0;
          }
          }
        });
        }

      document.addEventListener("touchend", handleScrollToTop);
      }
    },
    async getChatUser() {
      await axios.get('/api/chat').then((result) => {
        this.chatUsers = result.data.chatuser
      })
    },
    async updateMsg(sender, msgcount) {
      this.userList = false
      this.selectedUser = sender
      this.getMsg();
      this.scrollToBottom()
      socket.emit('selectedusers', this.selectedUser)
      if (msgcount) {
        //clear count of readed message on user list
        this.chatUsers.forEach(element => {
          if (element.user === sender) {
            element.count = ''
          }
        })
        await axios.put('/api/chat/msg-update', { sender:sender}).then((result) => {
          if(result.data.status == 200){
            this.$store.commit('setMsgCount', this.$store.state.msgcount - msgcount)
          }
        })
      }
    },
    async getMsg() {
      await axios.get(`/api/chat/get-chat-msg/${this.$store.state.auth.user}/${this.selectedUser}`).then((result) => {
        this.msgHistory = result.data.getmsg;
      })
    },
    async deleteAllMessages() {
      if (this.currentMessage != "" || this.msgHistory != "") {
        const cfm = confirm('Mesajlar kalıcı olarak silinecektir!')
        if (cfm) {
          await axios.post("/api/chat/msg-delete-all", {
            sender: this.$store.state.auth.user,
            receiver: this.selectedUser
          }).then(() => {
            this.currentMessage = [];
            this.msgHistory = "";
          })
        }
      } else {
        alert('Silinicek mesaj yoktur!')
      }
      this.$refs.message.focus()
    },
    async deleteMsg(data, index){
      await axios.post("/api/chat/msg-delete", {data:data}).then(result => {
        if(result.data == 'Deleted'){
          this.msgHistory.splice(index, 1)
        }
      })
    },
    async selectImg(event) {
      let file = event.target.files[0];
      const types = ['image/jpeg','image/jpg','image/webp','image/gif','image/webp']
      if (!types.includes(file.type)) {
        alert("Resim formata uygun degil! \n jpg/jpeg/webp/webp");
      } else if (file.size > 1000000) {//1 mgb
        alert("Resim boyutu çok yüksek!");
      } else {
        this.message = this.$store.state.auth.user + '-' + this.selectedUser + '-' + file.size + '.' + file.name.split('.').pop()
        this.selectedImage = file
        this.type = 'image'
        event.target.value = ''
      }
      this.$refs.message.focus();
      this.emojiHandle = false;
      this.$refs.chatBtn.disabled = true;
      this.$refs.message.focus()
    },
    async sendImage() {
      let fileName = this.$store.state.auth.user + '-' + this.selectedUser + '-' + this.selectedImage.size + '.' + this.selectedImage.name.split('.').pop()
      const form = new FormData()
      form.append('file', this.selectedImage, fileName)
      await axios.post('/api/chat/add-chat-image', form).then((result) => {
        this.messageEmit()
      })
    },
    async startAudio(event) {
      event.preventDefault();
      this.recordStart = true
      let device = navigator.mediaDevices.getUserMedia({ audio: true })
      let chunks = []
      device.then(stream => {
        this.recorder = new MediaRecorder(stream)
        this.recorder.ondataavailable = (e) => {
          chunks.push(e.data)
          if (this.recorder.state === 'inactive') {
            this.recordedAudio = new Blob(chunks, { type: 'audio/mp3' })
            this.message = this.$store.state.auth.user + '-' + this.selectedUser + '-' + this.recordedAudio.size + '.mp3'
            this.type = 'audio'
          }
        }
      })
      this.timeout = setTimeout(() => {
        this.recorder.start()
      }, 100)
      this.emojiHandle = false;
      this.$refs.chatBtn.in = true;
    },
    async sendAudio() {
      let fileName = this.$store.state.auth.user + '-' + this.selectedUser + '-' + this.recordedAudio.size + '.mp3'
      const form = new FormData()
      form.append('file', this.recordedAudio, fileName)
      await axios.post('/api/chat/add-chat-audio', form).then(() => {
        this.messageEmit()
      })
    },
    emojiOpen: function (e) {
      this.$refs.message.focus();
      this.emojiHandle = !this.emojiHandle;
    },
    addEmoji: function (id) {
      this.$refs.message.focus();
      this.message += this.emoji[id].emoji;
      this.emojiHandle = false;
    },
    setUserList() {
      this.userList = true
      this.selectedUser = ''
      this.currentMessage = []
    },
    closeChat() {
      this.$store.commit('setOpenChat', false)
      this.setUserList()
      socket.emit('closedusers', this.$store.state.auth.user)
    },
    stopAudio(event) {
      event.preventDefault();
      this.recordStart = false
      if (null != this.recorder) {
        try {
          if (this.recorder.state === 'inactive') return
          this.recorder.stop()
          this.recorder.stream.getAudioTracks().forEach(function(track){track.stop();});
          this.$refs.message.focus()
          clearInterval(this.timeout)
        } catch (RuntimeException) {
          alert(RuntimeException)
        }
      }
    },
    messageEmit(){
      socket.emit("send message", {
        user: this.$store.state.auth.user,
        sender: this.$store.state.auth.user,
        receiver: this.selectedUser,
        message: this.message,
        type: this.type,
        date: new Date()
      })
      this.message = ""
      this.type = 'text'
      this.scrollToBottom()
    },
    sendMsg() {
      if (this.message) {
        if (this.recordedAudio) {
          this.sendAudio()
        }else if (this.selectedImage) {
          this.sendImage()
        } else {
          this.messageEmit()
        }
        this.$refs.chatBtn.disabled = false
      }
    },
    showTyping() {
      socket.emit("settyping", "yaziyor...");
      socket.on("gettyping", (result) => {
        this.typing = result.data;
      });
      this.uploadBox = false;
    },
    scrollToBottom() {
      setTimeout(() => {
        let item = document.getElementById("chatarea")
        item.scrollTo({top: item.scrollHeight, behavior: 'smooth'}) 
      }, 100);
    },
    clearTyping() {
      this.typing = "";
    }
  }
}
</script>

<style scoped>
.chat-page {
  display: flex;
  flex-direction: column;
  width: 25vw;
  height: 80vh;
  position: fixed;
  bottom: 0;
  right: 0;
  z-index: 10;
  background-color: var(--green);
  border-top-left-radius: 20px;
  outline: 3px solid var(--green);
  overflow: hidden;
}
.chat-header {
  min-height: calc(60px + 0.2vw);
  color: #fff;
  padding: 0 8px;
  border-top-left-radius: var(--radiuslarge);
  background-color: var(--black);
}
.chat-user-scroll {
  display: flex;
  flex-direction: column;
  align-items: center;
  height: 100%;
  overflow-y: auto;
  padding: 10px;
}
.chat-side{
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  height: auto;
  background-image: url('@/assets/img/chatbg.webp');
  background-position: center;
  overflow-y: auto;
}
.chat-area {
  display: flex;
  flex-direction: column;
  width: 100%;
  height: 100svh;
  padding: 20px 10px;
  padding-bottom: 20px;
  position: relative;
  overflow-y: auto;
}

.chat-footer {
  display: flex;
  align-items: center;
  width: 100%;
  min-height: 54px;
  padding: 10px;
  background-color: var(--black);
  box-sizing: border-box;
  border-top: 1px solid #ccc;
}
.chat-user-title {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 90%;
  height: 100%;
}
.chat-title-icon{
  width: calc(42px + 0.2vw);
  margin-left: 10px;
}
.chat-user-icons{
  width: calc(28px + 0.2vw);
  margin: 0 10px;
}
.chat-user-list {
  display: flex;
  align-items: center;
  width: 100%;
  margin: 5px 0;
  border-radius: 30px;
  padding: 7px 5px;
  box-sizing: border-box;
  cursor: pointer;
  background-color: var(--black);
  color: #fff;
}

.chat-user-list-text {
  margin-left: 10px;
}
.typing {
  margin-left: 10%;
  margin-top: 5px;
}
.chat-list {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  width: 100%;
  height: auto;
  min-height: max-content;
  padding: 5px;
}
.chat-list-class,
.imageDynamicClass {
  display: flex;
  flex-direction: column;
  min-width: 160px;
  max-width: 200px;
  min-height: max-content;
  text-align: left;
  background-color: aliceblue;
  padding: 7px 10px;
  border-radius: 6px;
  word-break: break-all;
  box-shadow: 1px 1px 1px #ccc
}
.senderClass {
  display: flex;
  align-self: flex-end;
  background-color: lightcyan;
  position: relative;
}
.imgMsg {
  width: 160px;
  height: 100px;
}
.imageDynamicClass {
  background-color: none;
  padding: 0;
}
.senderClass::before {
  display: inline-block;
  content: "\2713";
  position: absolute;
  bottom: 3px;
  right: 5px;
  /* z-index: 10; */
  color: #3BA776;
}
.readstateClass {
  position: relative;
}
.readstateClass::after {
  content: "\2713";
  position: absolute;
  bottom: 3px;
  right: 10px;
  /* z-index: 10; */
  color: #3BA776;
}
.recordSender{background-color: transparent;}
.chatOnlinClass {
  display: inline-block;
  position: absolute;
  bottom: 3px;
  right: 1px;
  /* z-index: 1; */
  color: #3BA776;
}
.chat-text {
  margin-right: 20px;
}
.chat-list-title{
  font-size: calc(18px + 0.2vw);
}
.chat-date {
  margin-top: 5px;
  margin-right: 15px;
  align-self: flex-end;
  font-size: 10px;
}
.chat-count {
  margin-left: 20px;
  background-color: var(--lightgreen);
}
.chatSaveClass {
  color: #3BA776;
}
.chat-input {
  display: flex;
  width: 70%;
  min-height: 36px;
  padding-left: 10px;
  border: 1px solid #ccc;
  box-sizing: border-box;
  border-radius: 20px;
  outline: none;
  font-size: 18px;
}
.dropdown {
  position: relative;
}
.upload-box {
  position: absolute;
  bottom: 38px;
  padding: 10px;
  background-color: darkolivegreen;
  right: -25px;
  border-top-left-radius: 4px;
  border-top-right-radius: 4px;
}
.chat-emoji-icon{
  font-size: calc(28px + 00.2vw);
}
.dropdown-item {
  display: block;
  min-height: 18px;
  margin: 3px 0;
  padding: 2px 5px;
  color: #fff;
  background-color: #333;
  border-radius: 2px;
}
.emoji-con {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  justify-content: flex-start;
  width: 100%;
  height: auto;
  margin: 0 auto;
  padding-left: 10px;
  list-style: none;
  border: 1px solid #d3d3d3;
  position: absolute;
  z-index: 25;
  right: 0;
  bottom: 60px;
  background-color: #D0DCDB;
  border: 1px solid #d3d3d3;
}
.emoji-list {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 40px;
  height: 40px;
  margin: 0;
  padding: 5px;
  cursor: pointer;
}
.emoji{
  font-size: calc(20px + 0.5vw);
  margin: 0 5px;
}
.hasMsg{
  color: var(--yellow);
}
.chat-btn{
  border: none;
  background-color: transparent;
}
.menu-1{
  border-bottom: none !important;
}
@media screen and (max-width: 1280px){
  .chat-page {
    width: 100vw !important;
    height: auto !important;
    top: 0;
    left: 0;
    border-radius: 0 !important;
  }
.chat-area{
  padding-bottom: 80px !important;
}
  .chat-header {
    border-top-left-radius: 0 !important;
  }
  .chat-user-list {
    width: 100%;
    padding: 10px 0 !important;
  }
}
</style>