// middleware/guest.ts
export default defineNuxtRouteMiddleware(() => {
  const token = useCookie('auth_token')

  // If user is authenticated, redirect to home
  if (token.value) {
    return navigateTo('/')
  }
})