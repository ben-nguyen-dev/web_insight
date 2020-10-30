const loadingReducer = (
  state = {
    isLoading: false,
  },
  action,
) => {
  switch (action.type) {
    case "SET_LOADING":
      return {
        ...state,
        isLoading: action.isLoading,
      };
    default:
      return state;
  }
};

export default loadingReducer;
