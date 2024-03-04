<template>
  <div class="admin">
    <NavbarComponent />
    <BannerComponent />
    <main class="admin-wrapper">
      <AdminMenuComponent />
      <RouterView class="admin-router" />
    </main>
    <FooterComponent />
    <ChatComponent  v-if="$store.state.openchat" />
  </div>
</template>

<script setup>
  import { defineAsyncComponent } from 'vue'; 
  import NavbarComponent from "@/components/navbar-component.vue";
  import BannerComponent from "@/components/banner-component.vue";
  import FooterComponent from "@/components/footer-component.vue";
  const ChatComponent = defineAsyncComponent(() => import("@/components/chat-component.vue"))
  const AdminMenuComponent = defineAsyncComponent(() => import("@/components/admin-menu-component.vue"))
</script>

<style>
.admin{
  width: 100%;
  background-image: url('@/assets/img/home-wrapper.webp');
  background-size: contain;
  position: relative;
}
.admin-wrapper{
  display: flex;
  margin-bottom: 5px;
  padding: 0 5px;
}
.admin-router{
  width: 100%;
  background-color: #f1f1f1;
  border: 1px solid #ccc;
}
.admin-con{
  width: 100%;
}
.admin-menu{
  min-width: 18%;
  margin-right: 0.5%;
  border-left: 1px solid #ccc;
  background-color: var(--black);
}
.admin-side{
  width: 79%;
  border-right: 1px solid #ccc;
  background-color: #f1f1f1;
}
.admin-menu{
  background-color: var(--black);
  border-radius: var(--radiuslarge);
}
.admin-menu-title{
  display: flex;
  align-items: center;
  justify-content: center;
  height: 56px;
  color: var(--yellow);
}
.title-1{
  display: flex;
  align-items: center;
  min-height: 46px;
  padding-left: 20px;
  border-top: 1px solid #444;
  color: darkgrey;
}
.admin-menu-links{
  display: flex;
  flex-direction: column;
  color: #fff;
}
.admin-links{
  display: flex;
  align-items: center;
  height: 46px;
  padding-left: 30px;
}
.admin-links:hover{
  background-color: #556b2f45;
}
.admin-menu-icons{
  color: var(--green);
  min-width: 30px;
}
.admin-menu-text{
  color: #fff;
}
.bet-menu{
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  background-color: var(--black);
}
.bet-menu div {
  display: flex;
  align-items: center;
  height: 100%;
  margin: 0 5px;
}
.bet-date input{
  margin: 0 5px;
}
.bet-coupon-info{
  align-items: center;
  width: 140px;
}
.bet-menu-title{
  min-width: 150px;
  margin-right: 10px;
  color: var(--yellow);
}
.bet-menu div label {
  color: #fff;
}

