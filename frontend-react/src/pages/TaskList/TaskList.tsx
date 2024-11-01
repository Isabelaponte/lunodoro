import { useState } from "react";
import CardTask from "../../components/CardTask/CardTask";
import Modals from "../../components/Modal/Modal";
import { ContainerTaskList, StyledButton } from "./TaskList.styles";
import CreateEditTaskList from "../CreateEditTaskList/CreateEditTaskList";
import { Mode } from "../../utils/enums/mode.enum";

const TaskList = () => {

  const [openCreateModal, setOpenCreateModal] = useState(false);
  const [openEditModal, setOpenEditModal] = useState(false);

  return (
    <>
      <Modals open={openCreateModal} name={"Adicionar nova lista"} onClose={() => setOpenCreateModal(false)}>
        <CreateEditTaskList onClose={() => setOpenCreateModal(false)} mode={Mode.CREATE}/>
      </Modals>

      <Modals open={openEditModal} name={"Editar lista"} onClose={() => setOpenEditModal(false)}>
        <CreateEditTaskList onClose={() => setOpenEditModal(false)} mode={Mode.EDIT} />
      </Modals>

      <ContainerTaskList>
        <h1>Lista de Tarefas</h1>
        <StyledButton onClick={() => setOpenCreateModal(true)}>Criar nova tarefa</StyledButton>

        <CardTask onOpenEditModal={() => setOpenEditModal(true)} />
      </ContainerTaskList>
    </>
  );
};

export default TaskList;
