import { useNavigate } from "react-router-dom";
import astronauta from "../../assets/img/astronauta.png";
import InputField from "../../components/InputField/InputField";
import { Severety, useNotificationStore } from "../../store/useNotification";
import { useFormUtils } from "../../utils/form.utils";
import { StyledContainerHome } from "../Home/Home.styles";
import {
  CardLogin,
  H2,
  FormLogin,
  LinkSignUp,
  ImgLogin,
  StyledButton,
} from "../Login/Login.styles";
import * as yup from "yup";
import { Alert } from "@mui/material";
import { Controller } from "react-hook-form";

const SignUp = () => {
  const navigate = useNavigate();
  const notify = useNotificationStore((state) => state.notify);
  const notification = useNotificationStore((state) => state.notification);

  const schema = yup.object({
    email: yup.string().required("Campo obrigatório"),
    password: yup.string().required("Campo obrigatório"),
    name: yup.string().required("Campo obrigatório"),
  });

  const { handleSubmit, trigger, control } = useFormUtils<any>(schema, {
    email: "",
    password: "",
    name: "",
  });

  const onSubmit = async (data: any) => {
    await trigger();
    console.log(data);

    try {
      const response = await fetch("http://localhost/luno/lunodoro/usuarios", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams({
          email: data.email,
          password: data.password,
          name: data.name,
        }),
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.error || "Erro desconhecido");
      }

      const responseData = await response.json();
      notify({
        message: responseData.message,
        severety: Severety.SUCCESS,
      });
      navigate("/login");
    } catch (error: any) {
      console.error(error.message, "Erro");
      notify({ message: error.message, severety: Severety.ERROR });
    }
  };

  return (
    <>
      {notification && (
        <Alert
          severity={notification.severety}
          sx={{ width: "95vw", position: "absolute" }}
        >
          {notification.message}
        </Alert>
      )}
      <StyledContainerHome>
        <CardLogin>
          <H2>Cadastro</H2>
          <FormLogin onSubmit={handleSubmit(onSubmit)}>
          <Controller
              name="name"
              control={control}
              render={({ field }) => (
                <InputField
                  {...field}
                  label="Nome de usuário"
                  value={field.value}
                  onChange={field.onChange}
                  type="text"
                  required
                />
              )}
            />
            <Controller
              name="email"
              control={control}
              render={({ field }) => (
                <InputField
                  {...field}
                  label="Email"
                  value={field.value}
                  onChange={field.onChange}
                  type="email"
                  required
                />
              )}
            />
            <Controller
              name="password"
              control={control}
              render={({ field }) => (
                <InputField
                  {...field}
                  label="Senha"
                  value={field.value}
                  onChange={field.onChange}
                  type="password"
                  required
                />
              )}
            />

            <StyledButton type="submit">Cadastrar</StyledButton>
            <LinkSignUp to={"/login"}>Realizar login</LinkSignUp>
          </FormLogin>
        </CardLogin>

        <ImgLogin id="img_astronauta" src={astronauta} alt="astronauta" />
      </StyledContainerHome>
    </>
  );
};

export default SignUp;
