import { createRouter, createWebHistory } from 'vue-router'
import Navbar from '../views/Navbar.vue'
import Home from '../views/HomeView.vue'
import Auth from '../views/AuthView.vue'
import Register from '../views/AuthSignUp.vue'
import RegisterHero from '../views/AuthSignUpHero.vue'
import Login from '../views/AuthSignIn.vue'
import LoginHero from '../views/AuthSignInHero.vue'
import NotFound from '../views/NotFoundView.vue'


const APP_NAME = 'atArtist'

const routes = [
  {
    path: '/',
    components: {
      default: Home,
      Navbar
    },
    name: APP_NAME
  },
  {
    path: '/auth',
    component: Auth,
    redirect: '/auth/sign-in',
    children: [
      {
        path: 'sign-up',
        components: {
          Hero: RegisterHero,
          Form: Register
        },
        name: 'sign-up',
        meta: {
          title: 'Sign up | ' + APP_NAME,
        }
      },
      {
        path: 'sign-in',
        components: {
          Hero: LoginHero,
          Form: Login
        },
        name: 'sign-in',
        meta: {
          title: 'Sign in | ' + APP_NAME,
        }
      },
      // {
      //   path: '',
      //   components: {
      //     Hero: RegisterHero,
      //     Form: Register
      //   },
      //   name: 'sign-up',
      //   meta: {
      //     title: 'Sign up | ' + APP_NAME,
      //   }
      // },
    ]
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'not-found',
    meta: {
      title: 'Page not found | ' + APP_NAME,
    },
    component: NotFound
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach(async (to, from, next) => {
  document.title = to.meta.title || APP_NAME

  // if (store.state.auth && (to.name == 'login' || to.name == 'register')) {
  //   document.title = APP_NAME
  //   return next({ name: APP_NAME })
  // }

  return next();
});

export default router;