.soccerStyle, .basketStyle{
  display: flex;
  justify-content: center;
  align-items: center;
  width: 80px;
  height: 28px;
  color: #fff;
  border-radius: var(--radius);
}
.basketStyle{
  background-color: rgb(135 60 16 / 71%);
}
.soccerStyle{
  background-color: rgb(58 90 64 / 71%);
}
.bet-header-code{
  margin:0 5px;
}
.bet-list-con{
  padding: 5px;
  background-color: gainsboro;
  overflow-y: auto;
}
.bet-list-header {
  display: flex;
  align-items: center;
  padding: 8px;
  color: #fff;
  height: 46px;
  margin: 5px 0;
  background-color: var(--green);
}
.bet-list-header > div {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
  flex: 1;
}
.bet-list-user-row{
  justify-content: flex-start !important;
}
.sort-items{cursor: pointer;}
.bet-list {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: calc(42px + 0.2vw);
  padding: 0 8px;
  border-radius: 2px;
  margin: 2px 0;
  border: 1px solid rgb(180, 176, 176);
  background-color: #f1f1f1;
  color: #000;
  border-radius: 10px;
}
.betid{
  width: 50px;
  margin-right: 25px;
  background-color: rgb(58 90 64 / 71%);
  height: 30px;
}
.bet-list:hover{
  filter: brightness(90%);
}
.bet-list div{
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
  flex: 1;
  white-space:nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.bet-list-left {
  align-items: center;
  width: 92%;
  height: 36px;
}
.bet-list-code{
  justify-content: flex-start !important;
}
.owner{
  flex: 2 !important;
}
.bet-list-right {
  justify-content: space-around !important; 
  max-width: 8.8%;
  align-items: center;
}
.bet-trash{
  width: 16px;
  cursor: pointer;
}
.bet-search{
  justify-content: flex-start !important;
}
.info {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 24px;
  height: 24px;
  border-radius: 20px;
  background-color: #17578D;
  color: #fff;
  margin-left: 10px;
  cursor: help;
}
.users-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  min-height: 460px;
  padding: 30px;
  background-color: #f1f1f1;
}
.users-container {
  width: 100%;
  background-color: #f1f1f1;
  padding: 20px;
  margin: 20px 0;
  border-radius: 8px;
  border: 1px solid #ccc;
}
.limit-box-con{
  display: flex;
  align-items: center;
  height: 60px;
  padding-left: 10px;
}
.big-icons{
  width: 96px;
}
.user-list-icon{
  width: 28px;
  margin: 0 5px;
}
.user-details-icon{
  width: 64px;
  margin-right: 10px;
}
.bet-trash-icon{
  width: 18px;
}
.users-text {
  margin:0 10px;
}
.user-limit {
  margin-right: 10px;
}
.fix-li-warning {
  display: flex;
  align-items: center;
  min-height: 60px;
}
.sec-icon {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 60px;
  height: 60px;
  background: #ead76c;
  border-radius: 4px;
  margin: 20px;
  font-size: calc(20px + 0.5vw);
}
.main-set-list {
  width: 94%;
  margin: auto;
}
.set-li,
.fix-li {
  display: flex;
  align-items: center;
  position: relative;
  width: 100%;
  height: 44px;
  min-height: 44px;
}
.set-li div{
  width: 300px;
}
.fix-li {
  display: flex;
  width: 100%;
  min-height: 40px;
  cursor: pointer;
}
.fix-1 {
  display: flex;
  align-items: center;
  width: 100%;
  min-height:40px ;
  cursor: pointer;
}
.fix-li-2 {
  display: flex;
  align-items: center;
  width: 100%;
  min-height: 50px;
  padding-left: 10px;
}
.fix-li-2-sub {
  display: flex;
}

.set-li-text {
  width: 240px;
}
.set-li-title {
  color: var(--green);
}
.set-li-icons{
  color: var(--green);
  margin-right: 10px;
}
.fix-rate {
  width: 60px;
  height: 30px;
  border-radius: 3px;
  margin: 0 20px;
}
.fix-li-items {
  min-width: 200px;
}
.users-setting-list{
  display: flex;
}
.users-checkbox{
  width: 20px;
  height: 20px;
  border-radius: 2px;
  margin-right: 10px;
}

.title-list-icon {
  min-width: 15px;
  margin-right: 10px;
  color: var(--green)
}
.credit-btn-con{
  display: flex;
}
.market-name{
  margin-right: 50px;
}
.credit-icons, .user-trash{
  cursor: pointer;
}
.code-list-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  margin: 2px 0;
  padding: 5px;
  color: #000;
  border-bottom: 1px solid #ccc;
}
.code-list-item div{
  display: flex;
  align-items: center;
  min-width: 50%;
}
.code-list-item div span:first-child{
  margin-right: 10px;
  background-color: var(--red);
  color: #fff !important;
}

.code-list-item > span > .badge {
  margin-right: 10px;
  background-color: brown;
  color: #fff;
  padding: 5px 10px;
}
.rules{
    padding: 5px;
  }
