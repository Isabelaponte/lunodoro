import styled from 'styled-components';

export const StyledCardTask = styled.div`
  display: flex;
  flex-direction: column;
  max-width: 400px;
  margin-top: 2rem;
  width: 100%;
  padding: 1rem;
  background-color: ${({ theme }) => theme.colors.textColor};
  color: ${({ theme }) => theme.colors.bgColor};
  border-radius: 8px;
  gap: 0.75rem;
  `;

export const CardHeader = styled.header`
  display: flex;
  justify-content: space-between;
  align-items: center;
`;

export const CardTitle = styled.h2`
  font-size: 1.25rem;
  color: ${({ theme }) => theme.colors.textColorSecondary};
  margin: 0!important;
`;

export const CardP = styled.p`
  font-size: 0.875rem;
  margin: 0!important;
`;

export const StyledButton = styled.button`
background-color: ${({ theme }) => theme.colors.bgColor};
  border: none;
  margin-top: 16px;
  padding: 0.5rem 1rem;
  font-size: 0.875rem;
  border-radius: 25px;
  cursor: pointer;
  transition: all 0.3s ease;
  max-width: fit-content;
  min-width: 100px;
`;

export const StyledButtonSecondary = styled(StyledButton)`
  background-color: #f0f0f0;
  color: black;
`;

export const OptionsButtonDiv = styled.div`
  display: flex;
  gap: 1rem;
`;

export const EditButton = styled.button`
  background-color: ${({ theme }) => theme.colors.primaryButton};
  border: none;
  padding: 0.5rem 1rem;
  font-size: 0.875rem;
  border-radius: 25px;
  cursor: pointer;
  transition: all 0.3s ease;
  max-width: fit-content;
`;

export const DeleteButton = styled.button`
  background-color: ${({ theme }) => theme.colors.secondaryButton};
  border: none;
  padding: 0.5rem 1rem;
  font-size: 0.875rem;
  border-radius: 25px;
  cursor: pointer;
  transition: all 0.3s ease;
  max-width: fit-content;
`;

export const CardFooter = styled.footer`
  display: flex;
  justify-content: end;
`;

export const CardFooterText = styled.p`
  font-size: 0.8rem;
  margin: 0!important;
  color: ${({ theme }) => theme.colors.textPlaceholderColor};
`;