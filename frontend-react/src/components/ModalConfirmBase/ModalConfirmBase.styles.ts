import styled from "styled-components";

export const ModalWrapper = styled.div`
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
`;

export const ModalContainer = styled.div`
    display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 400px;
  padding: 44px;
  background: ${({ theme }) => theme.colors.textColor};
  border-radius: 16px;
  margin: auto;
  gap: 32px;
`;

export const IconContainer = styled.div`
  display: flex;
  justify-content: center;
  align-items: center;
  width: 40px;
  height: 40px;
  color: ${({ theme }) => theme.colors.textColor};
  background-color: #930000;
`;

export const ModalContent = styled.div`
  text-align: center;
  color: ${({ theme }) => theme.colors.textColorSecondary};
  font-size: 22px;
  font-weight: 600;
`;

export const ModalConfirmHeader = styled.div`
  align-self: stretch;
  display: flex;
  justify-content: flex-end;
  align-items: center;
`;

export const ModalFooter = styled.div`
  display: flex;
  justify-content: space-between;
  gap: 2rem;
`;