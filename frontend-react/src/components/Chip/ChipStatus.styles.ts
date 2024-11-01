import styled, { css } from 'styled-components';
import { ChipStatusProps } from './ChipStatus';
import { ChipType } from '../../utils/enums/status.enum';

const getChipStyles = (type: ChipType) => {
  switch (type) {
    case ChipType.IN_PROGRESS:
      return css`
        background-color: ${({ theme }) => theme.colors.chips.inProgress.backgroundColor};
        color: ${({ theme }) => theme.colors.chips.inProgress.color};
        `;
    case ChipType.COMPLETED:
      return css`
      background-color: ${({ theme }) => theme.colors.chips.completed.backgroundColor};
      color: ${({ theme }) => theme.colors.chips.completed.color};
      `;
    case ChipType.EMPTY:
      return css`
      background-color: ${({ theme }) => theme.colors.chips.empty.backgroundColor};
      color: ${({ theme }) => theme.colors.chips.empty.color};
      `;
    default:
      return css``;
  }
};

export const ChipContainer = styled.div<ChipStatusProps>`
      display: inline-flex;
      align-items: center;
      border-radius: 20px;
      font-weight: 600;
      padding: 0.25rem 0.75rem;
      margin-bottom: 1rem;
      font-size: 0.875rem;

    ${(props) => getChipStyles(props.type)}
      `;

