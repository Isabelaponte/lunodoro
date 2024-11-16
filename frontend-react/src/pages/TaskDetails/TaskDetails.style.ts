import styled from 'styled-components';

export const TimerSection = styled.section`
  margin:  0.5rem 10rem;
  text-align: center;
  background: rgba(255, 255, 255, 0.2);
  font-size: 1.75rem;
`;

export const TimerHeader = styled.header`
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
`;

export const TimerContainerControls = styled.div`
  display: flex;
  width: 100%;
  margin: 0!important;
`

export const TimerControls = styled.div`
  list-style: none;
  width: 50%;
  padding: 1rem 3rem;
  background: rgba(255, 255, 255, 0.1);

  &:hover {
    cursor: pointer;
    background: rgba(255, 255, 255, 0.2);
  }
`

export const TimerButton = styled.button`
  padding: 0.75rem 1.5rem;
  border: none;
  background-color: ${({ theme }) => theme.colors.linkColor};
  color: ${({ theme }) => theme.colors.bgBackground};
  font-size: 1.5rem;
  font-weight: 600;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s ease;
  margin-bottom: 2rem;

  &:hover {
    color: ${({ theme }) => theme.colors.bgBackground};
    background-color: ${({ theme }) => theme.colors.textColor};
  }
`;

export const TasksHeader = styled.header`
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
`;

export const ListTitle = styled.h1`
  font-size: 24px;
`;

export const Button = styled.button`
  background-color: rgba(0, 0, 0, 0.5);
  color: #fff;
  border: none;
  border-radius: 25px;
  padding: 10px 20px;
  font-size: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background-color 0.3s ease, transform 0.2s ease;

  &:hover {
    background-color: rgba(0, 0, 0, 0.8);
    cursor: pointer;
  }
`;

export const TaskList = styled.article`
  display: flex;
  flex-direction: column;
  gap: 20px;
`;

export const TaskContainer = styled.div`
  display: flex;
  flex-direction: column;
  gap: 10px;
`;