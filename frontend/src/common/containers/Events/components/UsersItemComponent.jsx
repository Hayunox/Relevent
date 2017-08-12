import React, {Component} from 'react'
import PropTypes from 'prop-types'
import Card from 'semantic-ui-react/dist/es/views/Card/Card'
import Image from 'semantic-ui-react/dist/es/elements/Image/Image'
import Button from 'semantic-ui-react/dist/es/elements/Button/Button'

export default class UsersItemComponent extends Component {
	static propTypes = {
		name: PropTypes.string,
		username: PropTypes.string,
		address: PropTypes.object,
		email: PropTypes.string,
		website: PropTypes.string,
		phone: PropTypes.string,
		id: PropTypes.number,
		item: PropTypes.object
	}

	render () {
		const {name, username, address, email, website, phone, id} = this.props

		return (
			<Card raised>
				<Image alt="Dummy image" src={require('images/dummy.png')} />
				<Card.Content>
					<Card.Header>
						{`${name} "${username}"`}
					</Card.Header>
					<Card.Meta>
						<span className="date">
							Since 2017
						</span>
					</Card.Meta>
					<Card.Description>
						{address.city} {address.street}
					</Card.Description>
				</Card.Content>
				<Card.Content extra>
					<div className="ui buttons">
						<Button basic color="green">
							Send message
						</Button>
					</div>
				</Card.Content>
			</Card>
		)
	}
}
