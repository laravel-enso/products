# Products

Products is a package for the Laravel Enso enviroment, designed for the management of products.

**Note:** *This package cannot be used outside of the Enso enviroment and is not included by default 
in the [Laravel Enso Core](https://github.com/laravel-enso/Core) package.*

### Features
* crud operations for products
* measurement units enum
* includes a publishable product factory
* default supplier management
* tests

### Instalation
* install the package using composer: `composer require laravel-enso/products`
* install the front-end ui package using yarn: `yarn add @enso-ui/products`
* adds the following alias in `webackpack.mix.js`
```
.webpackConfig({
        resolve: {
            extensions: ['.js', '.vue', '.json'],
            alias: {
                 //other aliases
                '@products': `${__dirname}/node_modules/@enso-ui/products/src/bulma`,
            },
        },
    })
```
* in `resources/js/router.js` file, verify that `RouteMerger` is imported, or import it

`import RouteMerger from '@core-modules/importers/RouteMerger';`

* make sure `routeImporter` is also imported

`import routeImporter from '@core-modules/importers/routeImporter';`

* then use `RouteMerger` to import front-end assets using the alias defined in `webpack.mix.js`

```
(new RouteMerger(routes))
    //other routes
    .add(routeImporter(require.context('@products/routes', false, /.*\.js$/)))
    .add(routeImporter(require.context('./routes', false, /.*\.js$/)));
```

* in `resources/js/app.js` import the package's icons

`import '@products/icons'`

* make sure `hot module replacement` is **not** active, and run `yarn dev` or `npm run dev`

* run `php artisan migrate` to create table, add menu, permissions etc.

### Publishes
* you can publish the product seeder and customize it to your liking

`php artisan vendor:publish --tag=products-factories`

### Contributions

are welcome. Pull requests are great, but issues are good too.

### License

This package is released under the MIT license.


