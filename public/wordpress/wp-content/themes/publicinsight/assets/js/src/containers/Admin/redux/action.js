import { setLoading } from "../../../components/Spinner/action";
import { getListPostAdmin, getListUser, updateAllowCreatePost } from "../../../api";

export const getListPost = (page) => async (dispatch) => {
  dispatch(setLoading(true));
  try {
    const res = await getListPostAdmin(page);
    dispatch({type: "SET_LIST_POST_ADMIN", payload: res.data})
    dispatch(setLoading(false));
  } catch (err) {
    dispatch(setLoading(false));
  }
};

export const getListUsers = (page) => async (dispatch) => {
    dispatch(setLoading(true));
    try {
      const res = await getListUser(page);
      dispatch({type: "SET_LIST_USER", payload: res.data.users})
      dispatch(setLoading(false));
    } catch (err) {
      dispatch(setLoading(false));
    }
}

export const updateAllowCreate = (id, page) => async dispatch => {
    dispatch(setLoading(true));
    try {
      await updateAllowCreatePost(id)
      const res = await getListUser(page);
      dispatch({type: "SET_LIST_USER", payload: res.data.users})
      dispatch(setLoading(false));
    } catch (err) {
      dispatch(setLoading(false));
    }
}
