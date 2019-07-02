import routeImporter from '@core-modules/importers/routeImporter';

const routes = routeImporter(require.context('./administration', false, /.*\.js$/));

export default {
    path: '/administration',
    children: routes,
};
