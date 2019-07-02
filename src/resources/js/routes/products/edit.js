const ProductEdit = () => import('../../pages/products/Edit.vue');

export default {
    name: 'products.edit',
    path: ':product/edit',
    component: ProductEdit,
    meta: {
        breadcrumb: 'edit',
        title: 'Edit Products',
    },
};
