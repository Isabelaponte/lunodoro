import { useEffect, useState } from "react";
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
import useAuthStore from "../../store/useAuthStore";
import { useParams } from "react-router-dom";

const TaskDetails = () => {
  const token = localStorage.getItem("token");
  const { user } = useAuthStore.getState();
  const { taskId } = useParams();
  
  const [tasks, setTasks] = useState([]);
  const [isModalOpen, setIsModalOpen] = useState(false);

  useEffect(() => {
    if (token) {
      fetch(`http://localhost/luno/lunodoro/usuarios/tarefas?id_taskList=${taskId}&id_user=${user?.id}`)
        .then((response) => response.json())
        .then((response) => {
          setTasks(response.data);
        });
    } else {
      console.log("Não tem token");
    }
  }, []);

  const handleAddTask = () => {
    setIsModalOpen(true);
  };

  return (
    <ContainerTaskList>
      <Modals open={isModalOpen} name={"Adicionar nova tarefa"} onClose={() => setIsModalOpen(false)}>
        <CreateEditTask id_list={taskId} />
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
