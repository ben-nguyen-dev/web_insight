import * as React from "react";
import './App.scss'
import Spinner from "./components/Spinner";
import store from "./store";
import { Provider } from "react-redux";
import DeleteModal from './components/DeleteModal';
import Router from "./containers/Router"

import fixDropdown from "./utils/fixDropdown"

const App = () => {
  React.useEffect(() => {
    fixDropdown()
  }, [])
  
  return (
    <Provider store={store}>
      <Spinner />
      <Router />
      <DeleteModal ref={DeleteModal.registerModal} />
    </Provider>
  );
};

export default App;
