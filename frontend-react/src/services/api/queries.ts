import api from "./api"

export const getUserById = (id: number) => {
    return api.get(`/usuarios?id=${id}`)
}