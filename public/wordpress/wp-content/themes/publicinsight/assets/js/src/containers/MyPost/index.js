import React, { useState } from "react";
import { Row, Col, Button, Alert, Progress } from "reactstrap";
import { Link } from "react-router-dom";
import idx from 'idx';
import { useAsync } from 'react-async';
import { getMyPostList } from "../../api";
import MyPostRow from './MyPostRow';
import DefaultPagination from "../../components/DefaultPagination";
import { POST_STATE } from '../../utils/contants';
import cn from 'classnames';

const MyPost = () => {
  const [page, setPage] = useState(1)
  const [state, setState] = useState('')

  const url = new URL(window.location.href)
  const type = url.searchParams.get('type')
  //$(".filter-type").text()
  const { data, isLoading, reload } = useAsync({
    promiseFn: getMyPostList,
    page,
    state,
    type,
    watchFn: (prev, current) => prev.page !== current.page ||
      prev.state !== current.state
  })

  const posts = idx(data, _ => _.data.posts.data) || []
  const total = idx(data, _ => _.data.posts.total) || 0
  const checkUser = idx(data, _ => _.data.posts.allowCreatePost) || false
  return (
    <div className="container mt-3">
      <Row>
        <Col md="12" className="d-flex flex-row justify-content-between mb-3">
          <h4>MY POSTS</h4>
          {checkUser && <Link className="btn btn.primary" style={{ backgroundColor: '#007bff', color: '#fff' }} to="/create-post">Create new post</Link>}
        </Col>
        <Col md="3">
          <h6>Filters</h6>
          {['', ...Object.keys(POST_STATE)].map(key => (
            <Row key={key}>
              <Button color="link" className="text-dark" onClick={() => {
                setState(key)
                setPage(1)
              }}>
                <i className={cn("far mr-1", key === state ? "fa-check-square" : "fa-square")} />
                {POST_STATE[key] || 'All'}
              </Button>
            </Row>
          ))}
        </Col>
        {isLoading ? (
          <Col>
            <Progress animated value={100} />
          </Col>
        ) : (posts.length ? (
          <Col md="9">
            {posts.map(post => (
              <MyPostRow
                key={post._id}
                post={post}
                reload={reload}
                checkUser={checkUser}
              />
            ))}
            <Row>
              <Col md={12} className="p-0 d-flex justify-content-end">
                <DefaultPagination
                  hidePageSize
                  page={page}
                  count={total}
                  onChangePage={setPage}
                />
              </Col>
            </Row>
          </Col>
        ) : (
            <Col md="9">
              <Alert color="primary">No post found.</Alert>
            </Col>
          ))}
      </Row>
    </div>
  )
}

export default MyPost