import { Route, Routes } from "react-router-dom";
import Home from "../pages/Home/Home";
import Login from "../pages/Login";
import RootHome from "../pages/RootHome/RootHome";

const AppRouter = () => {
  return (
    <Routes>
      <Route path="/" element={<RootHome />}>
        <Route path="" element={<Home />} />
        <Route path="login" element={<Login />} />
      </Route>
    </Routes>
  );
};

export default AppRouter;
