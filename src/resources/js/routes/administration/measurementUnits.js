import routeImporter from '@core-modules/importers/routeImporter';

const routes = routeImporter(require.context('./measurementUnits', false, /.*\.js$/));
const RouterView = () => import('@core-pages/Router.vue');

export default {
    path: 'measurementUnits',
    component: RouterView,
    meta: {
        breadcrumb: 'measurement units',
        route: 'administration.measurementUnits.index',
    },
    children: routes,
};
