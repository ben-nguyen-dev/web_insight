import React, { Component } from "react";
import {connect} from 'react-redux'
import {
  TabContent,
  TabPane,
  Row,
  Col,
  Nav,
  NavItem,
  NavLink,
  Modal,
  ModalHeader,
  ModalFooter,
  ModalBody,
  Button,
  FormGroup,
  Input,
} from "reactstrap";
import classnames from "classnames";
import PostAdmin from "./postAdmin";
import ListUser from "./listUser";
import CustomPagination from "../../components/CustomPagination";
import {dispatchSetLoading} from "../../components/Spinner/action"
import { getDetailPostAdmin, rejectPost, approvePost } from "../../api";
import AlertModal from "../../components/AlertModal";

const defaultImage = require("../../assets/Image/default_image.jpg");

class Admin extends Component {
  state = {
    activeTab: "2",
    isOpenDetail: false,
    isOpenNote: false,
    postShow: null,
    isOpenAlert: false,
    message: "",
    rejectMessage: ""
  };

  componentDidMount = () => {
    this.props.getListPost(1)
    this.props.getListUsers(1)
  };

  toggle = (tab) => {
    if (this.state.activeTab !== tab) this.setState({ activeTab: tab });
  };

  toggleModalDetail = () => {
    this.setState({ isOpenDetail: false });
  };

  toggleModalNote = () => {
    this.setState({ isOpenNote: false });
  };

  onClickAction = async (_id) => {
    try {
      this.props.dispatchSetLoading(true)
      const res = await getDetailPostAdmin(_id);
      const { post } = res.data

      if (post.state === "published") {
        window.location.href = post.url
        return 
      }

      this.setState({postShow: post, isOpenDetail: !this.state.isOpenDetail})
      this.props.dispatchSetLoading(false)
    } catch {
      this.props.dispatchSetLoading(false)
    }
  };

  showTag = (tags) => {
    if (tags.length === 0) return ""
    const textShow = tags.reduce((text,e, i) => {
      if (i === tags.length - 1) return text+e.name;
      return text + e.name +", " 
    }, "")
    return textShow
  }

  renderModalNoteReject = () => {
    const { postShow, rejectMessage } = this.state
    return (
      <Modal isOpen={this.state.isOpenNote} toggle={this.toggleModalNote} centered>
        <ModalHeader toggle={this.toggleModalNote}>
          Rejecting reason
        </ModalHeader>
        <ModalBody>
          <FormGroup>
            <Input
              type="textarea"
              name="text"
              id="exampleText"
              className="small"
              size="sm"
              rows={8}
              placeholder="Type something..."
              value={rejectMessage}
              onChange={e => this.setState({ rejectMessage: e.target.value })}
            />
          </FormGroup>
        </ModalBody>
        <ModalFooter>
          <Button
            color="secondary"
            onClick={() => {
              this.setState({ isOpenNote: false });
            }}
            size="sm"
          >
            Cancel
          </Button>
          <Button color="primary" onClick={() => this.rejectPostAdmin(postShow._id, rejectMessage)} size="sm">
            Send
          </Button>
        </ModalFooter>
      </Modal>
    );
  };

  rejectPostAdmin = async (_id, mess) => {
    try {
      this.props.dispatchSetLoading(true)
      const res = await rejectPost(_id, mess)
      console.log('resreject', res)
      this.props.dispatchSetLoading(false)
      this.setState({isOpenAlert: true, message: "This post has been rejected successfully", isOpenNote: false})
    } catch {
      this.props.dispatchSetLoading(false)
      this.setState({isOpenAlert: true, message: "An error occurred, please try again"})
    }
  }

  clickOk = () => {
    this.setState({
      isOpenAlert: false,
      isOpenDetail: false,
    })
    this.props.getListPost(1)
  }

  approvePostAdmin = async (_id) => {
    try{
      this.props.dispatchSetLoading(true)
      const res = await approvePost(_id)
      console.log('resapprove', res)
      this.props.dispatchSetLoading(false)
      this.setState({isOpenAlert: true, message: "This post has been approved successfully"})
    } catch {
      this.props.dispatchSetLoading(false)
      this.setState({isOpenAlert: true, message: "An error occurred, please try again"})
    }
  }

  toggleAlert = () => this.setState({isOpenAlert: !this.state.isOpenAlert})

