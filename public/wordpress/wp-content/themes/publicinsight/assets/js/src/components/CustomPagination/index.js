import React, { Component } from "react";
import { Pagination, PaginationItem, PaginationLink, Label, Input } from "reactstrap";
import CustomSelected from '../CustomSelect';

class CustomPagination extends Component {
  constructor(props) {
    super(props);
    this.state = {
      pageNumberInput: this.props.currentPage || 1,
    };
  }

  componentDidUpdate(prevProps) {
    const prevCurrentPage = prevProps.currentPage;
    if (this.props.currentPage && prevCurrentPage !== this.props.currentPage) {
      this.setState({ pageNumberInput: this.props.currentPage });
    }
  }

  onKeyUp = e => {
    if (e.keyCode === 13) {
      this.props.changePage(parseInt(this.state.pageNumberInput), this.props.changePageParams);
    }
  };

  onChangePageNumber = e => {
    this.setState({
      pageNumberInput: e.target.value,
    });
  };

  onNextClick = () => {
    this.changePage("relative", 1);
  };

  onPrevClick = () => {
    this.changePage("relative", -1);
  };

  clickFirstPage = () => {
    this.changePage("absolute", 1);
  };

  clickLastPage = () => {
    this.changePage("absolute", this.props.pageCount);
  };

  changePage = (type, pageNumber) => {
    let newPage = 1;
    if (type === "relative") {
      const { currentPage } = this.props;
      newPage = parseInt(currentPage) + pageNumber;
    }
    if (type === "absolute") {
      newPage = pageNumber;
    }

    this.props.changePage(newPage, this.props.changePageParams);
    this.setState({ pageNumberInput: newPage.toString() });
  };

  options = [{ label: 10, value: 10 }, { label: 20, value: 20 }, { label: 50, value: 50 }, { label: 100, value: 100 }]

  render() {
    const prevDisabled = this.props.currentPage <= 1 || !this.props.currentPage;
    const nextDisabled = this.props.currentPage >= this.props.pageCount || !this.props.currentPage;
    return (
      <Pagination className="grid-pagination d-flex justify-content-end">
        <div style={{ width: 80 }} className="mr-2">
          {this.props.pageSize &&
            <CustomSelected
              value={{ label: this.options.filter(option => option.value === this.props.pageSize)[0].label, value: this.props.pageSize }}
              style={{ width: 40 }}
              options={this.options}
              onChange={async e => {
                if (this.props.pageSize === e) return;
                await this.props.changePageSize(e.value)
                this.props.onChangePageSize()
              }}
            />
          }

        </div>

        <PaginationItem disabled={prevDisabled}>
          <PaginationLink
            disabled={prevDisabled}
            onClick={this.onPrevClick}
            previous
            tag="button"
          >
            Prev
          </PaginationLink>
        </PaginationItem>
        <PaginationItem>
          <PaginationLink onClick={this.clickFirstPage} tag="button">
            1
            </PaginationLink>
        </PaginationItem>

        <Label className="page-input-label" htmlFor="pageNumberInput" />
        <input
          type="text"
          onKeyUp={this.onKeyUp}
          onChange={this.onChangePageNumber}
          value={this.state.pageNumberInput}
          className="mx-2 p-0 text-center"
          style={{ width: '45px', border: '1px solid #dee2e6', color: '#007bff' }}
        />
        <PaginationItem>
          <PaginationLink onClick={this.clickLastPage} tag="button">
            {this.props.pageCount || 1}
          </PaginationLink>
        </PaginationItem>

        <PaginationItem disabled={nextDisabled}>
          <PaginationLink disabled={nextDisabled} onClick={this.onNextClick} next tag="button">
            Next
          </PaginationLink>
        </PaginationItem>
      </Pagination>
    );
  }
}

export default CustomPagination
