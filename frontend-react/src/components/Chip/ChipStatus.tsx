import { ChipContainer } from "./ChipStatus.styles";

export enum ChipType {
  IN_PROGRESS,
  COMPLETED,
  EMPTY,
}

export interface ChipStatusProps {
  type: ChipType;
}

const ChipStatus = ({ type }: ChipStatusProps) => {

  return (
    <ChipContainer type={type}>
        {
          type === ChipType.IN_PROGRESS ? 'Em progresso' :
          type === ChipType.COMPLETED ? 'Completo' :
          type === ChipType.EMPTY ? 'Vazia' : ''
        }
    </ChipContainer>
  );
};

export default ChipStatus;