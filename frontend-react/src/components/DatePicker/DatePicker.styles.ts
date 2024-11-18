import styled from "styled-components";

export const StyledDateInput = styled.input`
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
  width: 100%;
  max-width: 180px;
  background-color: #fff;
  color: #333;
  fill: #333;
  &:focus {
    border-color: #007BFF;
    outline: none;
  }
`;