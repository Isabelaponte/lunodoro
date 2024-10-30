import * as yup from "yup";
import { useFormUtils } from "../../utils/form.utils";
import { Select, TextField } from "@mui/material";

const CreateTaskList = () => {
  const schema = yup.object({
    name: yup.string().required("Campo obrigatório"),
    description: yup.string().required("Campo obrigatório"),
    type: yup.string().required("Campo obrigatório"),
  });

  const { handleSubmit, trigger } = useFormUtils<any>(schema, {
    projects: [],
  });

  const onSubmit = async (data: any) => {
    await trigger();
    console.log(data);
    //TODO: aqui terá a chamada api para criar uma nova lista de tarefas
  };

  return <form onSubmit={handleSubmit(onSubmit)}>
    <TextField name="name" label="Nome da lista" required />
    <TextField name="description" label="Descrição da lista" required />
    <Select name="type" label="Tipo da lista" required>
      <option value="project">Projeto</option>
      <option value="task">Tarefa</option>
    </Select>
    <button type="submit">Criar</button>
  </form>;
};

export default CreateTaskList;
