import { useForm, FieldValues, DefaultValues } from 'react-hook-form';
import { yupResolver } from '@hookform/resolvers/yup';
import { AnyObjectSchema } from 'yup';

export const useFormUtils = <TFieldValues extends FieldValues>(
  validationSchema: AnyObjectSchema,
  defaultValues: DefaultValues<TFieldValues>
) => {
  const {
    control,
    formState: { errors },
    getValues,
    setValue,
    handleSubmit,
    reset,
    watch,
    register,
    formState,
    trigger
  } = useForm<TFieldValues>({
    resolver: yupResolver(validationSchema),
    reValidateMode: 'onChange',
    mode: 'all',
    defaultValues
  });

  const resetForm = () => reset(defaultValues);

  return {
    control,
    errors,
    getValues,
    setValue,
    resetForm,
    handleSubmit,
    register,
    trigger,
    watch,
    formState
  };
};
