import { useEffect, useState } from "react";
import CardTask from "../../components/CardTask/CardTask";
import Modals from "../../components/Modal/Modal";
import { ContainerTaskList, StyledButton } from "./TaskList.styles";
import CreateEditTaskList from "../CreateEditTaskList/CreateEditTaskList";
import { Mode } from "../../utils/enums/mode.enum";
import ModalDeleteList from "../../components/ModalDelete/ModalDelete";
import useAuthStore from "../../store/useAuthStore";
import { Severety, useNotificationStore } from "../../store/useNotification";
import { Alert } from "@mui/material";

interface TaskListData {
  create: string;
  description: string;
  id_list: string;
  id_type_list: string;
  lastUpdate: string;
  name_list: string;
}

const TaskList = () => {
  const token = localStorage.getItem("token");
  const { user } = useAuthStore.getState();

  const notify = useNotificationStore((state) => state.notify);
  const notification = useNotificationStore((state) => state.notification);

  const [openCreateModal, setOpenCreateModal] = useState(false);
  const [openEditModal, setOpenEditModal] = useState(false);
  const [openDeleteModal, setOpenDeleteModal] = useState(false);
  const [taskList, setTaskList] = useState<TaskListData[]>([]);

  const [selectedTaskId, setSelectedTaskId] = useState<string | null>(null);

  const handleOpenEditModal = (id: string) => {
    if (token) {
      setSelectedTaskId(id);
      setOpenEditModal(true);
    } else {
      notify({ message: "Você não pode editar listas sem estar logado.", severety: Severety.WARNING });
    }
  };

  const handleOpenDeleteModal = (id: string) => {
    if (token) {
      setSelectedTaskId(id);
      setOpenDeleteModal(true);
    } else {
      notify({ message: "Você não pode deletar listas sem estar logado.", severety: Severety.WARNING });
    }
  };

  useEffect(() => {
    if (token) {
      fetch(`http://localhost/luno/lunodoro/lista?id_user=${user?.id}`)
        .then((response) => response.json())
        .then((response) => {
          setTaskList(response.data);
        });
    } else {
      const storedLists = localStorage.getItem("taskLists");
      if (storedLists) {
        setTaskList(JSON.parse(storedLists));
      }
    }
  }, [token, user?.id, notification]);

  const saveListToLocalStorage = (newList: TaskListData) => {
    const existingLists = JSON.parse(localStorage.getItem("taskLists") || "[]");
    existingLists.push(newList);
    localStorage.setItem("taskLists", JSON.stringify(existingLists));
    setTaskList(existingLists);
  };

  const handleCreateList = () => {
    if (!token && taskList.length >= 3) {
      notify({ message: "Você já tem o máximo de 3 listas cadastradas, realize login para criar mais listas.", severety: Severety.WARNING });
    } else {
      setOpenCreateModal(true);
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
      <Modals
        open={openCreateModal}
        name={"Adicionar nova lista"}
        onClose={() => setOpenCreateModal(false)}
      >
        <CreateEditTaskList
          onClose={() => setOpenCreateModal(false)}
          mode={Mode.CREATE}
          onSave={saveListToLocalStorage}
        />
      </Modals>

      <Modals
        open={openEditModal}
        name={"Editar lista"}
        onClose={() => setOpenEditModal(false)}
      >
        <CreateEditTaskList
          onClose={() => setOpenEditModal(false)}
          mode={Mode.EDIT}
          id={selectedTaskId}
        />
      </Modals>

      <ModalDeleteList
        open={openDeleteModal}
        onClose={() => setOpenDeleteModal(false)}
        id={selectedTaskId}
      />

      <ContainerTaskList>
        <h1>Lista de Tarefas</h1>
        <StyledButton onClick={handleCreateList}>
          Criar nova tarefa
        </StyledButton>

        {taskList.length > 0 ? (
          taskList.map((task) => (
            <CardTask
              id={task?.id_list}
              key={task?.id_list}
              nameList={task?.name_list}
              description={task?.description}
              lastUpdate={task?.lastUpdate}
              idTypeList={task?.id_type_list}
              create={task?.create}
              onOpenEditModal={() => handleOpenEditModal(task?.id_list)}
              onOpenDeleteModal={() => handleOpenDeleteModal(task?.id_list)}
            />
          ))
        ) : (
          <p>Nenhuma lista de tarefas cadastrada</p>
        )}
      </ContainerTaskList>
    </>
  );
};

export default TaskList;
