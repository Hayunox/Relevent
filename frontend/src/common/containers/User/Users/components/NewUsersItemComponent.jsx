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
			<Card>
				<Card.Content>
					<Image floated='right' size='mini' src='/assets/images/avatar/large/steve.jpg' />
					<Card.Header>
						Steve Sanders
					</Card.Header>
					<Card.Meta>
						Friends of Elliot
					</Card.Meta>
					<Card.Description>
						Steve wants to add you to the group <strong>best friends</strong>
					</Card.Description>
				</Card.Content>
				<Card.Content extra>
					<div className='ui two buttons'>
						<Button basic color='green'>Approve</Button>
						<Button basic color='red'>Decline</Button>
					</div>
				</Card.Content>
			</Card>
		)
	}
}
