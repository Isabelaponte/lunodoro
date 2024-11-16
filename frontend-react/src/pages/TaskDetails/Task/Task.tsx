import { useState } from 'react';
import { ExpandButton, TaskDetails, TaskItem } from './Task.styles';

const Task = ({ task } : any) => {
  const [expanded, setExpanded] = useState(false);

  const handleExpand = () => {
    setExpanded(!expanded);
  };

  return (
    <TaskItem className={task.status}>
      <h2>{task.name}</h2>
      <p>{task.startDate} - {task.endDate}</p>
      <p>{task.description}</p>

      <TaskDetails expanded={expanded}>
        <p>Details about task...</p>
      </TaskDetails>

      <ExpandButton onClick={handleExpand}>
        {expanded ? 'Fechar' : 'Expandir'}
      </ExpandButton>
    </TaskItem>
  );
};

export default Task;
