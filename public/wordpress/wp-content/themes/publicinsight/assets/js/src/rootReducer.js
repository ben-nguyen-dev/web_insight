import { combineReducers } from "redux";

import loading from "./components/Spinner/reducer";
import admin from "./containers/Admin/redux/reducers";

const root = {
  loading,
  admin
};

export default combineReducers(root);
