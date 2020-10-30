import React, { Component } from 'react';
import { Button, Modal, ModalBody, ModalFooter, ModalHeader } from 'reactstrap';

let modal

export default class DeleteModal extends Component {
  static registerModal = (ref) => {
    modal = ref
  }

  static show = (name, onDelete) => {
    if (modal) {
      modal.setState({ isOpen: true, name, onDelete })
    } else {
      throw new Error('You must registerModal(ref) first')
    }
  }

  state = {
    name: '',
    isOpen: false,
    onDelete: () => null,
  }

  render() {
    const { isOpen, name } = this.state
    return (
      <Modal
        isOpen={isOpen}
        toggle={this.toggle}
      >
        <ModalHeader toggle={this.toggle}>
          Delete {name}
        </ModalHeader>
        <ModalBody>
          Are you sure you want to delete {name}?
      </ModalBody>
        <ModalFooter>
          <Button
            color="danger"
            onClick={this.onYesClick}
          >Delete</Button>
          <Button
            color="secondary"
            onClick={this.toggle}
          >Cancel</Button>
        </ModalFooter>
      </Modal>
    );
  }

  toggle = () => {
    this.setState({ isOpen: !this.state.isOpen })
  }

  onYesClick = () => {
    this.toggle()
    this.state.onDelete()
  }

}
