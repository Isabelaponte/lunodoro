import { IconButton } from "@mui/material";
import EditIcon from "@mui/icons-material/Edit";
import DeleteIcon from "@mui/icons-material/Delete";
import ChipStatus from "../Chip/ChipStatus";
import {
  CardTitle,
  CardP,
  StyledCardTask,
  CardHeader,
  OptionsButtonDiv,
  CardFooter,
  CardFooterText,
} from "./CardTask.styles";
import { Link } from "react-router-dom";
import { ChipType } from "../../utils/enums/status.enum";

interface CardTaskProps {
  onOpenEditModal: () => void;
  onOpenDeleteModal: () => void;
  id: string;
  nameList: string;
  description: string;
  lastUpdate: string;
  idTypeList: string;
  create: string;
}

const CardTask = ({ ...props }: CardTaskProps) => {
  return (
    <>
      <StyledCardTask>
        <CardHeader>
          <ChipStatus type={ChipType.IN_PROGRESS} />
          <OptionsButtonDiv>
            <IconButton onClick={props.onOpenEditModal}>
              <EditIcon />
            </IconButton>
            <IconButton onClick={props.onOpenDeleteModal}>
              <DeleteIcon />
            </IconButton>
          </OptionsButtonDiv>
        </CardHeader>
        <Link to={`/task-list/${props.id}`}>
          <CardTitle>{props.nameList}</CardTitle>
        </Link>
        <CardP>{props.description}</CardP>
        <CardP>Tipo: {props.idTypeList}</CardP>
        <CardFooter>
          <CardFooterText>Criado em {props.create}</CardFooterText>
        </CardFooter>
      </StyledCardTask>
    </>
  );
};

export default CardTask;
