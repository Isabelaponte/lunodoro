import { useState } from "react";
import CardTask from "../../components/CardTask/CardTask";
import Modals from "../../components/Modal/Modal";
import { ContainerTaskList, StyledButton } from "./TaskList.styles";
import CreateTaskList from "../CreateTaskList/CreateTaskList";

const TaskList = () => {

  const [openModal, setOpenModal] = useState(false);

  return (
    <>
      <Modals open={openModal} name={"Adicionar nova lista"} onClose={() => setOpenModal(false)}>
        <CreateTaskList onClose={() => setOpenModal(false)} />
      </Modals>
      <ContainerTaskList>
        <h1>Lista de Tarefas</h1>
        <StyledButton onClick={() => setOpenModal(true)}>Criar nova tarefa</StyledButton>

        <CardTask />
      </ContainerTaskList>
    </>
  );
};

export default TaskList;
