import TableComponent from "../../components/Table/Table";
import {
  CardReport,
  SpanInfoStyled,
  StyledContainerReport,
  StyledH2,
  StyledH3,
  StyledP,
} from "./ReportPage.styles";

const ReportPage = () => {
  return (
    <StyledContainerReport>
      <CardReport>
        <StyledH2>Relatórios</StyledH2>
        <StyledH3>Resumo</StyledH3>
        <SpanInfoStyled>
          * Este relatório estará disponível quando você estiver logado
        </SpanInfoStyled>
        <StyledP>Horas focadas: -</StyledP>

        <StyledH3>Detalhes de Tempo de Foco</StyledH3>
        <SpanInfoStyled>
          * Este relatório estará disponível quando você estiver logado
        </SpanInfoStyled>
        <TableComponent />

        <StyledH3>Resumo das Atividades</StyledH3>
        <SpanInfoStyled>
          * Este relatório estará disponível quando você estiver logado
        </SpanInfoStyled>

      </CardReport>
    </StyledContainerReport>
  );
};

export default ReportPage;
