import { IconButton, Modal } from "@mui/material";
import {
  IconContainer,
  ModalConfirmHeader,
  ModalContainer,
  ModalContent,
  ModalFooter,
  ModalWrapper,
} from "./ModalConfirmBase.styles";
import { Close } from "@mui/icons-material";
import { StyledButton } from "../CardTask/CardTask.styles";
import { CancelButton } from "../../pages/CreateEditTaskList/CreateTaskList.styles";

interface ModalConfirmBaseProps {
  open: boolean;
  onClose: () => void;
  onConfirm?: () => void;
  content: React.ReactNode;
  confirmText: string;
  cancelText: string;
  icon?: React.ReactNode;
}

const ModalConfirmBase = ({ ...props }: ModalConfirmBaseProps) => {
  return (
    <Modal open={props.open} onClose={props.onClose}>
      <ModalWrapper>
        <ModalContainer>
          <ModalConfirmHeader>
            <IconButton data-testid="close-modal" onClick={props.onClose}>
              <Close />
            </IconButton>
          </ModalConfirmHeader>
          {
            props.icon && <IconContainer>{props.icon}</IconContainer>
          }
          <ModalContent>{props.content}</ModalContent>
          <ModalFooter>
            <StyledButton onClick={props.onConfirm}>
              {props.confirmText}
            </StyledButton>
            <CancelButton onClick={props.onClose}>
              {props.cancelText}
            </CancelButton>
          </ModalFooter>
        </ModalContainer>
      </ModalWrapper>
    </Modal>
  );
};

export default ModalConfirmBase;
