import { TextField } from "@mui/material";
import { Form } from "../CreateEditTaskList/CreateTaskList.styles";
import * as yup from "yup";
import { useFormUtils } from "../../utils/form.utils";
import { Controller } from "react-hook-form";

const CreateEditTask = () => {
  const schema = yup.object({
    name: yup.string().required("Campo obrigatório"),
    initial_date: yup.date().required("Campo obrigatório"),
    final_date: yup.date().required("Campo obrigatório"),
    description: yup.string(),
    pomodoro_estimate: yup.number().required("Campo obrigatório"),
  });

  const { handleSubmit, trigger, errors, control } = useFormUtils<any>(schema, {
    name: "",
    initial_date: "",
    final_date: "",
    description: "",
    pomodoro_estimate: 0,
  });

  const onSubmit = async (data: any) => {
    await trigger();

    console.log(data);
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
          name="initial_date"
          control={control}
          rules={{ required: true }}
          render={({ field }) => (
            <DateField
              {...field}
              label="Data de Início"
              size="small"
              type="date"
              required
            />
          )}
        />
        <Controller
          name="final_date"
          control={control}
          rules={{ required: true }}
          render={({ field }) => (
            <TextField
              {...field}
              label="Data de Término"
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
        <Controller
          name="pomodoro_estimate"
          control={control}
          rules={{ required: true }}
          render={({ field }) => (
            <TextField
              {...field}
              label="Estimativa de Pomodoros"
              size="small"
              type="number"
              sx={{ width: "200px" }}
              required
            />
          )}
        /> 
      </Form>
    </>
  );
};

export default CreateEditTask;
