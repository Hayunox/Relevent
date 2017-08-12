import React from 'react'
import {
    BrowserRouter,
    Redirect,
    Route,
    Switch,
} from 'react-router-dom'

// import Event from './Event'
import Login from './User/Login'
import PageNotFound from './Common/PageNotFound'

const RedirectToIntro = () => <Redirect to='/login' />

const Router = () => (
    <BrowserRouter>
        <Switch>
            <Route exact path='/maximize/:kebabCaseName' component={ExternalExampleLayout} />
            <Switch>
                <DocsLayout exact path='/' render={RedirectToIntro} />
                <DocsLayout exact path='/login' component={Login} />
                <DocsLayout exact path='/*' component={PageNotFound} />
            </Switch>
        </Switch>
    </BrowserRouter>
)

export default Router