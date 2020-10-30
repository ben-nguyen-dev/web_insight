const initState = {
  postAdmin: [],
  listUser: [],
  pageCountListUser: 1,
  currentPageListUser: 1,
  pageCountListPost: 1,
  currentPageListPost: 1
};

const countTotalPage = (totalItem) => {
  if (totalItem % 10 === 0) return totalItem / 10;
  else return Math.floor(totalItem / 10) + 1;
};

export default (state = initState, action) => {
  switch (action.type) {
    case "SET_LIST_POST_ADMIN":
      return {
        ...state,
        postAdmin: action.payload.posts.data,
        currentPageListPost: action.payload.posts.current_page,
        pageCountListPost: countTotalPage(action.payload.posts.total)
      };
    case "SET_LIST_USER":
      return {
        ...state,
        listUser: action.payload.data,
        currentPageListUser: action.payload.current_page,
        pageCountListUser: countTotalPage(action.payload.total)
      };
    default:
      return state;
  }
};
