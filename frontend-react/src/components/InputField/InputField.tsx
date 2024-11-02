import { InputFieldStyled, LabelField } from "./InputField.styles";

interface InputFieldProps {
  type: string;
  name: string;
  value?: string;
  placeholder?: string;
  label: string;
  required?: boolean;
}

const InputField = ({ ...props }: InputFieldProps) => {
  return (
    <>
      <LabelField>{props.label}</LabelField>
      <InputFieldStyled
        type={props.type}
        name={props.name}
        placeholder={props.placeholder}
        required={props.required}
      />
    </>
  );
};

export default InputField;
