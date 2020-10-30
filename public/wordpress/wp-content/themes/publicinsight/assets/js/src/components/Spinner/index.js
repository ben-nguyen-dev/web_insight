import React from 'react';
import { connect } from "react-redux";

const loadingStyle = {
  display: "flex",
  justifyContent: "center",
  alignItems: "center",
  width: "100vw",
  height: "100vh",
  position: "fixed",
  top: 0,
  left: 0,
  zIndex: 99999,
  background: "rgba(0, 0, 0, 0.3)"
}

export const Spinner = ({ isLoading }) => {
    return (isLoading ? (
        <div style={loadingStyle}>
          <div className="spinner-border text-primary" role="status">
            <span className="sr-only">Loading...</span>
          </div>
        </div>
    ) : null);
};

const mapStateToProps = state => ({
  isLoading: state.loading.isLoading
});

export default connect(
  mapStateToProps,
  null,
)(Spinner);