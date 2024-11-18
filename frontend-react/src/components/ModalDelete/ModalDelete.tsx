import useAuthStore from "../../store/useAuthStore";
import ModalConfirmBase from "../ModalConfirmBase/ModalConfirmBase";
import CloseOutlinedIcon from "@mui/icons-material/CloseOutlined";

interface ModalDeleteListProps {
  open: boolean;
  onClose: () => void;
  id: string | null;
}

const ModalDeleteList = ({ open, onClose, id }: ModalDeleteListProps) => {
  const { user } = useAuthStore.getState();
  
  const confirmDelete = async () => {
    fetch(
      `http://localhost/luno/lunodoro/lista?id_user=${user?.id}&id_list=${id}` ,{
        method: "DELETE"
      }
    )
      .then((response) => response.json())
      .then((response) => {
        console.log(response);
      });
    onClose();
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
