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
import { useEffect } from "react";
import useAuthStore from "../../store/useAuthStore";

interface CardTaskProps {
  onOpenEditModal: () => void;
  onOpenDeleteModal: () => void;
  id: string;
}

useEffect(()=> {
  const token = localStorage.getItem("token");
  const { user } = useAuthStore.getState();

  if (token) {
    fetch(`http://localhost/luno/lunodoro/usuarios?id=${user?.id}`)
      .then((response) => response.json())
      .then((response) => {
        console.log(response);
        
      })
  }
})

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
