<?php

return [

  /*
  * Websend: Sunucunuzla web sitesi arasında bağlantı kuran eklentidir.
  */
  
  'websend' => [
    'host' => env('WEBSEND_HOST', 'localhost'),
    'port' => env('WEBSEND_PORT', 4445),
    'password' => env('WEBSEND_PASSWORD'),
  ],

  /*
  * Sunucu bilgileri
  */

  'server' => [
  	'host' => env('SERVER_HOST', 'localhost'),
  	'port' => env('SERVER_PORT', 25565),
  ],

  /*
  * Üyelik şifreleme methodu: bcrypt, md5
  */

  'auth' => [
    'encryption' => 'bcrypt'
  ]

];
