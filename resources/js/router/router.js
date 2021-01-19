import Vue from 'vue';
import VueRouter from 'vue-router';

// component mapped to route
import MyPostsPage from '../pages/MyPostsPage'
import QuestionsPage from '../pages/QuestionsPage'
import QuestionPage from '../pages/QuestionPage'
import CreateQuestionPage from '../pages/CreateQuestionPage'
import NotFoundPage from '../pages/NotFoundPage'
Vue.use(VueRouter);

const router = new VueRouter({
	mode: 'history',
	linkActiveClass: 'active',
	routes: [
		{
			path: '/',
			component: QuestionsPage,
			name: 'home'
		},
		{
			path: '/questions',
			component: QuestionsPage,
			name: 'questions'
		},
		{
			path: '/questions/create',
			component: CreateQuestionPage,
			name: 'questions.create'
		},
		{
			path: '/my-posts',
			component: MyPostsPage,
			name: 'my-posts',
			meta: {
				auth: true
			}
		},
		{
			path: '/questions/:slug',
			component: QuestionPage,
			name: 'question'
		},
		{
			path: '*',
			component: NotFoundPage
		}
	]
});

router.beforeEach((to, from, next) => {
	if(to.matched.some(item => item.meta.auth) && !window.Auth.signedIn){
		window.location = window.Urls.login;
		return;
	}
	next();
})

export default router;