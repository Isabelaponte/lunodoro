import { CardHome, StyledButton, StyledContainerHome } from "./Home.styles";

const Home = () => {
  return (
      <StyledContainerHome>
        <CardHome>
          <h1>Bem vindo, Visitante!</h1>
          <p>Para começar, crie sua lista de tarefas e comece a organizar seu tempo de forma eficiente.</p>
          <StyledButton>Acessar minhas listas de tarefas</StyledButton>
        </CardHome>
      </StyledContainerHome>
  );
};

export default Home;