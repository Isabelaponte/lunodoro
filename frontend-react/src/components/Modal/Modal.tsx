import { ReactElement } from "react";
import { IconButton, ModalProps } from "@mui/material";
import {
  ModalContainer,
  ModalHeader,
  ModalName,
  StyledModals,
} from "./Modal.styles";
import { Close } from "@mui/icons-material";

interface IModalProps extends ModalProps {
  name: string;
  onClose: () => void;
  children: ReactElement;
}

const Modals = ({ children, ...props }: IModalProps) => {
  return (
    <StyledModals {...props} data-testid="modal">
      <ModalContainer>
        <ModalHeader>
          <ModalName>{props.name}</ModalName>
          <IconButton
            data-testid="close-modal"
            onClick={props.onClose}
            sx={{ marginRight: "44px" }}
          >
            <Close />
          </IconButton>
        </ModalHeader>
        {children}
      </ModalContainer>
    </StyledModals>
  );
};

export default Modals;
