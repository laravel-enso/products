# Products

Products package is an extesion of the Laravel Enso enviroment, designed for management of products.

**Note:** *This package cannot be used outside of enso enviroment and is not included in [Laravel Enso Core](https://github.com/laravel-enso/Core) packages.*

### Features
* crud operations for products
* measurement units enum
* includes seeders & factories
* includes front-end assets
* default supplier management
* tests

### Instalation
* install the package using composer: `composer require laravel-enso/products`
* adds the following alias in `webackpack.mix.js`
```
.webpackConfig({
        resolve: {
            extensions: ['.js', '.vue', '.json'],
            alias: {
                 //other aliases
                '@products': `${__dirname}/vendor/laravel-enso/products/src/resources/js`,
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
    .add(routeImporter(require.context('./routes', false, /.*\.js$/)))
    .add(routeImporter(require.context('@products/routes', false, /.*\.js$/)));
```

* in `resources/js/app.js` import the package's icons

`import '@products/icons'`

* make sure `hot module replacement` is **not** active, and run `yarn dev` or `npm run dev`

### Publishes
* you can publish the currency seeder and customize it to your liking

`php artisan vendor:publish --tag=currency-seeder`

### Icons
The package uses the following icons:
* `fab product-hunt`

### Contributions

are welcome. Pull requests are great, but issues are good too.

### License

This package is released under the MIT license.


