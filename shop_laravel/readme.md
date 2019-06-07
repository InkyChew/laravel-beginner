<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Demo
http://eggroll-shop-laravel.herokuapp.com

## Usage
- laravel v5.8
- php7
- Homestead
- vagrant
- mysql

## Notes
<h3>發布至Heroku後</h3>
- 原本地端DB_CONNECTION使用mysql</br>
為發布至Heroku，使用pgsql(postgresql)</br>
並且在composer.json 中加入gd擴充</br>
<img src="https://upload.cc/i1/2019/06/07/6k1BJ7.png">
<img src="https://upload.cc/i1/2019/06/07/djI3Oo.png">

- 圖片的呈現方式為取出DB中的url</br>
因Heroku不提供儲存空間，照片upload後不會存在。