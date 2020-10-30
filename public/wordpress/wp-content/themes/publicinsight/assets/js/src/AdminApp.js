import * as React from "react";
import "./App.scss";
import Spinner from "./components/Spinner";
import store from "./store";
import { Provider } from "react-redux";
import Admin from "./containers/Admin";
import DeleteModal from "./components/DeleteModal";

import fixDropdown from "./utils/fixDropdown"

const App = () => {
  React.useEffect(() => fixDropdown(), [])
  return (
    <Provider store={store}>
      <Spinner />
      <Admin />
      <DeleteModal ref={DeleteModal.registerModal} />
    </Provider>
  );
};

export default App;
