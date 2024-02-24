<template>
  <div class="admin-menu" @click="closeAdminMenu()">
    <MemberRoleComponent v-if="$store.state.auth.role == 'Member'"/>
    <AdminRoleComponent v-if="$store.state.auth.role == 'Admin'"/>
    <SuperadminRoleComponent v-if="$store.state.auth.role == 'Superadmin'"/>
    <BossRoleComponent v-if="$store.state.auth.role == 'Boss'"/>
  </div>
</template>

<script>
  import { defineAsyncComponent } from 'vue';
  const MemberRoleComponent = defineAsyncComponent(() => import("@/components/member-role-component.vue"))
  const AdminRoleComponent = defineAsyncComponent(() => import("@/components/admin-role-component.vue"))
  const SuperadminRoleComponent = defineAsyncComponent(() => import("@/components/superadmin-role-component.vue"))
  const BossRoleComponent = defineAsyncComponent(() => import("@/components/boss-role-component.vue"))
  export default {
    name:'AdminMenu',
    components:{
      MemberRoleComponent,
      AdminRoleComponent,
      SuperadminRoleComponent,
      BossRoleComponent
    },
    data () {
      return {

      }
    },
    methods: {
      closeAdminMenu(){
        this.$store.commit('setAdminMenu', false)
      }
    },
  }
</script>

<style>
  .admin-menu{
    background-color: var(--black);
    position: fixed;
    left: 0;
    top: 0;
    width: 80vw;
    height: 100vh;
    overflow-y: auto;
    z-index: 12;
  }
  .admin-menu-title{
    display: flex;
    align-items: center;
    justify-content: center;
    height: 56px;
    color: var(--yellow);
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
</style>
