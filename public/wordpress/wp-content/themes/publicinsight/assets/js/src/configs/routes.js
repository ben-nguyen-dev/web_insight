import MyPost from "../containers/MyPost"
import CreatePost from "../containers/CreatePost"

export default [
    { path: "/", name: "My post", component: MyPost },
    { path: "/post/:id", name: "Post", component: CreatePost },
    { path: "/create-post", name: "Create post", component: CreatePost },
]