## 环境要求
```
php ≥ 5.6
composer > 2.0
```

## 日志级别划分
级别	| 描述
---|---
debug |	详细的debug信息。
info|	你的应用中的一些有意义的事件，例如用户登录，记录SQL语句等。
notice|	你的应用中的一些正常但明显有价值的事件。
warning|	出现了异常，但不是错误，例如使用了被废弃的 APIs ，某个 API的 调用异常，或其他不期望出现的，但不是错误的情况。
error	|运行时错误，不需要立即被处理但通常需要被记录或者监控。
*critical|	危险情况，例如某个程序组件不可用，或出现未被捕获的异常等。
*alert	|告警，必须采取行动来修复，例如整个网站宕机或数据库无法访问等。
*emergency	|系统不可用。
alarm | 发出告警

## 日志结构组成

原文:
```
[10:56:19.25] UID:[614becd305fa5] | _INFO_ | LOGIN_ERROR | 用户信息 {"name":"kevin","age":21}
```

结构:

`不带年月日的毫秒级时间`  `日志唯一码` | `日志级别` | `日志标签` | `内容.信息部分` `内容.数据部分`



## composer包的使用
#### 在没有composer的项目引入composer
1. 创建composer.json文件

2. 写入内容
```
{
  "require": {
  }
}
```

#### composer引入
```
composer require bjphp/log
```

#### 引入指定版本
```
composer require bjphp/log:1.2
```

#### 单独升级composer包
```
composer update bjphp/log
```


#### 移除composer包
```
composer remove bjphp/log
```

## 操作步骤
#### 没有composer.json的项目的前置操作
###### 1. 创建composer.json

###### 2. 写入内容
```
{
  "require": {
  }
}
```

#### 主要流程
###### 1. 引入composer包
composer require bjphp/log:1.5

###### 参考 \vendor\bjphp\log\demo.php 使用