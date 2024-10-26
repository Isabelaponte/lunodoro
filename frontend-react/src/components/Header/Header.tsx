import { Link } from "react-router-dom";
import { Div, H1, HeaderLink, ImageLogo, StyledHeader } from "./Header.styles";
import logo from "../../assets/img/logo.png";

const Header = () => {
  return (
    <StyledHeader>
      <Link to={"/"}>
        <Div>
          <ImageLogo src={logo} alt={"Logo"} />
          <H1>Lunodoro</H1>
        </Div>
      </Link>
      <Link to={"/"}>
        <HeaderLink>Home</HeaderLink>
      </Link>
      <Link to={"/"}>
        <HeaderLink>Lista de Tarefas</HeaderLink>
      </Link>
      <Link to={"/"}>
        <HeaderLink>Relatórios</HeaderLink>
      </Link>
      <Link to={"/"}>
        <HeaderLink>Sobre</HeaderLink>
      </Link>
      <Link to={"/login"}>
        <HeaderLink>Login</HeaderLink>
      </Link>
    </StyledHeader>
  );
};

export default Header;
