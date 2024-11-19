import useAuthStore from "../../store/useAuthStore";
import { Severety, useNotificationStore } from "../../store/useNotification";
import ModalConfirmBase from "../ModalConfirmBase/ModalConfirmBase";
import CloseOutlinedIcon from "@mui/icons-material/CloseOutlined";

interface ModalDeleteListProps {
  open: boolean;
  onClose: () => void;
  id: string | null;
}

const ModalDeleteList = ({ open, onClose, id }: ModalDeleteListProps) => {
  const { user } = useAuthStore.getState();
  
  const notify = useNotificationStore((state) => state.notify);
  
  const confirmDelete = async () => {
    try {
      const response = await fetch(
        `http://localhost/luno/lunodoro/lista?id_user=${user?.id}&id_list=${id}`,
        {
          method: "DELETE",
        }
      );
  
      if (!response.ok) {
        throw new Error(`Erro ao excluir lista: ${response.statusText}`);
      }
  
      onClose();
      notify({ message: "Lista excluída com sucesso!", severety: Severety.SUCCESS });
    } catch (error) {
      notify({ message: `${error}`, severety: Severety.ERROR });
      console.log(error);
    }
  };
  

  return (
    <ModalConfirmBase
      open={open}
      onClose={() => onClose()}
      onConfirm={() => confirmDelete()}
      icon={<CloseOutlinedIcon />}
      content={`Deseja deletar o item selecionado?`}
      confirmText={"Deletar"}
      cancelText={"Cancelar"}
    />
  );
};

export default ModalDeleteList;
