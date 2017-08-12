import {Route} from 'react-router-dom'
import {Users, Dashboard, Login} from 'containers'
import RouteAuth from 'components/addons/RouteAuth'
import {createBrowserHistory, createMemoryHistory} from 'history'

export const history = getHistory()

const loadLazyComponent = url => {
	return async cb => {
		// NOTE: there isn't any duplication here
		// Read Webpack docs about code-splitting for more info.
		if (process.env.BROWSER) {
			const loadComponent = await import(/* webpackMode: "lazy-once", webpackChunkName: "lazy-containers" */ `containers/${url}/index.jsx`)
			return loadComponent
		}
		const loadComponent = await import(/* webpackMode: "eager", webpackChunkName: "lazy-containers" */ `containers/${url}/index.jsx`)
		return loadComponent
	}
}

export const routes = [
	{
		path: '/',
		exact: true,
		icon: 'newspaper',
		name: 'Dashboard',
		sidebarVisible: true,
		tag: RouteAuth,
		component: Dashboard
	},
	{
		path: '/users',
		name: 'Users',
		exact: true,
		icon: 'users',
		sidebarVisible: true,
		tag: RouteAuth,
		component: Users
	},
	{
		external: true,
		path: 'https://github.com/Metnew/react-semantic.ui-starter',
		icon: 'github',
		name: 'Github',
		sidebarVisible: true
	},
	{
		path: '/auth',
		name: 'Auth',
		tag: Route,
		component: Login
	},
	{
		path: '/users/:id',
		name: 'User',
		lazy: true,
		exact: true,
		tag: RouteAuth,
		component: loadLazyComponent('UserItem')
	}
]

function getHistory () {
	const basename = ''
	if (process.env.BROWSER !== true) {
		return createMemoryHistory()
	}
	return createBrowserHistory({basename})
}
