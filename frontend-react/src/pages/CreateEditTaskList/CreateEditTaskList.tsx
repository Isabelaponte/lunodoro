import * as yup from "yup";
import { useFormUtils } from "../../utils/form.utils";
import { MenuItem, TextField } from "@mui/material";
import { CancelButton, DivOptions, Form, SpanInfo } from "./CreateTaskList.styles";
import { StyledButton } from "../../components/CardTask/CardTask.styles";
import { Controller } from "react-hook-form";
import { Mode } from "../../utils/enums/mode.enum";

interface CreateTaskListProps {
  onClose: () => void;
  mode?: Mode;
}

const CreateEditTaskList = ({ ...props }: CreateTaskListProps) => {

  //TODO: ao carregar no modo editar, terá que buscar o id da lista e preencher os campos

  const schema = yup.object({
    name: yup.string().required("Campo obrigatório"),
    description: yup.string(),
    type: yup.string().required("Campo obrigatório"),
  });

  const { handleSubmit, trigger, errors, control } = useFormUtils<any>(schema, {
    name: "",
    description: "",
    type: "",
  });

  console.log(errors);
  const onSubmit = async (data: any) => {
    await trigger();

    if (props.mode === Mode.CREATE) {
      //TODO: aqui terá a chamada api para criar uma nova lista de tarefas e para receber os valores do select (confirmar)
    } else {
      //TODO: aqui terá a chamada api para criar uma editar uma lista de tarefas e para receber os valores do select (confirmar)
    }
  };

  return (
    <Form onSubmit={handleSubmit(onSubmit)}>
      <Controller
        name="name"
        control={control}
        rules={{ required: true }}
        render={({ field }) => (
          <TextField {...field} label="Nome da lista" size="small" required />
        )}
      />
      <Controller
        name="description"
        control={control}
        rules={{ required: true }}
        render={({ field }) => (
          <TextField
            {...field}
            label="Descrição da lista"
            size="small"
            multiline
            rows={4}
          />
        )}
      />

      <Controller
        name="type"
        control={control}
        rules={{ required: true }}
        render={({ field }) => (
          <TextField
            {...field}
            label="Tipo da lista"
            size="small"
            select
            required
          >
            <MenuItem value="project">Projeto</MenuItem>
            <MenuItem value="task">Tarefa</MenuItem>
          </TextField>
        )}
      />

      <SpanInfo>*Acesse a lista para adicionar tarefas</SpanInfo>

      <DivOptions>
        <StyledButton type="submit">Criar</StyledButton>
        <CancelButton type="button" onClick={props.onClose}>
          Cancelar
        </CancelButton>
      </DivOptions>
    </Form>
  );
};

export default CreateEditTaskList;