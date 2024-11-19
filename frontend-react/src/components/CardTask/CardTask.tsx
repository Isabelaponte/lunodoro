import { IconButton } from "@mui/material";
import EditIcon from "@mui/icons-material/Edit";
import DeleteIcon from "@mui/icons-material/Delete";
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
          <Link to={`/task-list/${props.id}`}>
            <CardTitle>{props.nameList}</CardTitle>
          </Link>
          <OptionsButtonDiv>
            <IconButton onClick={props.onOpenEditModal}>
              <EditIcon />
            </IconButton>
            <IconButton onClick={props.onOpenDeleteModal}>
              <DeleteIcon />
            </IconButton>
          </OptionsButtonDiv>
        </CardHeader>
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
