import React, { useRef } from "react";
import { IC_DELETE, IC_EDIT, IC_EYE } from "../../assets";
import { Row, Col, Button } from "reactstrap";
import {
  POST_STATE,
  POST_STATE_COLOR,
  POST_TYPE_COLOR,
} from "../../utils/contants";
import { Link } from "react-router-dom";
import cn from "classnames";
import DeleteModal from "../../components/DeleteModal";
import { deletePost } from "../../api";

const defaultImage = require("../../assets/Image/default_image.jpg");

const MyPostRow = ({ post, reload, checkUser }) => {
  const tags = post.tags.map((i) => i.name);
  const tag = tags[0] || "";

  const onDelete = () => {
    DeleteModal.show("post", async () => {
      try {
        await deletePost({ id: post._id });
        reload();
      } catch (error) {}
    });
  };

  return (
    <Row className="pb-2 mb-2 border-bottom">
      <Col md="8">
        <div className="d-flex flex-column justify-content-between h-100">
          <div>
            <div className="font-weight-bold">{tag}</div>
            <Link to={checkUser && post.state !== "published" && post.state !== "submitted" && `/post/${post._id}`} className="p-0 text-dark">
              <i
                className={
                  `fas fa-square-full ${POST_TYPE_COLOR[post.type]} i-small`}
              />
              <span className="font-weight-bold" onClick={() => {
                if (post.state === "published") { 
                  window.location.href = (post.url) 
                }
              } }>{post.headline}</span>
            </Link>
            <div>
              <div
                style={{
                  display: "block",
                  overflow: "hidden",
                  height: "50px",
                  color: "gray",
                }}
              >
                {post.preamble}
              </div>
            </div>
          </div>
          <div>
            <span
              className="font-italic"
              style={{ color: POST_STATE_COLOR[post.state] || "black" }}
            >
              {POST_STATE[post.state]}
            </span>
          </div>
        </div>
      </Col>
      <Col md="3" className="d-flex align-items-center">
        <img
          src={post.thumbnailUrl || defaultImage}
          alt="mainImage"
          style={{ width: "100%", height: "150px", objectFit: "contain" }}
        />
      </Col>
      <Col className="d-flex flex-column align-items-center">
        {post.state !== "published" && post.state !== "submitted" && checkUser && <Link
          to={`/post/${post._id}`}
        >
          <img
            alt="edit"
            src={IC_EDIT}
            style={{ height: "25px", width: "25px" }}
          />
        </Link>}
        {checkUser && <Button outline size="sm" style={{ border: "none" }} onClick={onDelete}>
          {" "}
          <img
            alt="delete"
            src={IC_DELETE}
            style={{ height: "25px", width: "25px" }}
          />
        </Button>}
        {post.state === "published" && <Button outline size="sm" style={{ border: "none" }} onClick={() => window.location.href = (post.url)}>
          {" "}
          <img
            alt="view"
            src={IC_EYE}
            style={{ height: "25px", width: "25px" }}
          />
        </Button>}
      </Col>
    </Row>
  );
};

export default MyPostRow;
