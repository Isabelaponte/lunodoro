import { Card, Container } from '@mui/material';
import styled from 'styled-components';


export const StyledContainerHome = styled(Container)`
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 64px 0;
`;

export const CardHome = styled(Card)`
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
  padding: 12px 20px;
  font-size: 0.9rem;
  border-radius: 25px;
  cursor: pointer;
  transition: all 0.3s ease;
  max-width: fit-content;
`;