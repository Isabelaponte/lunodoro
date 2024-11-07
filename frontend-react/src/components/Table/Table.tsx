import { TableBody, TableRow } from "@mui/material";
import { StyledTable, StyledTableHeader, StyledCellHeader, StyledCell } from "./Table.style";

const rows: any = [
    {
      id: 1,
      data: "-",
      categories: ["-"],
      projects: ["-"],
      owner: "-",
      minutes: "-",
    },
];

const columns = [
  { field: "data", headerName: "Data"},
  { field: "projects", headerName: "Projeto/Tarefa" },
  { field: "minutes", headerName: "Minutos" },
];

const TableComponent = () => {
  return (
    <>
      <StyledTable>
        <StyledTableHeader>
          <TableRow>
            {columns.map((column) => (
              <StyledCellHeader key={column.field}>
                {column.headerName}
              </StyledCellHeader>
            ))}
          </TableRow>
        </StyledTableHeader>

        <TableBody>
          {rows.length > 0 &&
            rows.map((row : any) => (
              <TableRow key={row.id}>
                <StyledCell>{row.data}</StyledCell>
                <StyledCell>{row.projects}</StyledCell>
                <StyledCell>{row.minutes}</StyledCell>
                <StyledCell align="right"></StyledCell>
              </TableRow>
            ))}
        </TableBody>
      </StyledTable>
    </>
  );
};

export default TableComponent;
