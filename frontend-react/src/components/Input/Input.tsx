import { InputBox, InputFieldStyled, Label } from "./Input.styles";
const Input = () => {
  return (
    <InputBox>
        <Label>Nome</Label>
        <InputFieldStyled name="name" label="Nome" required />
    </InputBox>
  );
};

export default Input;