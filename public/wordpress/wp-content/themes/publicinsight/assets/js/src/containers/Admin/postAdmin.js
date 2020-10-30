import React, { Component } from "react";
import { Table, Button, Row, Col } from "reactstrap";
import IC_EYE from "../../assets/Icons/eye.png";
import { getStateString } from '../../utils/postUtils';

export default class PostAdmin extends Component {

  componentDidMount = () => {
    // this.getListPost(1)
  }

  renderAction = (_id) => {
    return (
      <div className="d-flex align-items-center justify-content-center">
        <img
          src={IC_EYE}
          style={{ height: 20, width: 20, cursor: "pointer" }}
          onClick={() =>this.props.onClickAction(_id)}
          alt="aaa"
        />
      </div>
    );
  };

  renderEmail = (email) => {
    return <Button color="link" className="d-flex align-items-center"><span style={{textDecorationLine: 'underline'}}>{email}</span></Button>;
  };

  showTag = (tags) => {
    if (tags.length === 0) return ""
    const textShow = tags.reduce((text,e, i) => {
      if (i === tags.length - 1) return text+e.name;
      return text + e.name +", " 
    }, "")
    return textShow
  }

  render() {
    const { onClickAction, postAdmin } = this.props;
    return (
      <Row className="mt-2">
        <Col md="12">
          <Table bordered hover size="sm" className="table table-striped">
            <thead>
              <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Tags</th>
                <th>Created By</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              {postAdmin &&
                postAdmin.map((e, index) => (
                  <tr key={index}>
                    <td className="align-middle">{e.headline}</td>
                    <td className="align-middle">
                      {this.showTag(e.authors)}
                    </td>
                    
                    <td className="align-middle">{this.showTag(e.tags)}</td>
                    <td className="align-middle">
                    {e.user.fullName}
                    </td>
                    <td className="align-middle">{getStateString(e.state)}</td>
                    <td className="align-middle">{this.renderAction(e._id)}</td>
                  </tr>
                ))}
            </tbody>
          </Table>
        </Col>
      </Row>
    );
  }
}
