import { useState } from "react";
import {
  Button,
  ListTitle,
  TaskList,
  TasksHeader,
  TimerButton,
  TimerContainerControls,
  TimerControls,
  TimerHeader,
  TimerSection,
} from "./TaskDetails.style";
import Task from "./Task/Task";
import { ContainerTaskList } from "../TaskList/TaskList.styles";
import Modals from "../../components/Modal/Modal";
import CreateEditTask from "../CreateEditTask/CreateEditTask";

const TaskDetails = () => {
  const [tasks, setTasks] = useState([]);
  const [isModalOpen, setIsModalOpen] = useState(false);

  const handleAddTask = () => {
    setIsModalOpen(true);
  };

  return (
    <ContainerTaskList>
      <Modals open={isModalOpen} name={"Adicionar nova tarefa"} onClose={() => setIsModalOpen(false)}>
        <CreateEditTask />
      </Modals>
      <TimerSection>
        <TimerHeader>
          <TimerContainerControls>
            <TimerControls>Pomodoro</TimerControls>
            <TimerControls>Descanso</TimerControls>
          </TimerContainerControls>
        </TimerHeader>
        <p style={{ fontSize: '5rem', margin: '2rem' }}>25:00</p>
        <TimerButton>Iniciar</TimerButton>
      </TimerSection>

      <section>
        <TasksHeader>
          <Button>Voltar</Button>
          <ListTitle id="listName">Nome da Lista</ListTitle>
          <Button onClick={handleAddTask}>Adicionar Tarefa</Button>
        </TasksHeader>

        <TaskList id="taskList">
          {tasks.length > 0 ? (
            tasks.map((task, index) => <Task key={index} task={task} />)
          ) : (
            <p>No tasks available</p>
          )}
        </TaskList>
      </section>
    </ContainerTaskList>
  );
};

export default TaskDetails;
