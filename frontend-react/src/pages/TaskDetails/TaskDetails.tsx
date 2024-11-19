import { useEffect, useState } from "react";
import {
  Button,
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
import { useNavigate, useParams } from "react-router-dom";
import { Severety, useNotificationStore } from "../../store/useNotification";
import { Alert } from "@mui/material";

const TaskDetails = () => {
  const token = localStorage.getItem("token");
  const { user } = useAuthStore.getState();
  const { taskId } = useParams();

  const navigate = useNavigate();
  const notify = useNotificationStore((state) => state.notify);
  const notification = useNotificationStore((state) => state.notification);

  const [tasks, setTasks] = useState([]);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [timer, setTimer] = useState(25 * 60);
  const [isPomodoro, setIsPomodoro] = useState(true);
  const [isRunning, setIsRunning] = useState(false);

  useEffect(() => {
    if (token) {
      fetch(
        `http://localhost/luno/lunodoro/usuarios/tarefas?id_taskList=${taskId}&id_user=${user?.id}`
      )
        .then((response) => response.json())
        .then((response) => {
          setTasks(response.data);
        });
    }
  }, [token, taskId, user, notification]);

  useEffect(() => {
    let interval: any;
    if (isRunning) {
      interval = setInterval(() => {
        setTimer((prev) => {
          if (prev <= 1) {
            clearInterval(interval);
            handleTimerEnd();
            return 0;
          }
          return prev - 1;
        });
      }, 1000);
    }
    return () => clearInterval(interval);
  }, [isRunning]);

  const handleTimerEnd = () => {
    setIsRunning(false);
  };

  const handleStartTimer = () => {
    if (tasks.length > 0) {
      if (isPomodoro) {
        const updatedTasks = [...tasks];
        updatedTasks[0].status = "Em andamento";
        setTasks(updatedTasks);
      }
      setIsRunning(true);
    } else {
      notify({
        message: "Não há tarefas disponíveis para iniciar o cronômetro.",
        severety: Severety.WARNING,
      });
    }
  };

  const handleSelectPomodoro = () => {
    setIsRunning(false);
    setIsPomodoro(true);
    setTimer(25 * 60);
  };

  const handleSelectBreak = () => {
    setIsRunning(false);
    setIsPomodoro(false);
    setTimer(5 * 60);
  };

  const formatTime = (seconds: number) => {
    const minutes = Math.floor(seconds / 60);
    const remainingSeconds = seconds % 60;
    return `${String(minutes).padStart(2, "0")}:${String(
      remainingSeconds
    ).padStart(2, "0")}`;
  };

  const handleAddTask = () => {
    if (!token) {
      notify({
        message: "Para adicionar uma tarefa, faça login ou crie uma conta.",
        severety: Severety.WARNING,
      });
    } else {
      setIsModalOpen(true);
    }
  };

  return (
    <>
      {notification && (
        <Alert
          severity={notification.severety}
          sx={{ width: "95vw", position: "absolute" }}
        >
          {notification.message}
        </Alert>
      )}
      <ContainerTaskList>
        <Modals
          open={isModalOpen}
          name={"Adicionar nova tarefa"}
          onClose={() => setIsModalOpen(false)}
        >
          <CreateEditTask id_list={taskId} onClose={() => setIsModalOpen(false)} />
        </Modals>
        <TimerSection>
          <TimerHeader>
            <TimerContainerControls>
              <TimerControls
                onClick={handleSelectPomodoro}
                style={{
                  background: isPomodoro
                    ? "rgba(255, 255, 255, 0.2)"
                    : "transparent",
                }}
              >
                Pomodoro
              </TimerControls>
              <TimerControls
                onClick={handleSelectBreak}
                style={{
                  background: !isPomodoro
                    ? "rgba(255, 255, 255, 0.2)"
                    : "transparent",
                }}
              >
                Descanso
              </TimerControls>
            </TimerContainerControls>
          </TimerHeader>
          <p style={{ fontSize: "5rem", margin: "2rem" }}>
            {formatTime(timer)}
          </p>
          <TimerButton onClick={handleStartTimer}>
            {isRunning ? "Em Andamento..." : "Iniciar"}
          </TimerButton>
        </TimerSection>

        <section>
          <TasksHeader>
            <Button onClick={() => navigate("/task-list")}>Voltar</Button>
            <Button onClick={handleAddTask}>Adicionar Tarefa</Button>
          </TasksHeader>

          <TaskList id="taskList">
            {tasks.length > 0 ? (
              tasks.map((task, index) => <Task key={index} task={task} />)
            ) : (
              <p>Nenhuma tarefa cadastrada!</p>
            )}
          </TaskList>
          {!token && (
            <p>Para adicionar uma tarefa, faça login ou crie uma conta.</p>
          )}
        </section>
      </ContainerTaskList>
    </>
  );
};

export default TaskDetails;
