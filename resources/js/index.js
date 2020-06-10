import CategoryView from './components/CategoryView'
import CategoryCreateView from './components/CategoryCreateView'

export const routes = [
    { path: '/', name: 'Category', component: CategoryView },
    { path: '/categories/create', name: 'Create', component: CategoryCreateView }
];
