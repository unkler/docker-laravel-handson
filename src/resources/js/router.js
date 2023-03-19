import Vue from 'vue'
import VueRouter from 'vue-router'
import TaskAssignIndex from './pages/TaskAssign/Index.vue'
import TaskAssignCreate from './pages/TaskAssign/Create.vue'
import TaskAssignEdit from './pages/TaskAssign/Edit.vue'
import EmployeeIndex from './pages/Employee/Index.vue'
import EmployeeCreate from './pages/Employee/Create.vue'
import EmployeeEdit from './pages/Employee/Edit.vue'
import ClientIndex from './pages/Client/Index.vue'
import ClientCreate from './pages/Client/Create.vue'
import ClientEdit from './pages/Client/Edit.vue'
import WorkplaceIndex from './pages/Workplace/Index.vue'
import WorkplaceCreate from './pages/Workplace/Create.vue'
import WorkplaceEdit from './pages/Workplace/Edit.vue'
import NotFound from './pages/NotFound.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'taskAssign',
    component: TaskAssignIndex,
    props: true,
  },
  {
    path: '/create',
    name: 'taskAssignCreate',
    component: TaskAssignCreate,
  },
  {
    path: '/edit/:id',
    name: 'taskAssignEdit',
    component: TaskAssignEdit,
    props: true,
  },
  {
    path: '/employee',
    name: 'employee',
    component: EmployeeIndex,
    props: true,
  },
  {
    path: '/employee/create',
    name: 'employeeCreate',
    component: EmployeeCreate,
  },
  {
    path: '/employee/edit/:id',
    name: 'employeeEdit',
    component: EmployeeEdit,
    props: true,
  },
  {
    path: '/client',
    name: 'client',
    component: ClientIndex,
    props: true,
  },
  {
    path: '/client/create',
    name: 'clientCreate',
    component: ClientCreate,
  },
  {
    path: '/client/edit/:id',
    name: 'clientEdit',
    component: ClientEdit,
    props: true,
  },
  {
    path: '/workplace',
    name: 'workplace',
    component: WorkplaceIndex,
    props: true,
  },
  {
    path: '/workplace/create',
    name: 'workplaceCreate',
    component: WorkplaceCreate,
  },
  {
    path: '/workplace/edit/:id',
    name: 'workplaceEdit',
    component: WorkplaceEdit,
    props: true,
  },
  { path: '/*', 
    component: NotFound,
  },
]

const router = new VueRouter({
    mode: 'history',
    routes
})

export default router