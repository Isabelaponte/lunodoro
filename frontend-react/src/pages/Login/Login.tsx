import InputField from "../../components/InputField/InputField";
import { StyledContainerHome } from "../Home/Home.styles";
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


//TODO: adicionar controller e chamada api

const Login = () => {
  return (
    <StyledContainerLogin>
      <CardLogin>
        <H2>Login</H2>
        <FormLogin>
          <InputField name="email" label="Email" type="email" required />
          <InputField name="password" label="Senha" type="password" required />
          
          <StyledButton type="submit">Login</StyledButton>
          <LinkSignUp to={"/signup"}>Não tem conta? Cadastre-se</LinkSignUp>
        </FormLogin>
      </CardLogin>

      <ImgLogin id="img_astronauta" src={astronauta} alt="astronauta" />
    </StyledContainerLogin>
  );
};

export default Login;
