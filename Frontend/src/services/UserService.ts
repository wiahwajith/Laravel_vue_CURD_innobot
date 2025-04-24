import axios from 'axios'

const api = axios.create({
  baseURL: 'http://localhost:8000/api', 
})

export const getUsers = (page = 1, perPage = 10) =>
  api.get(`/users?page=${page}&per_page=${perPage}`)
export const createUser = (formData: FormData) => api.post('/users', formData)
export const updateUser = (id: number, formData: FormData) => api.post(`/users/${id}?_method=PUT`, formData)
export const deleteUser = (id: number) => api.delete(`/users/${id}`)
