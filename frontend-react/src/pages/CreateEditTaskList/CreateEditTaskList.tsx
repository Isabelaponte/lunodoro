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
import { Severety, useNotificationStore } from "../../store/useNotification";

interface CreateTaskListProps {
  onClose: () => void;
  mode?: Mode;
  id?: string | null;
  onSave?: (task: any) => void;
}

const CreateEditTaskList = ({ onClose, mode, id, onSave }: CreateTaskListProps) => {
  const token = localStorage.getItem("token");
  const { user } = useAuthStore.getState();
  const [tipoLista, setTipoLista] = useState<string[]>([]);

  const notify = useNotificationStore((state) => state.notify);

  useEffect(() => {
    try {
      fetch(`http://localhost/luno/lunodoro/tipoLista`)
        .then((response) => response.json())
        .then((response) => {
          setTipoLista(response);
        });
    } catch (error) {
      console.log(error);
    }
  }, []);

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

  useEffect(() => {
    const setFormValues = (data: any) => {
      setValue("name", data.name_list);
      setValue("description", data.description);
      setValue("type", data.id_type_list);
    };

    if (mode === Mode.EDIT) {
      fetch(`http://localhost/luno/lunodoro/lista?id_user=${user?.id}&id_list=${id}`)
        .then((response) => response.json())
        .then((response) => {
          setFormValues(response.data);
        });
    }
  }, [mode, setValue, id, user?.id]);

  const handleSave = async (data: any) => {
    if (mode === Mode.CREATE) {
      if (token) {
        try {
          const response = await fetch(`http://localhost/luno/lunodoro/lista`, {
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
          });
  
          if (!response.ok) {
            throw new Error(`Erro ao criar lista: ${response.statusText}`);
          }
  
          const result = await response.json();
          onClose();
          notify({ message: "Lista criada com sucesso!", severety: Severety.SUCCESS });
        } catch (error) {
          console.error("Erro ao criar lista:", error);
          notify({ message: "Erro ao criar lista: " + error.message, severety: Severety.ERROR });
        }
      } else {
        onSave(newTask);
        onClose();
      }
    } else {
      if (token) {
        try {
          const response = await fetch('http://localhost/luno/lunodoro/lista', {
            method: "PUT",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams({
              id_user: user?.id.toString() || "",
              id_list: id?.toString() || "",
              name_list: data?.name,
              description: data?.description,
              id_type_list: data?.type,
            }),
          });
  
          if (!response.ok) {
            throw new Error(`Erro ao editar lista: ${response.statusText}`);
          }
  
          const result = await response.json();
          onClose();
          notify({ message: "Lista editada com sucesso!", severety: Severety.SUCCESS });
        } catch (error) {
          console.error("Erro ao editar lista:", error);
          notify({ message: "Erro ao editar lista: " + error.message, severety: Severety.ERROR });
        }
      } else {
        return;
      }
    }
  };
  

  const onSubmit = async (data: any) => {
    await trigger();

    const newTask = {
      id_list: Date.now().toString(),
      name_list: data.name,
      description: data.description,
      id_type_list: data.type,
      create: new Date().toISOString(),
      lastUpdate: new Date().toISOString(),
    };

    handleSave(data);
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
        render={({ field }) => (
          <TextField
            {...field}
            label="Tipo da lista"
            size="small"
            select
            required
          >
            {tipoLista.map((tipo) => (
              <MenuItem value={tipo?.id} key={tipo?.id}>
                {tipo?.descricao}
              </MenuItem>
            ))}
          </TextField>
        )}
      />
      <SpanInfo>*Acesse a lista para adicionar tarefas</SpanInfo>
      <DivOptions>
        <StyledButton type="submit">Salvar</StyledButton>
        <CancelButton type="button" onClick={onClose}>
          Cancelar
        </CancelButton>
      </DivOptions>
    </Form>
  );
};


export default CreateEditTaskList;