.rules div{
  display: flex;
  height: auto;
  margin: 5px 10px;
}
.rules-number{
  width: 20px;
  text-align: center;
  margin-right: 10px;
}
.rules-title{
  text-align: center;
  margin: 10px 0;
}
.bet-summary-con {
  padding: 4px;
  background-color: gainsboro;
}
.bet-details-model {
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  left: 0;
  top: 0;
  z-index: 50;
  width: 100%;
  height: 100vh;
  background-color: rgb(0 0 0 / 72%);
}
.bet-details-con {
  display: flex;
  flex-direction: column;
  width: 90%;
  height: 400px;
  padding: 15px;
  border-radius: 5px;
  background-color: gainsboro;
  position: relative;
  bottom: 100px;
  overflow: hidden;
}
.details-match-column{
  min-width: 25%;
}
.details-games-column{
  min-width: 20%;
}
.user-comission {
  width: 100%;
  color: var(--yellow);
}
.edit-value{
  padding-left: 5px;
  width: 260px;
}
.btn-pay{
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 42px;
  cursor: pointer;
  border: none;
  border-radius: var(--radius);
}
.btn-pay{
  height: 30px;
}
.Aktif {
  background-color: #ebebd4;
}
.Kazandi{
  background-color: #2e8b57cf;
  color: #fff;
}
.Kaybetti{
  background-color: #b90e0eb0;
  color: #fff;
}
.Online, .colorGreen{color: var(--lightgreen);}
.Offline, .colorRed{color: var(--red);}
.ip-field{
  word-break: break-all;
}
.iptal,
.iptalrepeat {
  background-color: darkgray;
}
.iade {
  background-color: rgb(167, 86, 59);
}
.comission-date{
  min-width: 35%;
}
.comission-info{
  min-width: 45%;
  justify-content: space-between;
}
.user-details-items {
  display: flex;
  align-items: center;
  width: 30%;
  margin: 20px 0;
}
.user-details-title-text {
  margin-left: 74px;
}
.user-details-text {
  display: flex;
  align-items: center;
  min-width: 120px;
  text-align: left;
  margin-right: 10px;
}
.input-user-details {
  height: 34px;
  width: 200px;
}
.user-details-trash {
  display: flex;
  justify-content: flex-end;
  cursor: pointer;
}
.user-details-trash i{
  color: var(--red);
}
.bet-warning-dialog{
  width: 400px;
  height: 240px;
  top: 100px;
  background-color: var(--black);
}
.bet-warning-text {
  width: 100%;
  color: #fff;
  text-align: center;
  padding-bottom: 20px;
  margin-bottom: 20px;
  border-bottom: 1px solid #c9c93a54;
}
.bet-warning-header {
  display: flex;
  justify-content: center;
  width: 100%;
  padding: 5px;
}
.warning-code {
  padding: 5px 15px;
  border-radius: 5px;
  color: #f1f1f1;
}

