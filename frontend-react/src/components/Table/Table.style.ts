import { Table, TableCell, TableHead } from '@mui/material';
import styled from 'styled-components';

export const StyledTable = styled(Table)`
  margin-top: 1rem;
  min-width: 800px;
`;

export const StyledCell = styled(TableCell)`
  padding: 8px;
  padding: 0px 22px!important;
  height: 41px;
  border: none!important;
  `;

export const StyledCellHeader = styled(StyledCell)`
  background-color: #ddd;
  font-weight: 600!important;
  padding: 0 22px!important;

  &:first-child {
    border-radius: 8px 0 0 8px;
  }

  &:last-child {
    border-radius: 0 8px 8px 0;
  }
  `;

export const StyledTableHeader = styled(TableHead)`
  background-color: #f4f4f4;
  height: 41px!important;
`;