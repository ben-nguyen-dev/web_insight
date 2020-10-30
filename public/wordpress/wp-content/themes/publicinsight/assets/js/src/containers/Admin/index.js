import { connect } from "react-redux";
import { getListUsers, getListPost } from "./redux/action";
import View from "./View";

const mapStateToProps = (state) => ({
  listUser: state.admin.listUser,
  postAdmin: state.admin.postAdmin,
  currentPageListUser: state.admin.currentPageListUser,
  pageCountListUser: state.admin.pageCountListUser,
  pageCountListPost: state.admin.pageCountListPost,
  currentPageListPost: state.admin.currentPageListPost
});

const mapDispatchToProps = {
  getListUsers,
  getListPost,
};

export default connect(mapStateToProps, mapDispatchToProps)(View);
