import { useState } from "react";
import {
  Accordion,
  AccordionSummary,
  AccordionDetails,
  Typography,
} from "@mui/material";
import KeyboardArrowDownIcon from "@mui/icons-material/KeyboardArrowDown";
import { TaskName } from "./Task.styles";
import {
  StyledButton,
  StyledButtonSecondary,
} from "../../../components/CardTask/CardTask.styles";
import useAuthStore from "../../../store/useAuthStore";

const Task = ({ task }: { task: any }) => {
  const [expanded, setExpanded] = useState<string | false>(false);
  const { user } = useAuthStore.getState();

  const handleChange =
    (panel: string) => (event: React.SyntheticEvent, isExpanded: boolean) => {
      setExpanded(isExpanded ? panel : false);
    };

  const handleDeleteTask = async (id: string) => {
    try {
      const response = await fetch(
        `http://localhost/luno/lunodoro/usuarios/tarefas?id_user=${user?.id}&id_task=${id}`,
        {
          method: "DELETE",
        }
      );
    } catch (error) {
      console.log(error);
    }
  };

  const onCompleteTask = async (id: string) => {
    console.log('aiai');
  }

  return (
    <Accordion
      expanded={expanded === task.id}
      onChange={handleChange(task.id)}
      sx={{ marginBottom: 2 }}
    >
      <AccordionSummary
        expandIcon={<KeyboardArrowDownIcon />}
        aria-controls={`panel-${task.id}-content`}
        id={`panel-${task.id}-header`}
      >
        <TaskName>{task.nome}</TaskName>
      </AccordionSummary>
      <AccordionDetails>
        <Typography>
          <strong>Descrição:</strong> {task.descricao || "Sem descrição"}
        </Typography>
        <Typography>
          <strong>Data de início:</strong> {task.dt_inicio || "Não informado"}
        </Typography>
        <Typography>
          <strong>Data de término:</strong>{" "}
          {task.dt_final || "Tarefa não finalizada"}
        </Typography>
        <Typography>
          <strong>Status:</strong> {task.status || "Não definido"}
        </Typography>
        {task.status !== "Concluída" && (
          <>
            <StyledButton onClick={() => onCompleteTask(task.id)}>
              Concluir
            </StyledButton>
          </>
        )}
        <StyledButtonSecondary onClick={() => handleDeleteTask(task.id)}>
          Excluir
        </StyledButtonSecondary>
      </AccordionDetails>
    </Accordion>
  );
};

export default Task;
