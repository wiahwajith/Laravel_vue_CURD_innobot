// src/helpers/index.ts

export const getProfilePictureUrl = (path: string): string => {
    return path ? `${import.meta.env.VITE_API_BASE_URL}/storage/${path}` : ''
  }
  