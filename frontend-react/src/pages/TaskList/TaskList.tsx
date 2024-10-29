import CardTask from "../../components/CardTask/CardTask";
import { ContainerTaskList, StyledButton } from "./TaskList.styles";

const TaskList = () => {
  return (
    <ContainerTaskList>
      <h1>Lista de Tarefas</h1>
      <StyledButton>Adicionar lista</StyledButton>

      <CardTask />
    </ContainerTaskList>
  );
};  

export default TaskList;