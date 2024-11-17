import { useState, useEffect } from "react";
import { CardHome, StyledButton, StyledContainerHome } from "./Home.styles";
import useAuthStore from "../../store/useAuthStore";
import { useNavigate } from "react-router-dom";

const Home = () => {
  const navigate = useNavigate();
  const [userName, setUserName] = useState("");

  useEffect(() => {
    const token = localStorage.getItem("token");
    const { user } = useAuthStore.getState();

    if (token) {
      fetch(`http://localhost/luno/lunodoro/usuarios?id=${user?.id}`)
        .then((response) => response.json())
        .then((response) => {
          setUserName(response.data.name);
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
        <StyledButton onClick={() => navigate("/task-list")}>Acessar minhas listas de tarefas</StyledButton>
      </CardHome>
    </StyledContainerHome>
  );
};

export default Home;