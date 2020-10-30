import React, { Component } from "react";
import { Modal, ModalHeader, ModalFooter, ModalBody, Button } from "reactstrap";

export default class AlertModal extends Component {
  render() {
    const {message, isOpen, toggle, callback, noCancel} = this.props;
    return (
      <Modal isOpen={isOpen} toggle={() => {
        if (noCancel && callback) callback()
        toggle()
      }}>
        <ModalHeader toggle={() => {
          if (noCancel && callback) callback()
          toggle()
        }}>Alert</ModalHeader>
        <ModalBody>{message}</ModalBody>
        <ModalFooter>
          <Button color="primary" onClick={() => {
            if (callback) callback()
            toggle()
          }}>
            Ok
          </Button>
          {callback && !noCancel && <Button color="secondary" onClick={toggle}>
            Cancel
          </Button> }
        </ModalFooter>
      </Modal>
    );
  }
}
