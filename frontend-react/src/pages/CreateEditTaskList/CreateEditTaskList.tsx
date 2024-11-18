import * as yup from "yup";
import { useFormUtils } from "../../utils/form.utils";
import { MenuItem, TextField } from "@mui/material";
import {
  CancelButton,
  DivOptions,
  Form,
  SpanInfo,
} from "./CreateTaskList.styles";
import { StyledButton } from "../../components/CardTask/CardTask.styles";
import { Controller } from "react-hook-form";
import { Mode } from "../../utils/enums/mode.enum";
import useAuthStore from "../../store/useAuthStore";
import { useEffect, useState } from "react";

interface CreateTaskListProps {
  onClose: () => void;
  mode?: Mode;
  id?: string;
}

const CreateEditTaskList = ({ ...props }: CreateTaskListProps) => {
  const token = localStorage.getItem("token");
  const { user } = useAuthStore.getState();
  const [tipoLista, setTipoLista] = useState<string[]>([]);

  try {
    fetch(`http://localhost/luno/lunodoro/tipoLista`)
      .then((response) => response.json())
      .then((response) => {
        setTipoLista(response);
      });
  } catch (error) {
    console.log(error);
  }

  const schema = yup.object({
    name: yup.string().required("Campo obrigatório"),
    description: yup.string(),
    type: yup.string().required("Campo obrigatório"),
  });

  const { handleSubmit, trigger, control, setValue } = useFormUtils<any>(schema, {
    name: "",
    description: "",
    type: "",
  });

  useEffect(()=> {
    const setFormValues = (data: any) => {
      setValue("name", data.name_list);
      setValue("description", data.description);
      setValue("type", data.id_type_list);
    }

    if (props.mode === Mode.EDIT) {
      console.log('eeeieieeee', props.id);
      fetch(`http://localhost/luno/lunodoro/lista?id_user=${user?.id}&id_list=${props.id}`)
        .then((response) => response.json())
        .then((response) => {
          console.log(response);
          
          setFormValues(response.data);
        });
    }
  }, [props.mode, setValue, props.id, user?.id]);

  const onSubmit = async (data: any) => {
    await trigger();

    if (props.mode === Mode.CREATE) {
      try {
        fetch(`http://localhost/luno/lunodoro/lista`, {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: new URLSearchParams({
            id_user: user?.id.toString() || "",
            name_list: data?.name,
            description: data?.description,
            id_type_list: data?.type,
          }),
        })
          .then((response) => {
            if (response.status !== 'success') {
              throw new Error(`Erro ao criar lista: ${response.statusText}`);
            }
            return response.json();
          })
          .then((result) => {
            console.log("Lista criada com sucesso:", result);
            props.onClose();
          })
          .catch((error) => {
            console.error("Erro ao criar lista:", error);
          });

        props.onClose();
      } catch (error) {
        console.log(error);
      }
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
            {tipoLista.map((tipo : any) => (
              <MenuItem value={tipo.id} key={tipo.id}>
                {tipo.descricao}
              </MenuItem>
            ))}
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
