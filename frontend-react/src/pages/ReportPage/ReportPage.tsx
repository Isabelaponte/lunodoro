import { useEffect, useState } from "react";
import TableComponent from "../../components/Table/Table";
import useAuthStore from "../../store/useAuthStore";
import {
  CardReport,
  SpanInfoStyled,
  StyledContainerReport,
  StyledH2,
  StyledH3,
  StyledP,
} from "./ReportPage.styles";

const ReportPage = () => {
  const token = localStorage.getItem("token");
  const { user } = useAuthStore.getState();
  const [hours, setHours] = useState<number>(0);

  useEffect(() => {
    if (token) {
      fetch(`http://localhost/luno/lunodoro/relatorio?id_user=${user?.id}`)
        .then((response) => response.json())
        .then((response) => {
          setHours(response.data.total_tempo);
        });
    } else {
      console.log("Não tem token");
    }
  }, [token]);

  return (
    <StyledContainerReport>
      <CardReport>
        <StyledH2>Relatórios</StyledH2>
        <StyledH3>Resumo</StyledH3>
        {!token && (
          <SpanInfoStyled>
            * Este relatório estará disponível quando você estiver logado
          </SpanInfoStyled>
        )}
        <StyledP>Horas focadas nos útimos 7 dias: {hours===0 ? "--" : hours} hora(s)</StyledP>

        <StyledH3>Detalhes de Tempo de Foco</StyledH3>
        {!token && (
          <SpanInfoStyled>
            * Este relatório estará disponível quando você estiver logado
          </SpanInfoStyled>
        )}
        <TableComponent />
      </CardReport>
    </StyledContainerReport>
  );
};

export default ReportPage;
