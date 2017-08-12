import React from 'react'
import {
  BrowserRouter,
  Redirect,
  Route,
  Switch,
} from 'react-router-dom'

import UserRegister from './Components/User/Register'
import Event from './Components/Event'

import ExternalExampleLayout from './Components/ExternalExampleLayout'
import DocsLayout from './Components/DocsLayout'
import DocsRoot from './Components/DocsRoot'
import LayoutsLayout from './Components/LayoutsLayout'
import LayoutsRoot from './Components/LayoutsRoot'

import PageNotFound from './Views/PageNotFound'

const RedirectToIntro = () => <Redirect to='/introduction' />

const Router = () => (
  <BrowserRouter>
    <Switch>
      <Route exact path='/maximize/:kebabCaseName' component={ExternalExampleLayout} />
      <Switch>
        <DocsLayout exact path='/' render={RedirectToIntro} />
        <DocsLayout exact path='/user/register' component={UserRegister} />
        <LayoutsLayout exact path='/layouts/:name' component={LayoutsRoot} />
        <DocsLayout exact path='/:type/:name' component={DocsRoot} />
        <DocsLayout exact path='/*' component={PageNotFound} />
      </Switch>
    </Switch>
  </BrowserRouter>
)

export default Router
