import styled from 'styled-components';

export const StyledHeader = styled.header`
  position: fixed;
  z-index: 1203;
  width: 100%;
  height: 70px;
  background: ${({ theme }) => theme.colors.bgColor};
  display: flex;
  justify-content: space-evenly;
  align-items: center;
  color: ${({ theme }) => theme.colors.textColor};
`;

export const HeaderLink= styled.p`
  color: ${({ theme }) => theme.colors.textColor};
  font-size: 1rem;
  font-weight: 600;
  text-decoration: none;
  cursor: pointer;
`;

export const H1 = styled.h1`
  color: ${({ theme }) => theme.colors.textColor};
  font-size: 1.5rem;
  font-weight: 600;
`;

export const ImageLogo = styled.img`
  width: 40px;
  margin-right: 10px;
`;

export const Div = styled.div`
  display: flex;
  align-items: center;
`;