import { TextField } from "@mui/material";
import styled from "styled-components";

export const InputBox = styled.div`
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: start;
`;

export const Label = styled.label`
  color: ${({ theme }) => theme.colors.textColorSecondary};
  line-height: 5px;
`;

export const InputFieldStyled = styled(TextField)`
  &.MuiFormControl-root {
    width: 100%;

    & .MuiOutlinedInput-root {
      color: ${({ theme }) => theme.colors.bgColor};

      & .MuiOutlinedInput-input {
        padding: 10px;

        &::placeholder {
          color: ${({ theme }) => theme.colors.textColor};
        }
      }

      & .MuiInputAdornment-positionStart {
        margin-right: -4px;
      }

      & .MuiInputAdornment-positionEnd {
        margin-left: -4px;
      }
    }
  }
`;