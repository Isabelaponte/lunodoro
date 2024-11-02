import styled from "styled-components";
import { Link } from 'react-router-dom';

export const StyledContainerLogin = styled.div`
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;

  @media (max-width: 1150px) {
    flex-direction: column;
    height: auto;
    padding: 2rem 0;
  }
`;

export const CardLogin = styled.div`
  background: rgba(255, 255, 255, 0.1);
  border-radius: 16px;
  box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
  backdrop-filter: blur(6.7px);
  -webkit-backdrop-filter: blur(6.7px);
  border: 1px solid rgba(255, 255, 255, 0.3);
  max-width: 400px;
  width: 100%;
  padding: 2rem;
  display: flex;
  flex-direction: column;
  justify-content: center;

  @media (max-width: 768px) {
    padding: 1.5rem;
  }
`;

export const H2 = styled.h2`
  font-size: 1.75rem;
  text-align: center;
  margin-top: 0!important;
`;

export const FormLogin = styled.form`
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
`;

export const StyledButton = styled.button`
  padding: 0.75rem;
  border: none;
  background-color: ${({theme}) => theme.colors.linkColor};
  color: ${({theme}) => theme.colors.bgBackground};
  font-size: 1rem;
  font-weight: 600;
  border-radius: 8px;
  cursor: pointer;
  width: 100%;
  transition: background 0.3s ease;
  margin-top: 1rem;

  &:hover {
    background-color: ${({theme}) => theme.colors.textColor};
  }

  @media (max-width: 768px) {
    font-size: 0.9rem;
  }
`;

export const LinkSignUp = styled(Link)`
  text-decoration: none;
  color: ${({theme}) => theme.colors.linkColor};
  font-weight: bold;
  margin-top: 1rem;
`;

export const ImgLogin = styled.img`
  width: 400px;
  margin-left: 2rem;

  @media (max-width: 1150px) {
    display: none;
  }
`;