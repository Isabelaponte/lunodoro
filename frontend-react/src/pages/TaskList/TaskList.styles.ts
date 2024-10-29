import { Container } from '@mui/material';
import styled from 'styled-components';

export const ContainerTaskList = styled(Container)`
  padding: 45px!important;
`;

export const StyledCardTaskList = styled.div`
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  max-width: 450px;
  padding: 24px;
`;

export const StyledButton = styled.button`
  background-color: ${({theme}) => theme.colors.secondaryButton};
  border: none;
  margin-top: 16px;
  padding: 0.5rem 1rem;
  font-size: 0.875rem;
  border-radius: 25px;
  cursor: pointer;
  transition: all 0.3s ease;
  max-width: fit-content;
`;