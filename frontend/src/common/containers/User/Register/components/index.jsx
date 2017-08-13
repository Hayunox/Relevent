import React, {Component} from 'react'
import PropTypes from 'prop-types'
import {Form, Message, Grid} from 'semantic-ui-react'
import {Helmet} from 'react-helmet'
import _ from 'lodash'
import {RegisterButton} from './style'
import {TextCenter} from '../../../../styles/base'

export default class RegisterComponent extends Component {
	constructor (props) {
		super(props)
		this.state = {
			username: '',
			password: ''
		}
	}

	static propTypes = {
		register: PropTypes.func,
		errors: PropTypes.object
	}

	handleSubmit (e) {
		e.preventDefault()
		const {register} = this.props
		const {username, mail, password} = this.state
		register({username, mail, password})
	}

	handleChange (e, {name, value}) {
		this.setState({
			[name]: value
		})
	}

	render () {
		const {username, mail, password, passwordConfirm} = this.state
		// Error from server
		const {errors} = this.props
		const registerFormProps = {error: !_.isEmpty(errors)}
		// register btn props
		const registerBtnProps = {
			content: 'Register',
			icon: 'signup'
		}

		return (
			<Grid
				verticalAlign="middle"
				centered
				columns={1}
				textAlign="center"
				relaxed
			>
				<Helmet>
					<title>Relevent: Registration</title>
				</Helmet>
				<Grid.Row>
					<Grid.Column tablet={10} mobile={16} computer={12}>
						<Form onSubmit={::this.handleSubmit} {...registerFormProps}>
							{errors &&
							<Message
								error
								header={'Invalid credentials'}
								content={'Your credentials are invalid.'}
							/>}
							<Form.Group unstackable widths={2}>
								<Form.Input
									placeholder="Nickname"
									name="nickname"
									label="Username"
									value={username}
									onChange={::this.handleChange}
								/>
								<Form.Input
									placeholder="Mail address"
									type="mail"
									name="mail"
									label="Mail"
									value={mail}
									onChange={::this.handleChange}
								/>
							</Form.Group>
							<Form.Group widths={2}>
								<Form.Input
									placeholder="Password"
									type="password"
									name="password"
									label="Password"
									value={password}
									onChange={::this.handleChange}
								/>
								<Form.Input
									placeholder="Password Confirmation"
									type="password"
									name="password-confirm"
									label="Password"
									value={passwordConfirm}
									onChange={::this.handleChange}
								/>
							</Form.Group>
							<Form.Checkbox label='I agree to the Terms and Conditions' />
							<TextCenter>
								<RegisterButton {...registerBtnProps} />
							</TextCenter>
						</Form>
					</Grid.Column>
				</Grid.Row>
			</Grid>
		)
	}
}
