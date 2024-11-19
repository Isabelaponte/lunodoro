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
import { Severety, useNotificationStore } from "../../../store/useNotification";

const Task = ({ task }: { task: any }) => {
  const [expanded, setExpanded] = useState<string | false>(false);
  const { user } = useAuthStore.getState();
  const notify = useNotificationStore((state) => state.notify);

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
      if (!response.ok) {
        notify({
          message: "Erro ao excluir tarefa: " + response.statusText,
          severety: Severety.ERROR,
        });
      } else {
        notify({
          message: "Tarefa excluída com sucesso!",
          severety: Severety.SUCCESS,
        });
      }
    } catch (error) {
      console.log(error);
    }
  };

  const onCompleteTask = async (id: string) => {
    try {
      const response = await fetch(
        `http://localhost/luno/lunodoro/usuarios/tarefas?id_user=${user?.id}&id_task=${id}&status=true`,
        {
          method: "PUT",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: new URLSearchParams({
            id_user: user?.id.toString() || "",
            id_task: id.toString() || "",
            status: 'true',
          }),
        }
      );
      if (!response.ok) {
        notify({
          message: "Erro ao concluir tarefa: " + response.statusText,
          severety: Severety.ERROR,
        });
      } else {
        notify({
          message: "Tarefa concluída com sucesso!",
          severety: Severety.SUCCESS,
        });
      }
    } catch (error) {
      console.log(error);
    }
  };
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
        {task.status !== "concluída" && (
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
