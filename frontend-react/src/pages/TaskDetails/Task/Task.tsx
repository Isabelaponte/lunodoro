import { useState } from "react";
import { Accordion, AccordionSummary, AccordionDetails, Typography } from "@mui/material";
import KeyboardArrowDownIcon from '@mui/icons-material/KeyboardArrowDown';
import { TaskName } from "./Task.styles";
import { StyledButton } from "../../../components/CardTask/CardTask.styles";

const Task = ({ task }: { task: any }) => {
  const [expanded, setExpanded] = useState<string | false>(false);

  const handleChange =
    (panel: string) => (event: React.SyntheticEvent, isExpanded: boolean) => {
      setExpanded(isExpanded ? panel : false);
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
          <strong>Data de término:</strong> {task.dt_final || "Tarefa não finalizada"}
        </Typography>
        <Typography>
          <strong>Status:</strong> {task.status || "Não definido"}
        </Typography>
        <StyledButton>Concluir</StyledButton>
      </AccordionDetails>
    </Accordion>
  );
};

export default Task;
