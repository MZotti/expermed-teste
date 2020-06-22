import React from 'react';
import { BrowserRouter, Route, Switch } from 'react-router-dom';

import Upload from './pages/upload';

export default function Routes(){
    return(
        <BrowserRouter>
            <Switch>
                <Route path="/" component={Upload}/>
                <Route path="/upload" component={Upload}/>
            </Switch>
        </BrowserRouter>
    )
}