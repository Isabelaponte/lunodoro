import { useState, useEffect } from "react";
import { CardHome, StyledButton, StyledContainerHome } from "./Home.styles";
import api from "../../services/api/api";

const Home = () => {
  const [userName, setUserName] = useState("");

  useEffect(() => {
    const token = localStorage.getItem("token");

    if (token) {
      api.get('/usuarios?id=1')
        .then(response => {
          console.log(response.data.data.name);
          setUserName(response.data.data.name);
        })
    } else {
      setUserName("Visitante");
    }
  }, []);

  return (
    <StyledContainerHome>
      <CardHome>
        <h1>Bem vindo, {userName}!</h1>
        <p>Para começar, crie sua lista de tarefas e comece a organizar seu tempo de forma eficiente.</p>
        <StyledButton>Acessar minhas listas de tarefas</StyledButton>
      </CardHome>
    </StyledContainerHome>
  );
};

export default Home;