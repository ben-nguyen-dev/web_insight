import React, { Component } from "react";
import { Modal, ModalHeader, ModalFooter, ModalBody, Button } from "reactstrap";

export default class AlertModal extends Component {
  render() {
      const {message, isOpen, toggle, clickOk} = this.props;
    return (
      <Modal isOpen={isOpen} toggle={toggle}>
        <ModalHeader toggle={toggle}>Alert</ModalHeader>
        <ModalBody>{message}</ModalBody>
        <ModalFooter>
          <Button color="primary" onClick={() => clickOk()}>
            Ok
          </Button>
        </ModalFooter>
      </Modal>
    );
  }
}
