## Install

```
$ Clone the project
$ cd lachambrenoire
$ cp wp-config-sample.php wp-config.php
```

Then modify the database connection informations

```
$ git submodule init
$ git submodule update --init
$ mkdir -p content/uploads
$ chmod -R 755 content/uploads/
$ cd content/themes/lachambrenoire
$ npm i
$ grunt serve
```


If you want to use YeoPress:
`
npm install -g yo generator-wordpress
`
and you can do:
`
yo wordpress:plugin
`
to install plugins
