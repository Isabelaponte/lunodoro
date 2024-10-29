import { IconButton } from "@mui/material";
import EditIcon from "@mui/icons-material/Edit";
import DeleteIcon from "@mui/icons-material/Delete";
import ChipStatus, { ChipType } from "../Chip/ChipStatus";
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

const CardTask = () => {
  return (
    <>
      <StyledCardTask>
        <CardHeader>
          <ChipStatus type={ChipType.IN_PROGRESS} />
          <OptionsButtonDiv>
            <IconButton aria-label="editar">
              <EditIcon />
            </IconButton>
            <IconButton aria-label="deletar">
              <DeleteIcon />
            </IconButton>
          </OptionsButtonDiv>
        </CardHeader>
        <Link to={"/task-list"}>
          <CardTitle>Tarefa 1</CardTitle>
        </Link>
        <CardP>Descrição da tarefa</CardP>
        <CardP>Tipo: Trabalho</CardP>
        <CardFooter>
          <CardFooterText>Criado em 12/12/2022</CardFooterText>
        </CardFooter>
      </StyledCardTask>
    </>
  );
};

export default CardTask;
