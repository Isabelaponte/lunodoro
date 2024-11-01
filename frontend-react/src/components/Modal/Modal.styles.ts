import { Modal } from '@mui/material';
import styled from 'styled-components';

export const StyledModals = styled(Modal)`
  &.MuiModal-root {
    display: flex;
    align-items: center;
    justify-content: center;
    overflow-y: scroll !important;
  }

  .MuiBackdrop-root {
    background-color: rgba(0, 0, 0, 0.5);
  }

  .MuiPaper-root {
    min-width: 971px !important;
    background-color: white;
    overflow-y: auto !important;
    padding: 44px;
    width: 806px;
    height: 80vh;
    z-index: 1300;
  }
`;

export const ModalContainer = styled.section`
  background-color: ${({ theme }) => theme.colors.textColor};
  max-height: 90%;
  width: 600px;
  overflow: hidden;
  padding: 44px;
  border-radius: 8px;
  display: flex;
  flex-direction: column;
  gap: 24px;
`;

export const ModalHeader = styled.header`
  display: flex;
  justify-content: space-between;
  width: 100%;
`;

export const ModalName = styled.h2`
  font-size: 26px;
  font-weight: 700;
  color: ${({ theme }) => theme.colors.textColorSecondary};
  margin: 0!important;
`;
