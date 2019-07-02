const MeasurementUnitEdit = () => import('../../../pages/measurementUnits/Edit.vue');

export default {
    name: 'administration.measurementUnits.edit',
    path: ':measurementUnit/edit',
    component: MeasurementUnitEdit,
    meta: {
        breadcrumb: 'edit',
        title: 'Edit Measurements Units',
    },
};
