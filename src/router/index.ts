import { createRouter, createWebHistory } from 'vue-router';
import MainSite from '../components/MainSite.vue';
import DashBoard from '../components/DashBoard.vue';
import Statistics from '../components/Statistics.vue';
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Kezdőoldal',
      component: MainSite
    },
    {
      path:'/dash',
      name:'Dashboard',
      component: DashBoard
    },
    {
      path:'/statistics',
      name:'Statisztika',
      component: Statistics
    }
  ]
})

export default router