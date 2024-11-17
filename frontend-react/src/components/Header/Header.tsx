import { Link, useNavigate } from "react-router-dom";
import {
  Div,
  H1,
  HeaderLink,
  HeaderLinkLogin,
  ImageLogo,
  Logout,
  StyledHeader,
} from "./Header.styles";
import logo from "../../assets/img/logo.png";
import useAuthStore from "../../store/useAuthStore";

const Header = () => {
  const { token } = useAuthStore.getState();
  const logout = useAuthStore((state) => state.logout);
  const navigate = useNavigate();

  const handleLogout = () => {
    logout();
    navigate("/login");
  };

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
      <Link to={"/task-list"}>
        <HeaderLink>Lista de Tarefas</HeaderLink>
      </Link>
      <Link to={"/report"}>
        <HeaderLink>Relatórios</HeaderLink>
      </Link>
      <Link to={"/about"}>
        <HeaderLink>Sobre</HeaderLink>
      </Link>
      {token ? (
        <Logout onClick={handleLogout}>Logout</Logout>
      ) : (
        <Link to={"/login"}>
          <HeaderLinkLogin>Login</HeaderLinkLogin>
        </Link>
      )}
    </StyledHeader>
  );
};

export default Header;
