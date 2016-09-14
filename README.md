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

## 创建Album 模块

ZF3 创建Album 请求参考官方 https://docs.zendframework.com/tutorials/getting-started/modules 说明，
如果需要参考写好后的 ZF3 Album 代码,请参考 [src/module](src/module)

## ZF2 与 ZF3 的 Album 差别

* [Zf2 Album 教程示例](https://framework.zend.com/manual/2.4/en/user-guide/modules.html)
* [Zf3 Album 教程示例](https://docs.zendframework.com/tutorials/getting-started/modules/)


如要看原 ZF2的Album 编写代码,可此参考 (https://github.com/Hounddog/Album)


#### 因ZF3 选中 `PSR-4` 规范，因此目录结构调整：

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

#### `Module.php` 中弃用了 `zend-loader`

`src/Module.php` 参考代码

```php
class Module
{
//选用 Composer 自动加载功能， Zend\Loader 在此不需要
//    public function getAutoloaderConfig()
//    {
//        return array(
//            'Zend\Loader\ClassMapAutoloader' => array(
//                __DIR__ . '/autoload_classmap.php',
//            ),
//            'Zend\Loader\StandardAutoloader' => array(
//                'namespaces' => array(
//                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
//                ),
//            ),
//        );
//    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
```
#### 因 ZF3 `AbstractActionController` 移除了 `getServiceLocator`，推荐创建工厂的方式传入。

`config/module.config.php` 调整

```php
    'controllers' => array(
        'factories' => array(
           //'Album\Controller\Album' => 'Album\Controller\AlbumController',       //原先
            'Album\Controller\Album' => 'Album\Controller\AlbumControllerFactory', //改后
        ),
    ),
```

#### composer.json 配置增加自动加载

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

以上配置好后记得执行以下命令以重新生成 composer 自动加载结构

```bash
$ composer dumpautoload
```