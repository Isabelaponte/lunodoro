import { Route, Routes } from "react-router-dom";
import Home from "../pages/Home/Home";
import Login from "../pages/Login";
import RootHome from "../pages/RootHome/RootHome";
import TaskList from "../pages/TaskList/TaskList";

const AppRouter = () => {
  return (
    <Routes>
      <Route path="/" element={<RootHome />}>
        <Route path="" element={<Home />} />
        <Route path="login" element={<Login />} />
        <Route path="task-list" element={<TaskList />} />
        <Route path="task-list/:taskId" element={<TaskList />} />
      </Route>
    </Routes>
  );
};

export default AppRouter;
