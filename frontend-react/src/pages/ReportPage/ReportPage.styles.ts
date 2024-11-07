import styled from "styled-components";
import { H2 } from "../Login/Login.styles";
import { SpanInfo } from "../CreateEditTaskList/CreateTaskList.styles";

export const StyledContainerReport = styled.div`
  display: flex;
  justify-content: center;
  width: 100%;
  margin: 2rem auto;
`;

export const CardReport = styled.div`
  background: ${({theme}) => theme.colors.textColor};
  border-radius: 16px;
  box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
  backdrop-filter: blur(6.7px);
  max-width: 700px;
  width: 100%;
  padding: 2rem;
  color: ${({theme}) => theme.colors.bgColor};
  display: flex;
  flex-direction: column;
`;

export const StyledH2 = styled(H2)`
  color: ${({theme}) => theme.colors.bgBackground}!important;
`;

export const StyledH3 = styled.h3`
  font-size: 1.5rem; 
  color: ${({theme}) => theme.colors.bgColor};
  margin-bottom: 1rem;
`

export const StyledP = styled.p`
  font-size: 1.1rem;
`
export const SpanInfoStyled = styled(SpanInfo)`
  text-align: start;
`;