.paymentTimeClass {
  width: 94%;
  height: 80%;
  border-radius: 4px;
  background-color: #F74D4D;
}
.sessioncount{
  color: var(--red);
  margin-left: 5px;
}
.profile-title{
  display: flex;
  align-items: center;
}
.profile-input {
  height: 22px;
  padding-left: 5px;
  border-radius: 3px;
  border: none;
  border: 1px solid #999;
}
.fix-li-info{
  color: #d45757;
}
.input-select-con{
  min-width: 80px;
}
.bet-filter{
  width: 40%;
  position: relative;
}
.select-placeholder{
  position: absolute;
  right: 50px;
  color: #999;
}
.bet-date{
  width: 100%;
}
.select-bet-state{
  box-shadow: none;
  width: 100%;
}
.coupon-container{
  padding: 30px;
  width: 100%;
}
.coupon-title{width: 100%;}
.coupon-details-logo{
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100px;
  margin-bottom: 50px;
}
.coupon-report-icon, .advise-icon, .logo-icons{
  margin: 50px 0;
  color:var(--green);
}
.coupon-list{
  display: flex;
  justify-content: space-between;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: var(--radius);
  list-style: none;
}
.coupon-details-container{
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  border: 1px solid #ccc;
  padding: 10px;
  margin: 5px;
  flex: 1;
  border-radius: var(--radiuslarge);
}
.coupan-details-items{
  display: flex;
  justify-content: space-between;
  width: 100%;
  height: 30px;
  border-bottom: 1px solid #ddd;
  margin: 5px;
  padding-right: 10px;
  font-size: 18px;
}
.coupan-details-title{
  display: flex;
  justify-content: center;
  align-items: center;
  height: 40px;
  width: 100%;
  border-radius: var(--radius);
  margin-bottom: 20px;
}
.advise-icon{
  text-align: center;
  margin-bottom: 50px;
}
.advise-con{
  padding: 50px;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.advise-con > input, textarea{
  width: 100%;
  min-height: 40px;
  margin: 10px 0;
  border-radius: var(--radiuslarge);
  border: 1px solid #ddd;
}
.advise-text{
  padding: 10px;
  font-size: calc(16px + 0.1vw);
}
.advise-btn{
  background-color: var(--green);
  color: #fff;
  cursor: pointer;
}
.advise-con-list{
  width: 90%;
  margin: 20px auto;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: var(--radius);

}
.advise-subject{
  display: flex;
  align-items: center;
  height: 40px;
  border-bottom: 1px solid #ddd;
  background-color: #fff;
}
.anons{
  width: 100%;
  padding: 10px;
}
.boss-btn-con{
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  min-height: 40px;
}
.boss-btn-con input {
  width: fit-content;
  color: var(--black);
  margin: 5px;
  padding: 0 10px;
  cursor: pointer;
}
.boss-title{
  margin: 10px;
}
.boss-old-data{
  display: flex;
  list-style: none;
  margin: 5px 0;
}
.boss-old-data li{
  margin: 0 5px;
  color: var(--green);
}
.boss-loader-con{
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  z-index: 1;
  background-color: #181717c7;
}


.dialog-score-model {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  width: 280px;
  min-height: 150px;
  height: auto;
  background-color: #f1f1f1;
  border: 8px solid var(--green);
  border-radius: var(--radius);
  padding: 10px;
  position: absolute;
  right: 15px;
  top: 15px;
  z-index: 50;
}
.dialog-score-wrapper{
  display: flex;
  align-items: center;
  width: 100%;
  min-height: 50px;
}
.dialog-score-con{
  padding: 10px;
}
.dialog-close-score{
  right: 15px;
  padding: 3px 6px;
}
.score-header{
  display: flex;
  justify-content: space-between;
  width: 100%;
  background: var(--black);
  color: #fff;
  min-height: 34px;
  align-items: center;
  padding-left: 10px;
}
.score-text{
  margin: 5px;
}
.bet-details-tool{
  display: flex;
  justify-content: space-around;
  min-width: fit-content;
}
.bet-print{
  color: var(--yellow);
  cursor: pointer;
}
.btn-2{
  color: var(--black) !important;
}
.betid-con{
  display: flex;
  justify-content: flex-start !important;
}
@media screen and (max-width: 1280px){
  .users-wrapper{
    width: 100vw;;
  }
  .user-details-items{
    width: 100%;
  }
  .main-set-list{
    width: 27%;
    margin: 0 10px;
  }
  .main-set-list-2{
    width: 50%;
    margin-left: 10px;
  }
  .fix-li-2, .set-li{
    flex-direction: column;
    align-items: flex-start;
    height: auto;
  }
  .fix-li-2-sub{
    width: 100%;
  }
  .coupon-container{width: 30%;}
  .coupon-list{
    flex-direction: column;
  }
}
</style>