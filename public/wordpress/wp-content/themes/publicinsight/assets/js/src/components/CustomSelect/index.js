import React from 'react'
import { FormGroup, Label } from 'reactstrap';
import Select from "react-select";

export default class CustomSelected extends React.PureComponent {
    render() {
        return (
            <FormGroup>
                {this.props.label && <Label>{this.props.label}</Label>}
                <Select
                    {...this.props}
                />
            </FormGroup>
        )
    }
}