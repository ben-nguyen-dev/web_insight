import cn from 'classnames';
import React, { useEffect, useMemo, useState } from 'react';
import Select from 'react-select';
import { Input, Label, Pagination, PaginationItem, PaginationLink } from 'reactstrap';


const DefaultPagination = ({ onChangePage, page, pageSize = 10, count = 0, onChangePageSize, hidePageSize, className }) => {
  const totalPage = Math.ceil(count / pageSize)
  const pageSizes = useMemo(() =>
    [10, 30, 50, 100].map(i => ({ value: i, label: i })), [])
  const [pageInput, setPageInput] = useState(page)

  useEffect(() => {
    setPageInput(page)
  }, [page])

  return (
    <Pagination className={cn("grid-pagination", className)}>
      {!hidePageSize ? (
        <Select
          styles={{
            container: (p) => ({
              ...p,
              marginRight: "0.5rem",
              width: 70,
              height: 32,
            }),
            indicatorsContainer: (p) => ({
              ...p,
              margin: -4,
              width: 40,
            }),
            control: (p) => ({
              ...p,
              borderRadius: 0,
              minHeight: 32,
            }),
          }}
          value={pageSizes.find(i => i.value === pageSize)}
          options={pageSizes}
          onChange={(e) => {
            const newPageSize = Number(e && e.value)
            if (newPageSize !== pageSize && onChangePageSize) {
              onChangePageSize(newPageSize)
              onChangePage(1)
            }
          }}
        />
      ) : null}
      <PaginationItem disabled={page < 2}>
        <PaginationLink
          onClick={() => onChangePage(page - 1)}
          previous
          tag="button"
        >
          Prev
              </PaginationLink>
      </PaginationItem>
      <PaginationItem>
        <PaginationLink onClick={() => onChangePage(1)} tag="button">
          1
            </PaginationLink>
      </PaginationItem>

      <Label className="page-input-label" htmlFor="pageNumberInput" />
      <input
        type="text"
        value={pageInput}
        onChange={e => setPageInput(Number(e.target.value) || 1)}
        className="mx-2 p-0 text-center"
        onKeyUp={(e) => { if (e.keyCode === 13) { onChangePage(pageInput) } }}
        style={{ width: '45px', border: '1px solid #dee2e6', color: '#007bff' }}
      />
      <PaginationItem>
        <PaginationLink onClick={() => { onChangePage(totalPage) }} tag="button">
          {totalPage}
        </PaginationLink>
      </PaginationItem>

      <PaginationItem disabled={page > totalPage - 1}>
        <PaginationLink onClick={() => { onChangePage(page + 1) }} next tag="button">
          Next
              </PaginationLink>
      </PaginationItem>
    </Pagination>
  )
}

export default DefaultPagination
