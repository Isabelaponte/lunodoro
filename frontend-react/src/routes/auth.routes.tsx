import { Route, Routes } from "react-router-dom"
import Login from "../pages/Login/Login"
import SignUp from "../pages/SignUp/SignUp"

const AuthRouter = () => {
    return (
        <Routes>
            <Route path="/login" element={<Login />} />
            <Route path="/register" element={<SignUp />} />
        </Routes>
    )
}

export default AuthRouter