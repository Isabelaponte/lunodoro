import { useState } from "react";
import CardTask from "../../components/CardTask/CardTask";
import Modals from "../../components/Modal/Modal";
import { ContainerTaskList, StyledButton } from "./TaskList.styles";
import CreateEditTaskList from "../CreateEditTaskList/CreateEditTaskList";
import { Mode } from "../../utils/enums/mode.enum";
import ModalDelete from "../../components/ModalDelete/ModalDelete";

const TaskList = () => {
  const [openCreateModal, setOpenCreateModal] = useState(false);
  const [openEditModal, setOpenEditModal] = useState(false);
  const [openDeleteModal, setOpenDeleteModal] = useState(false);

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
        />
      </Modals>

      <ModalDelete
        open={openDeleteModal}
        onClose={() => setOpenDeleteModal(false)}
        title={"tarefa1"}
        id={"1"}
        queryFn={() => {}}
      />

      <ContainerTaskList>
        <h1>Lista de Tarefas</h1>
        <StyledButton onClick={() => setOpenCreateModal(true)}>
          Criar nova tarefa
        </StyledButton>

        <CardTask id={"1"} onOpenEditModal={() => setOpenEditModal(true)} onOpenDeleteModal={() => setOpenDeleteModal(true)} />
      </ContainerTaskList>
    </>
  );
};

export default TaskList;
