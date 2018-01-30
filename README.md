# yii2-insurance
===============

基于yii2搭建的保险系统
-----------

#### 开发环境和生产环境的设置

*入口设置：

*在web/index.php中：

*测试环境：
```php 
defined('YII_DEBUG') or define('YII_DEBUG', true);  
defined('YII_ENV') or define('YII_ENV', 'dev');
```
*生产环境：
```php 
//defined('YII_DEBUG') or define('YII_DEBUG', true);  
defined('YII_ENV') or define('YII_ENV', 'prod'); 
```
*设置成生产环境后

*/runtime/debug就不会写入debug等文件了，log中也不会继续写入文件
