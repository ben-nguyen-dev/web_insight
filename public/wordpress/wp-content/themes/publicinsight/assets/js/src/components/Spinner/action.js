export const setLoading = (isLoading) => ({
  type: 'SET_LOADING',
  isLoading,
})

export const dispatchSetLoading = (isLoading) => dispatch => {
  dispatch(setLoading(isLoading));
}