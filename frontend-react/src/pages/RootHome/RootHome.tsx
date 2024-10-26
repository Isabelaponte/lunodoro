import { Outlet } from "react-router-dom";
import { StyledContainerContent, StyledMain, StyledSection } from "./RootHome.styles";
import Header from "../../components/Header/Header";

const RootHome = () => {
  return (
    <StyledSection>
        <Header />
        <StyledContainerContent>
            <StyledMain>
                <Outlet />
            </StyledMain>
        </StyledContainerContent>
    </StyledSection>
  );
};

export default RootHome;