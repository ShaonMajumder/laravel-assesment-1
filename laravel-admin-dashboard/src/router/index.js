import { createRouter, createWebHistory } from 'vue-router'
import Dashboard from '../views/Dashboard.vue'
import EmployeeForm from '../views/EmployeeForm.vue'

const routes = [
  { path: '/', component: Dashboard },
  { path: '/employees/create', component: EmployeeForm },
  { path: '/employees/edit/:id', component: EmployeeForm, props: true }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
