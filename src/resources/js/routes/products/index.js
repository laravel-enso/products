const ProductsIndex = () => import('../../pages/products/Index.vue');

export default {
    name: 'products.index',
    path: '',
    component: ProductsIndex,
    meta: {
        breadcrumb: 'index',
        title: 'Products',
    },
};
