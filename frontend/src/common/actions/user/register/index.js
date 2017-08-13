import {
	registerAPI,
	setLocalToken,
	resetLocalToken,
	resultOK
} from 'api'

export const REGISTER_PENDING = 'REGISTER_PENDING'
export const REGISTER_SUCCESS = 'REGISTER_SUCCESS'
export const REGISTER_FAIL = 'REGISTER_FAIL'

export const REGISTER = async data => {
	return {type: REGISTER_SUCCESS, result: ''}
}
