import styled from "styled-components";

export const Main = styled.main`
  max-width: 620px;
  margin: 2.5rem auto;
  padding: 20px;
  background: rgba(0, 0, 0, 0.21);
  border-radius: 16px;
  box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
  backdrop-filter: blur(6.7px);
  -webkit-backdrop-filter: blur(6.7px);
  border: 1px solid rgba(0, 0, 0, 0.07);
  color: ${({ theme }) => theme.colors.textColor};
`;

export const Section = styled.section`
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  margin-top: 0.5rem;
`;

export const Title = styled.h1`
  font-size: 2rem;
  color: ${({ theme }) => theme.colors.textColor};
`;

export const SubTitle = styled.h2`
  font-size: 1.5rem;
  color: ${({ theme }) => theme.colors.textColor};
  &::after {
    content: "";
    display: block;
    width: 24px;
    padding-top: 8px;
    border-bottom: 4px solid ${({ theme }) => theme.colors.linkColor};;
    opacity: 0.6;
  }
`;

export const Paragraph = styled.p`
  padding-left: 1rem;
`;

export const List = styled.ol`
  padding-left: 2.5rem;
`;

export const UnorderedList = styled.ul`
  padding-left: 2.5rem;
`;

export const ListItem = styled.li`
  margin: 0.7rem 0;
`;

export const Link = styled.a`
  text-decoration: none;
  font-weight: 600;
  color: ${({ theme }) => theme.colors.linkColor};
`;