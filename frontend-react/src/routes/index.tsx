import { FC } from "react";
import AppRouter from "./app.routes";
//EXEMPLO DE USO PARA VERIFICAR SE O TOKEN ESTÁ PRESENTE --> Dependencia nao instalada
//import { secureLocalStorage } from "react-secure-storage";

const Router: FC = () => {
//   return secureLocalStorage.getItem("@:access_token") ? (
    return (<AppRouter />)
//   ) : (
    // <AuthRouter />
//   );
};

export default Router;
