import ModalConfirmBase from "../ModalConfirmBase/ModalConfirmBase";
import CloseOutlinedIcon from "@mui/icons-material/CloseOutlined";

interface ModalDeleteProps {
  open: boolean;
  onClose: () => void;
  title: string;
  id: string;
  queryKey?: string;
  queryFn: (id: string) => any;
}

const ModalDelete = ({
  open,
  onClose,
  queryKey = "Posts",
  queryFn,
  title,
  id,
}: ModalDeleteProps) => {

  const confirmDelete = async () => {
    // await queryFn(id);
    onClose();
  };

  console.log(queryKey);
  console.log(queryFn);
  console.log(title);
  console.log(id);

  return (
    <ModalConfirmBase
      open={open}
      onClose={() => onClose()}
      onConfirm={() => {}}
      icon={<CloseOutlinedIcon />}
      content={`Deseja deletar "${title}"?`}
      confirmText={"Deletar"}
      cancelText={"Cancelar"}
    />
  );
};

export default ModalDelete;
