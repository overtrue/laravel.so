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

用户名：`admin` 密码：`password`

# Vue 例子

1. 在项目根目录, 安装依赖

  ```
  npm install --no-bin-links
  ```

1. 资源文件编译及合并

  ```
  gulp
  ```

1. 设置路由 `app/Http/routes.php`

  ```
  Route::get('example/{vue_capture?}', function () {
    return view('example');
  });
  ```

访问 [http://site.app/example]()

# License

MIT


