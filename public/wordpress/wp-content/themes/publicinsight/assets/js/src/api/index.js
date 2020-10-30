import axios from 'axios';

const BASE_ENDPOINT = 'http://publiccloud.local/pi/wp-json'
// const BASE_ENDPOINT = 'http://pipro-env-stage.eba-28wbv7ib.eu-north-1.elasticbeanstalk.com/'
export const api = axios.create({
  baseURL: BASE_ENDPOINT,
  timeout: 30000,
  headers: {
    "Content-Type": "application/json",
  },
})

export const apiUpload = axios.create({
  baseURL: BASE_ENDPOINT,
  timeout: 15000,
  headers: {
    "Content-Type": "multipart/form-data",
  }
});

// Admin
export const getDetailPostAdmin = (_id) => api.get(`/api/post/get?id=${_id}`);
export const getListPostAdmin = (page) => api.get(`/api/post/list?page=${page}`);
export const approvePost = (_id) => api.post('/api/post/approve', {id: _id})
export const rejectPost = (_id, message) => api.post('/api/post/reject', { id: _id, message });

// My Post
export const getDetailPost = (_id) => api.get(`/api/my-post/get?id=${_id}`);
export const getMyPostList = ({ page, state, type }) => api.get(`/api/my-post/list`, { params: { page, state, type } })
export const createPost = (data) => api.post('/api/my-post/save', data);
export const deletePost = ({ id }) => api.delete('/api/my-post/delete', { params: { id } })

// Author
export const getAuthors = (page) => api.get(`/api/author/search?page=${page}`);

// Tag
export const getTags = (page) => api.get(`/api/tag/search?page=${page}`)

export const getAuthId = () => api.get('/api/getAuth0Id');

export const getListUser = (page) => api.get(`/api/user/getUsers?page=${page}`);

export const updateAllowCreatePost = id => api.put(`/api/user/updateAllowCreatePost?id=${id}`)
