import React, {Component} from 'react'
import {connect} from 'react-redux'
import PropTypes from 'prop-types'
import {REGISTER, REGISTER_PENDING} from 'actions'
import RegisterComponent from './components/index'

class Register extends Component {
	static propTypes = {
		register: PropTypes.func.isRequired,
		errors: PropTypes.object.isRequired
	}

	render () {
		const {register, errors} = this.props
		const props = {register, errors}
		return <RegisterComponent {...props} />
	}
}

function mapStateToProps (state) {
	const {errors} = state.me.auth
	return {
		errors
	}
}

function mapDispatchToProps (dispatch) {
	return {
		register: async data => {
			dispatch({type: REGISTER_PENDING})
			const result = await REGISTER(data)
			return dispatch(result)
		}
	}
}

export default connect(mapStateToProps, mapDispatchToProps)(Register)
