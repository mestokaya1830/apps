<template>
  <div class="games">
    <NavbarComponent />
    <BannerComponent />
    <RouterView class = "games-router" />
    <FooterComponent />
  </div>
</template>
<script setup>
import NavbarComponent from "@/components/navbar-component.vue";
import BannerComponent from "@/components/banner-component.vue";
import FooterComponent from "@/components/footer-component.vue";
</script>

<style>
.games {
  background-image: url('@/assets/img/home-wrapper.webp');
  background-size: contain;
  overflow: auto;
}
.scroll {
  width: 100%;
}
.games-router {
  display: flex;
  justify-content: center;
  width: 100%;
  min-height: 550px;
  padding: 0 2px;
  background-color: #f1f1f1;
}
.fixture-side {
  width: 65%;
  margin:0 5px;
}
.slip-side {
  width: 20%;
}
.menu-icons-con{
  display: flex;
  align-items: center;
}
.flags,
.flags-live {
  width: 32px;
  height: 32px;
  margin: 0 5px;
}
.flags{
  margin-left: 10px !important;
}
.fixture-title,
.fixture-list {
  display: flex;
  justify-content: space-between;
  height: calc(36px + 0.5vw);
  align-items: center;
}
.fixture-title{
  background-color: var(--black);
  border-top: 1px solid var(--green);
}
.fixture-list{
  font-size: calc(13px + 0.2vw);
  height: 60px !important;
}
.teams-con{
  display: flex;
  flex-direction: column;
  align-items: flex-start !important;
  padding-left: 10px;
}
.fixture-list:hover,
.bet-list:hover,
.countries-list:hover{
  filter: brightness(90%);
}
.basket-rate:hover .basket-odds-name {
  display: none;
}
.prebwinfixture:hover {
  cursor: pointer;
  background-color: var(--yellow);
}
.fixture-title div:nth-child(2) {
  flex: 10;
}

.fixture-title div:nth-child(2) {
  justify-content: flex-start;
}
.fixture-title div,
.fixture-list div {
  display: flex;
  justify-content: center;
  flex: 1;
  margin: 3px;
}
.fixture-title div {
  color: #fff;
}
.fixture-list {
  background-color: ghostwhite;
  border-bottom: 1px solid #ccc;
  font-size: calc(12px + 0.2vw);
  height: 50px;
}
.fixture-list div:nth-child(12) {
  border: none;
}
.fixture-list div:nth-child(2) {
  flex: 10;
  align-items: center;
  cursor: pointer;
}
.fixture-date-con{
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 3px 5px;
  background-color: aliceblue;
  border-radius: var(--radius);
  border: 1px solid #ddd;
  max-width: 70px;
}
.fixture-date{
  color: red;
  font-size: 12px;
}
.fixture-teams{
  flex-direction: column;
  align-items: flex-start !important;
  min-width: 500px;
}
.rate {
  line-height: 42px;
  cursor: pointer;
  border: 1px solid #ddd;
  border-radius: var(--radius);
  background-color: #f2f2f0;
}
.basket-rate,
.outer-rate {
  height: auto;
  width: 100%;
  padding-left: 5px;
}
.basket-rate {
  justify-content: flex-start !important;
  position: relative;
}
.basket-odds-name {
  position: absolute;
  bottom: 5px;
  right: 5px;
  color: var(--red);
  font-size: calc(9px + 0.2vw);
}

