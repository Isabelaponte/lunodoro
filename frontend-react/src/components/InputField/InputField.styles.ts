import styled from "styled-components";

export const LabelField = styled.label`
    align-self: flex-start; 
    font-weight: bold;
    color: ${({ theme }) => theme.colors.textColor};
`;

export const InputFieldStyled = styled.input`
  border: 1px solid rgba(255, 255, 255, 0.3);
  border: 1px solid rgba(255, 255, 255, 0.3);
  padding: 0.75rem;
  border-radius: 8px;
  background-color: rgba(255, 255, 255, 0.2);
  width: 100%;
  box-sizing: border-box;
  margin-bottom: 1.5rem;

  @media (max-width: 768px) {
    font-size: 0.9rem;
  }
`;