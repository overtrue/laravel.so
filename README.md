# [laravel.so](http://laravel.so)

http://laravel.so


# 安装

1. 克隆代码到本地

  ```
  git clone https://github.com/laravelso/site
  cd site
  ```

1. 安装依赖

  ```
  composer install -vvv
  ```

1. 修改目录权限:

  ```
  chmod -R 755 ./
  chmod -R 777 ./storage
  ```

1. 编辑 .env 并正确填写数据库部分。

  ```
  cp .env.example .env
  vim .env
  ```

1. 导入数据库：

  ```
  php artisan migrate
  php artisan db:seed
  ```

# License

MIT


