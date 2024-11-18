import { TextField } from "@mui/material";
import {
  CancelButton,
  DivOptions,
  Form,
} from "../CreateEditTaskList/CreateTaskList.styles";
import * as yup from "yup";
import { useFormUtils } from "../../utils/form.utils";
import { Controller } from "react-hook-form";
import { StyledButton } from "../Home/Home.styles";
import useAuthStore from "../../store/useAuthStore";
import { useNavigate } from "react-router-dom";

const CreateEditTask = ({ id_list }: any) => {
  const token = localStorage.getItem("token");
  const { user } = useAuthStore.getState();
  const navigate = useNavigate();

  const schema = yup.object({
    name: yup.string().required("Campo obrigatório"),
    description: yup.string(),
  });

  const { handleSubmit, trigger, errors, control } = useFormUtils<any>(schema, {
    name: "",
    description: "",
  });

  console.log(errors);

  const onSubmit = async (data: any) => {
    await trigger();

    try {
      const response = await fetch(
        `http://localhost/luno/lunodoro/usuarios/tarefas`,
        {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: new URLSearchParams({
            id_list: id_list,
            name: data?.name,
            description: data?.description,
            status: "em processo",
          }),
        }
      );

      if (response.ok) {
        navigate("/task-list");
      } else {
        const responseJson = await response.json();
        console.log(responseJson);
      }
    } catch (error) {
      console.log(error);
    }
  };

  return (
    <>
      <Form onSubmit={handleSubmit(onSubmit)}>
        <Controller
          name="name"
          control={control}
          rules={{ required: true }}
          render={({ field }) => (
            <TextField
              {...field}
              label="Nome da tarefa"
              size="small"
              required
            />
          )}
        />
        <Controller
          name="description"
          control={control}
          rules={{ required: true }}
          render={({ field }) => (
            <TextField
              {...field}
              label="Descrição"
              size="small"
              multiline
              rows={4}
            />
          )}
        />
        <DivOptions>
          <StyledButton type="submit">Salvar</StyledButton>
          <CancelButton type="button" onClick={() => {}}>
            Cancelar
          </CancelButton>
        </DivOptions>
      </Form>
    </>
  );
};

export default CreateEditTask;
