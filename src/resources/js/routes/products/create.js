const ProductCreate = () => import('../../pages/products/Create.vue');

export default {
    name: 'products.create',
    path: 'create',
    component: ProductCreate,
    meta: {
        breadcrumb: 'create',
        title: 'Create Products',
    },
};
