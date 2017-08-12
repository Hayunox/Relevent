import {post} from 'api/utils'

export async function registerAPI (data) {
	return post('/register', data)
}
