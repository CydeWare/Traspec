// middleware/auth.ts
export default defineNuxtRouteMiddleware((to) => {
  const token = useCookie('auth_token')

  // If trying to access protected route without token
  if (!token.value && to.path !== '/login') {
    return navigateTo('/login')
  }

  // If trying to access login page with valid token
  if (token.value && to.path === '/login') {
    return navigateTo('/')
  }
})