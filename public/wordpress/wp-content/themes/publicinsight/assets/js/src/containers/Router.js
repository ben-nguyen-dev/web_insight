import React from 'react'
import { Route, Switch, HashRouter } from "react-router-dom";

import routes from "../configs/routes"

export default () => <HashRouter>
<Switch>
  {routes.map((route, index) => <Route key={index} exact path={route.path} component={route.component} />)}
</Switch>
</HashRouter>