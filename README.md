# ZendSkeletonApplication Album 教程

## 安装

通过 Composer 进行安装

```bash
$ composer create-project -sdev zendframework/skeleton-application path/to/install
```

提示是否最小安装时，选择`N`，因为 Album 需要 `zend-db` `zend-form` `zend-i18n` 组件支持，
其它组件根据自己熟悉情况安装，本教程其它都选 `N`:

```bash
Do you want a minimal install (no optional packages)? Y/n
> n
Would you like to install the developer toolbar? y/N
Would you like to install caching support? y/N
Would you like to install database support (installs zend-db)? y/N
> y
Will install zendframework/zend-db (^2.8.1)
Would you like to install forms support (installs zend-form)? y/N
> y
Would you like to install JSON de/serialization support? y/N
Would you like to install logging support? y/N
Would you like to install MVC-based console support? (We recommend migrating to zf-console, symfony/console, or Aura.CLI) y/N
Would you like to install i18n support? y/N
> y
Would you like to install the official MVC plugins, including PRG support, identity, and flash messages? y/N
Would you like to use the PSR-7 middleware dispatcher? y/N
Would you like to install sessions support? y/N
Would you like to install MVC testing support? y/N
Would you like to install the zend-di integration for zend-servicemanager? y/N

Updating root package
    Running an update to install optional packages

...

Updating application configuration...

  Please select which config file you wish to inject 'Zend\Db' into:
  [0] Do not inject
  [1] config/modules.config.php
  Make your selection (default is 0): 1  ##这里都选择 1，加载到配置项中
  
  Remember this option for other packages of the same type? (y/N)
```

到此访问 `public/` 目录会出现 ”Welcome to Zend Framework“

详细安装说明参考 [官方 skeleton-application 文档](https://docs.zendframework.com/tutorials/getting-started/skeleton-application/) 

## 创建 Album

为方便创建，本示例中的 Album 是克隆 [ZF2 Album 教程代码](`https://github.com/Hounddog/Album`)中的  并加以调整

```bash
$ cd module
$ git clone https://github.com/Hounddog/Album
```

由于官方示例是根据 ZF2 创建的，此 ZF3 不适用，需要稍作调整，调整点及原因见以下说明：

1. 因ZF3 选中 `PSR-4` 规范，因此目录结构调整，并弃用`zend-loader`：

ZF2 示例目录结构：

```
|   autoload_classmap.php
|   Module.php
|
+---config
|       module.config.php
|
+---data
+---src
|   \---Album
|       +---Controller
|       |       AlbumController.php
|       |
|       +---Form
|       |       AlbumForm.php
|       |
|       \---Model
|               Album.php
|               AlbumTable.php
|
+---test
|
\---view
    \---album
        \---album
```


调整后的目录结构：

```
+---config
|       module.config.php
|
+---data
+---src
|   |   Module.php
|   |
|   +---Controller
|   |       AlbumController.php
|   |
|   +---Form
|   |       AlbumForm.php
|   |
|   \---Model
|           Album.php
|           AlbumTable.php
|
+---test
|
\---view
    \---album
        \---album
```

2. 因 ZF3 `AbstractActionController` 移除了 `getServiceLocator`，推荐创建工厂的方式传入。

`config/module.config.php` 调整

```php
    'controllers' => array(
        'factories' => array(
           //'Album\Controller\Album' => 'Album\Controller\AlbumController',       //原先
            'Album\Controller\Album' => 'Album\Controller\AlbumControllerFactory', //改后
        ),
    ),
```

3. composer.json 配置增加自动加载

```
    "autoload": {
        "psr-4": {
            "Application\\": "module/Application/src/",
            "Album\\": "module/Album/src/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "ApplicationTest\\": "module/Application/test/",
            "AlbumTest\\": "module/Album/test/"
        }
    },
```