import styled from 'styled-components';

export const TaskItem = styled.div`
  background-color: #fff;
  padding: 20px;
  border-left: 5px solid;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  display: flex;
  flex-direction: column;
  gap: 10px;
  color: black;

  &.pending {
    border-color: #FFC107;
  }
`;

export const TaskDetails = styled.div`
  display: ${(props) => (props.expanded ? 'block' : 'none')};
  margin-top: 10px;
  padding: 10px;
  border-top: 1px solid #ddd;
  color: black;
`;

export const ExpandButton = styled.button`
  margin-top: 10px;
  color: black;
  border: none;
  padding: 5px 10px;
  cursor: pointer;
  border-radius: 5px;
  text-align: right;
`;

export const TaskName = styled.h2`
  margin-bottom: 10px;
  font-size: 20px;
`;
