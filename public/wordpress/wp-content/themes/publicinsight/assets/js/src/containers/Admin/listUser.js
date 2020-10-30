import React, { Component } from "react";
import { connect } from 'react-redux'
import { Row, Col, Table, CustomInput } from "reactstrap";
import { getListUsers, updateAllowCreate } from "../Admin/redux/action"
import CustomPagination from "../../components/CustomPagination";

class ListUser extends Component {
  componentDidMount() {
    // this.getData()
  }

  getData = () => {
    const {getListUsers, currentPage} = this.props
    getListUsers(currentPage)
  }

  render() {
    const { listUser } = this.props;
    return (
      <>
      <Row className="mt-3">
        <Col md="12">
          <Table bordered hover size="sm" className="table table-striped">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Company</th>
                <th>Address</th>
                <th>Allow create post</th>
              </tr>
            </thead>
            <tbody>
              {listUser &&
                listUser.map((e, index) => (
                  <tr key={index}>
                    <td className="align-middle">{e.fullName}</td>
                    <td className="align-middle">{e.email}</td>
                    <td className="align-middle">{e.companyName}</td>
                    <td className="align-middle">{e.addrLine1}</td>
                    <td className="text-center">
                      <CustomInput 
                        type="checkbox"
                        id={e._id}
                        checked={e.allowCreatePost}
                        onClick={() => this.props.updateAllowCreate(e._id, this.props.currentPage)}
                      />
                      {/* {e.allowCreatePost ? 'true' : 'false'} */}
                    </td>
                  </tr>
                ))}
            </tbody>
          </Table>
        </Col>
      </Row>
      <Row>
        <Col md={12} >
          <CustomPagination
            pageCount={this.props.pageCountListUser}
            currentPage={this.props.currentPage}
            changePage={(currentPage) => {
              this.props.getListUsers(currentPage);
            }}
          />
        </Col>
      </Row>
    </>
    );
  }
}

const mapStateToProps = state => ({
  listUser: state.admin.listUser,
  currentPage: state.admin.currentPageListUser,
  pageCountListUser: state.admin.pageCountListUser,
})

const mapDispatchToProps = {
  getListUsers,
  updateAllowCreate
}

export default connect(mapStateToProps, mapDispatchToProps)(ListUser)