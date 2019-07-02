import routeImporter from '@core-modules/importers/routeImporter';

const routes = routeImporter(require.context('./products', false, /.*\.js$/));
const RouterView = () => import('@core-pages/Router.vue');

export default {
    path: '/products',
    component: RouterView,
    meta: {
        breadcrumb: 'products',
        route: 'products.index',
    },
    children: routes,
};
