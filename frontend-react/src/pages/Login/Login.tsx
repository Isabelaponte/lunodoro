import InputField from "../../components/InputField/InputField";
import {
  CardLogin,
  FormLogin,
  H2,
  ImgLogin,
  LinkSignUp,
  StyledButton,
  StyledContainerLogin,
} from "./Login.styles";

import astronauta from "../../assets/img/astronauta.png";
import { useNavigate } from "react-router-dom";
import useAuthStore from "../../store/useAuthStore";
import { Controller } from "react-hook-form";
import * as yup from "yup";
import { useFormUtils } from "../../utils/form.utils";
import { Severety, useNotificationStore } from "../../store/useNotification";
import { Alert } from "@mui/material";


const Login = () => {
  const setToken = useAuthStore((state) => state.setToken);
  const setUser = useAuthStore((state) => state.setUser);
  const navigate = useNavigate();
  const notify = useNotificationStore((state) => state.notify);
  const notification = useNotificationStore((state) => state.notification);

  const schema = yup.object({
    email: yup.string().required("Campo obrigatório"),
    password: yup.string().required("Campo obrigatório"),
  });

  const { handleSubmit, trigger, control } = useFormUtils<any>(schema, {
    email: "",
    password: "",
  });

  const onSubmit = async (data: any) => {
    await trigger();

    try {
      const response = await fetch(
        "http://localhost/luno/lunodoro/usuarios/login",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: new URLSearchParams({
            email: data.email,
            password: data.password,
          }),
        }
      );

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.error || "Erro desconhecido");
      }

      const responseData = await response.json();
      
      const token = 'mockedToken';
      const user = responseData.data;
      
      setToken(token);
      setUser(user);
      navigate("/");
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
      <StyledContainerLogin>
        <CardLogin>
          <H2>Login</H2>
          <FormLogin onSubmit={handleSubmit(onSubmit)}>
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

            <StyledButton type="submit">Login</StyledButton>
            <LinkSignUp to={"/signup"}>Não tem conta? Cadastre-se</LinkSignUp>
          </FormLogin>
        </CardLogin>

        <ImgLogin id="img_astronauta" src={astronauta} alt="astronauta" />
      </StyledContainerLogin>
    </>
  );
};

export default Login;
