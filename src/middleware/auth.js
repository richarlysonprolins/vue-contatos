// src/middleware/auth.js
export function requireAuth(to, from, next) {
  const token = localStorage.getItem('authToken')
  const user = localStorage.getItem('user')
  
  if (!token || !user) {
    next('/')
  } else {
    next()
  }
}