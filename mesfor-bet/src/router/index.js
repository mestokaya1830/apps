import { createWebHistory, createRouter } from "vue-router";
import store from "@/store/index";


const routes = [
  {
    path: "/",
    name:'login',
    component: () => import('@/views/login.vue'),
    meta:{title:'Mesfor-Giriş'}
  },
  {
    path: "/resetpassword",
    name:'reset-password',
    component: () => import('@/views/reset-password.vue'),
    meta:{title:'Mesfor-Şifre Sıfırlama'}
  },
  {
    path: "/categories",
    name:'categories',
    component: () => import('@/views/categories.vue'),
    meta:{title:'Mesfor- Kategoriler'},
    beforeEnter: (to, from, next) => {
      if(!store.state.auth){
        next({ path: '/' })
      } else {
        next()
      }
    },
  },
  {
    path: "/games",
    name: "games",
    component: () => import('@/views/games.vue'),
    beforeEnter: (to, from, next) => {
      if(!store.state.auth){
        next({ path: '/' })
      } else {
        next()
      }
    },
    children:[
      {
        path: "/games/soccer",
        name:'soccer',
        component: () => import('@/views/games/soccer.vue'),
        meta:{title:'Mesfor-Futbol'}
      },
      {
        path: "/games/soccer-live",
        name:'soccer-live',
        component: () => import('@/views/games/soccer-live.vue'),
        meta:{title:'Mesfor-Futbol Canlı'}
      },
      {
        path: "/games/basket",
        name:'basket',
        component: () => import('@/views/games/basket.vue'),
        meta:{title:'Mesfor-Basket'}
      },
      {
        path: "/games/basket-live",
        name:'basket-live',
        component: () => import('@/views/games/basket-live.vue'),
        meta:{title:'Mesfor-Basket Canlı'}
      }
    ]
  },
  {
    path: "/admin",
    name:'admin',
    component: () => import('@/views/admin.vue'),
    beforeEnter: (to, from, next) => {
      if(!store.state.auth){
        next({ path: '/' })
      } else {
        next()
      }
    },
    children:[
      {
        path: "/admin",
        name:'bets',
        component: () => import('@/views/admin/bets.vue'),
        meta:{title:'Mesfor-Kuponlar'}
      },
      {
        path: "/admin/singel-bets",
        name:'single-bets',
        component: () => import('@/views/admin/single-bets.vue'),
        meta:{title:'Mesfor-Tek Maça Kalanlar'}
      },
      {
        path: "/admin/coupon-report",
        name:'coupon-report',
        component: () => import('@/views/admin/coupon-report.vue'),
        meta:{title:'Mesfor-Kupon Raporu'}
      },
      {
        path: "/admin/game-logs",
        name:'game-logs',
        component: () => import('@/views/admin/game-logs.vue'),
        meta:{title:'Mesfor-Oyun Geçmişi'}
      },
      {
        path: "/admin/credit-logs",
        name:'credit-logs',
        component: () => import('@/views/admin/credit-logs.vue'),
        meta:{title:'Mesfor-Bakiye Geçmişi'}
      },
      {
        path: "/admin/login-logs",
        name:'login-logs',
        component: () => import('@/views/admin/login-logs.vue'),
        meta:{title:'Mesfor-Giriş/Çıkış Geçmişi'}
      },
      {
        path: "/admin/users",
        name:'users',
        component: () => import('@/views/admin/users.vue'),
        meta:{title:'Mesfor-Üyeler'}
      },
      {
        path: "/admin/users/:id",
        name:'users-details',
        component: () => import('@/views/admin/users-details.vue'),
        meta:{title:'Mesfor-Üye Detayları'}
      },
      {
        path: "/admin/add-user",
        name:'add-user',
        component: () => import('@/views/admin/add-user.vue'),
        meta:{title:'Mesfor-Üye Ekle'}
      },
      {
        path: "/admin/profile",
        name:'profile',
        component: () => import('@/views/admin/profile.vue'),
        meta:{title:'Mesfor-Profil'}
      },
      {
        path: "/admin/general-settings",
        name:'general-settings',
        component: () => import('@/views/admin/general-settings.vue'),
        meta:{title:'Mesfor-Genel Ayarlar'}
      },
      {
        path: "/admin/bet-limit-settings",
        name:'bet-limit-settings',
        component: () => import('@/views/admin/bet-limit-settings.vue'),
        meta:{title:'Mesfor-Limit Ayarları'}
      },
      {
        path: "/admin/soccer-markets",
        name:'soccer-markets',
        component: () => import('@/views/admin/soccer-markets.vue'),
        meta:{title:'Mesfor-Futbol Bahis Ayarları'}
      },
      {
        path: "/admin/soccer-live-markets",
        name:'soccer-live-markets',
        component: () => import('@/views/admin/soccer-live-markets.vue'),
        meta:{title:'Mesfor-Futbol Canlı Bahis Ayarları'}
      },
      {
        path: "/admin/basket-markets",
        name:'basket-markets',
        component: () => import('@/views/admin/basket-markets.vue'),
        meta:{title:'Mesfor-Basket Ayarları'}
      },
      {
        path: "/admin/basket-live-markets",
        name:'basket-live-markets',
        component: () => import('@/views/admin/basket-live-markets.vue'),
        meta:{title:'Mesfor-Basket Canlı Bahis Ayarları'}
      },
      {
        path: "/admin/rules",
        name:'rules',
        component: () => import('@/views/admin/rules.vue'),
        meta:{title:'Mesfor-Kurallar'}
      },
      {
        path: "/admin/advise-post",
        name:'advisepost',
        component: () => import('@/views/admin/advise-post.vue'),
        meta:{title:'Mesfor-Şikayet ve Öneriler'}
      },
      {
        path: "/admin/advise-list",
        name:'adviselist',
        component: () => import('@/views/admin/advise-list.vue'),
        meta:{title:'Mesfor-Şikayet ve Öneriler Listesi'}
      },
      {
        path: "/admin/boss",
        name:'boss',
        component: () => import('@/views/admin/boss.vue'),
        meta:{title:'Mesfor-Boss'}
      }
    ]
  },
  {
    path: "/:catchAll(.*)",
    component: () => import('@/views/login.vue'),
    meta:{title:'Mesfor-Giriş'}
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  linkActiveClass: 'active',
  linkExactActiveClass: 'active',

  scrollBehavior(to, from) {
    return {
      top: 0
    }
  },
});

router.beforeEach((to, from, next) => {
  document.title = to.meta.title;
  next()
})

export default router;