.suboptions-model {
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  left: 0;
  top: 0;
  z-index: 50;
  width: 100%;
  height: 100vh;
  background-color: #4444446b;
}
.suboptions-con {
  height: 100%;
  padding: 2px;
  border: 1px solid #999;
  background-color: #f1f1f1;
  overflow-y: auto;
}
.suboptions {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  width: 72%;
  min-width: 1280px;
  height: 75%;
  padding: 7px;
  border-radius: 10px;
  background-color: #ccc;
  box-shadow: 0 1px 1px 12px hsl(214, 20%, 16%, 0.8);
  overflow: hidden;
}
.suboptions-menu {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  min-height: 56px;
  background-color: var(--black);
  padding: 10px;
  border-top-right-radius: 5px !important;
  border-top-left-radius: 5px !important;
}
.suboptions-menu-tools {
  display: flex;
  justify-content: space-between;
  align-items: center;
  min-width: 180px;
  height: 100%;
}
.suboptions-menu-teamname {
  display: flex;
  justify-content: center;
  align-items: center;
  width: fit-content;
  padding: 0 20px;
  color: #fff;
  word-break: break-all;
  height: auto;
}
.suboptions-footer {
  height: 24px;
  min-height: 24px;
}
.suboptions-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  height: 56px;
  padding: 10px;
  background-color: var(--black);
  border-top: 1px solid #999;
  border-bottom: 1px solid #999;
}
.sublist-header,
.suspendClass {
  min-height: 44px;
  line-height: 44px;
  padding-left: 10px;
  cursor: pointer;
  color: #fff;
  border-bottom: 1px solid #ddd;
}
.sublist-header{
  background-color: var(--black);
}
.suspendClass {
  background-color: var(--red) !important;
  cursor: not-allowed;
}
.center-header {
  display: flex;
  align-items: center;
  min-width: 80%;
  color: #fff;
}
.subodds-list {
  display: flex;
  align-items: center;
  width: 100%;
  min-height: 42px;
  flex-wrap: wrap;
}
.subodds-wrapper {
  display: flex;
  justify-content: space-between;
  align-items: center;
  min-height: 34px;
  height: auto;
  padding-left: 10px;
  border-right: 1px solid #ccc;
  border-bottom: 1px solid #ccc;
}
.prebwinfixture {
  flex: 1 0 32%;
  background-color: var(--whitelight);
  position: relative;
  margin: 3px;
  border: 1px solid #ccc;
  border-radius: 3px;
  height: auto;
  min-height: 36px;
}
.odds {
  width: 85%;
  height: auto;
  padding: 5px 0;
}
.oddsrate {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  width: 100%;
  height: 34px;
  padding-right: 10px;
  position: absolute;
  left: 0;
}
.sotb {
  background-color: #BF541F;
}
.tab-content{
  display: flex;
  flex-direction: column;
  height: auto;
  overflow-y: auto;
}
/* live style */
.live-fixture-left {
  display: flex;
  flex-direction: column;
  min-width: 19%;
  position: relative;
  border: 1px solid #ddd;
}
.live-fixture-center {
  display: flex;
  flex-direction: column;
  min-width: 60%;
  max-width: 55%;
  margin: 0 5px;
  border: 1px solid #ddd;
}
.live-center-bet-soccer {
  background-image: url('@/assets/img/soccer-live.webp');
  background-position: center;
  background-size: cover;
}
.live-center-bet-basket {
  background-image: url('@/assets/img/basket-live.webp');
  background-position: center;
  background-size: cover;
}
.fixture-live-menu {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  border-bottom: 1px solid #ddd;
}
.live-center-panel {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  height: auto;
  min-height: 216px;
  padding: 20px 0;
  margin-top: 1px;
  margin-bottom: 5px;
  background-position: center;
  background-size: cover;
}
.live-left-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;
  position: relative;
  background-color: #f1f1f1;
  border: none;
}
.live-search-wrapper {
  width: 100%;
  padding: 5px;
}
.live-center-no-bet {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 452px;
  margin-top: 1px;
  padding: 5px;
  box-sizing: border-box;
}
.soccer-bg {
  background-color: var(--green);
  color: #fff;
}
.live-list {
  border-radius: var(--radius);
  margin: 2px;
  padding: 5px;
}
.basket-bg {
  background-color: var(--orange);
  color: #fff;
}
.left-list-items {
  display: flex;
  flex-direction: column;
  justify-content: space-around;
  min-height: 60px;
  padding: 5px;
  border-bottom: 1px solid #333;
}
.left-list-items-time {
  display: flex;
  justify-content: space-between;
  align-items: center;
  min-height: 40px;
  padding: 5px;
  color: var(--yellow);
}
.live-tab {
  min-height: 800px;
}
.match-minutes{
  font-size: calc(20px + 0.2vw);
  color: var(--yellow);
}
.stats {
  display: flex;
  flex-direction: column;
  width: 80%;
  height: 80px;
  margin-top: 5px;
  padding: 0 10px;
  border-radius: 5px;
  background-color: var(--black);
}
.stats-title {
  display: flex;
  justify-content: space-between;
  align-items: center;
  min-height: 30px;
  border-bottom: 1px solid #444;
  color: #fff;
}
.sti {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 25%;
}
.stats-con {
  display: flex;
  justify-content: space-between;
  align-items: center;
  height: 50px;
  padding: 0 5px;
}
.stats-item {
  color: #fff;
  margin: 0 8px;
}
.scores-board {
  display: flex;
  justify-content: space-between;
  align-items: center;
  height: 50px;
  width: 80%;
  text-shadow: 1px 1px #333;
  margin-bottom: 10px;
  padding: 0 10px;
  border-radius: 5px;
  background-color: var(--black);
  color: #fff;
}
.sbc {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 200px;
}
.sbs,
.sbt {
  display: flex;
  justify-content: center;
  align-items: center;
  width: auto;
  min-width: 60px;
  height: 35px;
  margin: 0 10px;
  border-radius: 3px;
  padding: 0 10px;
  font-size: calc(20px + 0.5vw);
}
.sbs {
  background-color: var(--green);
}
.sbt {
  background-color: var(--orange);
}
.sbnh,
.sbna {
  display: flex;
  width: 45%;
  overflow: hidden;
  font-size: calc(8px + 0.5vw);
}
.sbnh {
  justify-content: flex-end;
}
.sbna {
  justify-content: flex-start;
}
.live-events {
  width: 500px;
  height: auto;
  position: absolute;
  z-index: 40;
  top: 74px;
  background-color: #f1f1f1;
  border: 2px solid #ddd;
  outline: 15px solid var(--green);
  overflow: hidden;
}
.event-title {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 40px;
  background-color: var(--green);
  color: #fff;
}
.event-wrapper {
  padding: 10px;
}
.event-con {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #ddd;
  height: 32px;
}
.event-con > span {
  display: flex;
  justify-content: center;
  flex: 1;
}
.sep {
  width: 40%;
}
.event-icon {
  color: #fff;
}
.tab-pane {
  display: none;
  padding: 3px;
  height: auto;
  padding: 0;
}
.live-option-filter{
  display: flex;
  min-width: 60%;
}
.live-option-filter li a{
  flex: 1;
  margin: 0 5px;
}
.activeshow {
  display: block;
}
.activeLiveFilter {
 background-color:  var(--yellow) !important;
 color: #000 !important;
}
.live-option-filter-items {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 32px;
  min-width: fit-content;
  height: calc(28px + 0.2vh);
  border-radius: 2px;
  padding: 0 5px;
  color: var(--white);
}
.lii-con {
  display: flex;
  flex-direction: column;
  width: 100%;
  min-height: 60px;
  padding: 10px 0;
}
.lii {
  display: flex;
  justify-content: space-between;
  padding: 10px;
  width: 100%;
  min-height: 30px;
}
.fixture-con{
  height: 100%;
  width: 100%;
}

.countries{
  display: flex;
  flex-direction: column;
  width: 14%;
  font-family: 'roboto';
}
.countries-title{
  height: 100%;
  color: var(--white);
  font-size: calc(16px + 0.2vw);
}
.countries-list{
  display: flex;
  align-items: center;
  height: calc(32px + 0.5vw);
  background-color: var(--black);
  padding: 0 5px;
  cursor: pointer;
  border-top: 1px solid var(--green);
  font-family: serif;
}
.countries-flag{
  margin: 0 10px;
}
</style>