  renderModalDetail = (post) => {
    return (
      <Modal isOpen={this.state.isOpenDetail} toggle={this.toggleModalDetail}>
        <ModalHeader className="font-weight-bold" toggle={this.toggleModalDetail}>Post Details</ModalHeader>

        <ModalBody>
          <div className="mb-2">
            <h6 className="font-weight-bold" >Headline</h6>
          </div>
          <div className="mb-2">
            <span>{(post && post.headline !==  "") ? post.headline: ""}</span>
          </div>
          <div className="mb-2">
            <h6 className="font-weight-bold" >Preamble</h6>
          </div>
          <div className="mb-2">
            <span>{(post && post.preamble !==  "") ? post.preamble: ""}</span>
          </div>
          <div className="mb-2">
            <h6 className="font-weight-bold" >Body</h6>
          </div>
          <div className="p-2 mb-2">
            <span dangerouslySetInnerHTML={{__html: (post && post.body !==  "") ? post.body: "non body"}}></span>
          </div>
          <div className="mb-2">
            <h6 className="font-weight-bold" >Tag</h6>
          </div>
          <div className="mb-2">
            <span>{(post && post.tags.length !==0) ? this.showTag(post.tags): ""}</span>
          </div>
          <div className="mb-2">
            <h6 className="font-weight-bold" >Authors</h6>
          </div>
          <div className="mb-2">
            <span>{(post && post.authors.length!==0) ? this.showTag(post.authors): ""}</span>
          </div>
          <div className="mb-2">
            <h6 className="font-weight-bold" >Main Image</h6>
          </div>
          {post && post.mainImageUrl  &&
            <img
              src={post.mainImageUrl}
              alt="avatar"
              className=" center-cropped mb-3"
              style={{ width: "100%", height: "300px", objectFit: "contain" }}
            />}
          {post && !post.mainImageUrl && 
            <span>
            {"non image"}
          </span>}
        </ModalBody>

        <ModalFooter className="d-flex">
          {post && this.renderFooterModalDetail(post)}
          {!post && <Button onClick={this.toggleModalDetail} color="secondary">Close</Button>}
        </ModalFooter>
      </Modal>
    );
  };

  renderFooterModalDetail = (post) => {
    if (post.state === 'submitted') return (
    <div>
      <Button
        color="danger"
        onClick={() => this.setState({isOpenNote: true})}
        size="sm"
      >
        Reject
      </Button>
      <Button
        color="primary"
        onClick={() => this.approvePostAdmin(post._id)} 
        size="sm"
        className="ml-2"
      >
        Accept
      </Button>
    </div>)
    return <Button size="sm" onClick={this.toggleModalDetail} color="secondary">Close</Button>
  }  

  render() {
    return (
      <div className="container">
        <Nav tabs>
          <NavItem style={{ cursor: "pointer" }}>
            <NavLink
              className={classnames({ active: this.state.activeTab === "1" })}
              onClick={() => {
                this.toggle("1");
              }}
            >
              Users
            </NavLink>
          </NavItem>
          <NavItem style={{ cursor: "pointer" }}>
            <NavLink
              className={classnames({ active: this.state.activeTab === "2" })}
              onClick={() => {
                this.toggle("2");
              }}
            >
              Posts
            </NavLink>
          </NavItem>
        </Nav>
        <TabContent activeTab={this.state.activeTab}>
          <TabPane tabId="1">
            <ListUser />
          </TabPane>
          <TabPane tabId="2">
            <Row className="mt-3">
              <Col sm={12}>
                <PostAdmin onClickAction={this.onClickAction} postAdmin={this.props.postAdmin}/>
              </Col>
            </Row>
            <Row>
              <Col md={12}>
                <CustomPagination
                  pageCount={this.props.pageCountListPost}
                  currentPage={this.props.currentPageListPost}
                  changePage={(currentPage) => {
                    this.props.getListPost(currentPage);
                  }}
                />
              </Col>
            </Row>
          </TabPane>
        </TabContent>
        {this.renderModalDetail(this.state.postShow)}
        {this.renderModalNoteReject()}
        <AlertModal isOpen={this.state.isOpenAlert} message={this.state.message} toogle={this.toggleAlert} clickOk={this.clickOk}/>
      </div>
    );
  }
}

const mapDispatchToProps = {
  dispatchSetLoading
}

export default connect(null, mapDispatchToProps)(Admin);
