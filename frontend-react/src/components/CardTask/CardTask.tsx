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
} from "./CardTask.styles";

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
        <CardTitle>Tarefa 1</CardTitle>
        <CardP>Descrição da tarefa</CardP>
        <CardP>Tipo: Trabalho</CardP>
      </StyledCardTask>
    </>
  );
};

export default CardTask;
