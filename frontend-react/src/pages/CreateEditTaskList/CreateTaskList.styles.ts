import styled from "styled-components";

export const Form = styled.form`
  display: flex;
  flex-direction: column;
  gap: 1rem;
`;

export const CancelButton = styled.button`
  border: none;
  padding: 0.5rem 1rem;
  font-size: 0.875rem;
  border-radius: 25px;
  cursor: pointer;
  transition: all 0.3s ease;
  max-width: fit-content;
  margin-top: 1rem;
  min-width: 100px;
`;

export const DivOptions = styled.div`
  display: flex;
  gap: 1rem;
`;

export const SpanInfo = styled.span`
  font-size: 0.875rem;
  color: ${({ theme }) => theme.colors.textPlaceholderColor};
  text-align: center;
`;