import { forwardRef } from "react";
import { InputFieldStyled, LabelField } from "./InputField.styles";

interface InputFieldProps {
  type: string;
  name: string;
  value?: string;
  placeholder?: string;
  label: string;
  required?: boolean;
  onChange?: (e: any) => void;
}

const InputField = forwardRef<HTMLInputElement, InputFieldProps>(
  ({ ...props }, ref) => {
    return (
      <>
        <LabelField>{props.label}</LabelField>
        <InputFieldStyled
          {...props}
          ref={ref}
        />
      </>
    );
  }
);

export default InputField;
