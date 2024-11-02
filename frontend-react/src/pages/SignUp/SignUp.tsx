import InputField from "../../components/InputField/InputField";
import { StyledContainerHome } from "../Home/Home.styles";

import astronauta from "../../assets/img/astronauta.png";
import { CardLogin, H2, FormLogin, LinkSignUp, ImgLogin, StyledButton } from "../Login/Login.styles";


//TODO: adicionar controller e chamada api

const SignUp = () => {
  return (
    <StyledContainerHome>
      <CardLogin>
        <H2>Cadastro</H2>
        <FormLogin>
          <InputField name="user" label="Nome de usuário" type="text" required />
          <InputField name="email" label="Email" type="email" required />
          <InputField name="password" label="Senha" type="password" required />
          
          <StyledButton type="submit">Login</StyledButton>
          <LinkSignUp to={"/signup"}>Não tem conta? Cadastre-se</LinkSignUp>
        </FormLogin>
      </CardLogin>

      <ImgLogin id="img_astronauta" src={astronauta} alt="astronauta" />
    </StyledContainerHome>
  );
};

export default SignUp;
