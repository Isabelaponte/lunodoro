import { Route, Routes } from "react-router-dom";
import Home from "../pages/Home";
import Login from "../pages/Login";

const AppRouter = () => {
  return (
    <Routes>
      <Route path="/">
        <Route path="home" element={<Home />} />
        <Route path="login" element={<Login />} />
      </Route>
    </Routes>
  );
};

export default AppRouter;
