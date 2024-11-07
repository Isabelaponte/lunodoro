import {
  Main,
  Section,
  SubTitle,
  Paragraph,
  UnorderedList,
  Title,
  List,
  ListItem,
  Link,
} from "./AboutPage.styles";

const AboutPage = () => {
  return (
    <Main>
      <article>
        <header>
          <Title>Perguntas Frequentes</Title>
        </header>
        <Section>
          <header>
            <SubTitle>O que é o Lunodoro?</SubTitle>
          </header>
          <Paragraph>
            O <strong>Lunodoro</strong> é um aplicativo de gerenciamento de
            tempo e tarefas, projetado para ajudá-lo a manter o foco nas suas
            atividades diárias. Com um sistema Pomodoro integrado, ele permite
            que você personalize intervalos de trabalho e pausas, de acordo com
            as suas necessidades. Inspirado na Técnica Pomodoro, o Lunodoro
            ajuda a melhorar a produtividade ao dividir tarefas em blocos de
            tempo focado, ideal para estudar, escrever, programar ou qualquer
            outra atividade que exija concentração.
          </Paragraph>
        </Section>

        <Section>
          <header>
            <SubTitle>O que é a Técnica Pomodoro?</SubTitle>
          </header>
          <Paragraph>
            A{" "}
            <Link href="https://www.pomodorotechnique.com/" target="_blank">
              Técnica Pomodoro
            </Link>{" "}
            é um método de gerenciamento de tempo desenvolvido por Francesco
            Cirillo nos anos 80. Essa técnica utiliza um cronômetro para dividir
            o trabalho em intervalos de 25 minutos, chamados de "pomodoros",
            intercalados por curtas pausas de 5 minutos. Após quatro
            "pomodoros", é recomendado fazer uma pausa mais longa, geralmente de
            15 a 30 minutos. O nome "Pomodoro" vem do cronômetro de cozinha em
            forma de tomate que Cirillo usava durante seus estudos.
          </Paragraph>
        </Section>

        <Section>
          <header>
            <SubTitle>Como usar o timer Pomodoro?</SubTitle>
          </header>
          <Paragraph>
            Para usar o <strong>timer Pomodoro</strong> no Lunodoro:
          </Paragraph>
          <List>
            <ListItem>
              <strong>Planeje suas tarefas:</strong> Organize o que precisa ser
              feito ao longo do dia.
            </ListItem>
            <ListItem>
              <strong>Defina uma estimativa de pomodoros:</strong> Estime
              quantos intervalos de 25 minutos serão necessários para concluir
              cada tarefa.
            </ListItem>
            <ListItem>
              <strong>Selecione uma tarefa:</strong> Escolha uma tarefa para
              focar.
            </ListItem>
            <ListItem>
              <strong>Inicie o cronômetro:</strong> Trabalhe na tarefa durante
              25 minutos ininterruptos.
            </ListItem>
            <ListItem>
              <strong>Faça uma pausa:</strong> Quando o alarme tocar, descanse
              por 5 minutos.
            </ListItem>
            <ListItem>
              <strong>Repita:</strong> Continue o ciclo por 3 a 5 vezes, até que
              as tarefas estejam concluídas.
            </ListItem>
          </List>
        </Section>

        <Section>
          <header>
            <SubTitle>Características básicas</SubTitle>
          </header>
          <Paragraph>
            O Lunodoro oferece várias funcionalidades para melhorar sua
            organização e produtividade:
          </Paragraph>
          <UnorderedList>
            <ListItem>
              <strong>Estimativa de tempo de conclusão:</strong> Obtenha uma
              estimativa do tempo necessário para concluir suas tarefas diárias.
            </ListItem>
            <ListItem>
              <strong>Adicionar modelos:</strong> Salve suas tarefas repetitivas
              como modelos e adicione-as com apenas um clique.
            </ListItem>
            <ListItem>
              <strong>Relatórios visuais:</strong> Veja quanto tempo você se
              concentrou em cada dia, semana e mês.
            </ListItem>
            <ListItem>
              <strong>Configurações personalizadas:</strong> Personalize seu
              tempo de foco/pausa, sons de alarme, sons de fundo e muito mais.
            </ListItem>
          </UnorderedList>
        </Section>
      </article>
    </Main>
  );
};

export default AboutPage;
