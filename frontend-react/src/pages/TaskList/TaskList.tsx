import { useEffect, useState } from "react";
import CardTask from "../../components/CardTask/CardTask";
import Modals from "../../components/Modal/Modal";
import { ContainerTaskList, StyledButton } from "./TaskList.styles";
import CreateEditTaskList from "../CreateEditTaskList/CreateEditTaskList";
import { Mode } from "../../utils/enums/mode.enum";
import ModalDeleteList from "../../components/ModalDelete/ModalDelete";
import useAuthStore from "../../store/useAuthStore";

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

  const [openCreateModal, setOpenCreateModal] = useState(false);
  const [openEditModal, setOpenEditModal] = useState(false);
  const [openDeleteModal, setOpenDeleteModal] = useState(false);
  const [taskList, setTaskList] = useState<TaskListData[]>([]);

  const [selectedTaskId, setSelectedTaskId] = useState<string | null>(null);

  const handleOpenEditModal = (id: string) => {
    setSelectedTaskId(id);
    setOpenEditModal(true);
  };

  const handleOpenDeleteModal = (id: string) => {
    setSelectedTaskId(id);
    setOpenDeleteModal(true);
  };

  useEffect(() => {
    if (token) {
      fetch(`http://localhost/luno/lunodoro/lista?id_user=${user?.id}`)
        .then((response) => response.json())
        .then((response) => {
          console.log(response);
          setTaskList(response.data);
        });
    } else {
      console.log("Não tem token");
    }
  }, []);

  return (
    <>
      <Modals
        open={openCreateModal}
        name={"Adicionar nova lista"}
        onClose={() => setOpenCreateModal(false)}
      >
        <CreateEditTaskList
          onClose={() => setOpenCreateModal(false)}
          mode={Mode.CREATE}
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
        <StyledButton onClick={() => setOpenCreateModal(true)}>
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
