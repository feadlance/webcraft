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
    'name' => env('SERVER_TITLE'),
  	'host' => env('SERVER_HOST', 'localhost'),
  	'port' => env('SERVER_PORT', 25565),
  ],

  /*
  * Mob Türleri
  */

  'mobs' => [

    'ANIMALS' => [
        'BAT',
        'CHICKEN',
        'COW',
        'MOOSHROOM',
        'PIG',
        'RABBIT',
        'SHEEP',
        'SKELETON_HORSE',
        'SQUID',
        'DONKEY',
        'HORSE',
        'MULE',
        'OCELOT',
        'WOLF'
      ],

      'MONSTERS' => [
        'CAVE_SPIDER',
        'ENDERMAN',
        'POLAR_BEAR',
        'SPIDER',
        'ZOMBIE_PIGMAN',
        'CREEPER',
        'ELDER_GUARDIAN',
        'ENDERMITE',
        'GHAST',
        'GUARDIAN',
        'HUSK',
        'MAGMA_CUBE',
        'SHULKER',
        'SILVERFISH',
        'SKELETON',
        'SKELETON_HORSEMAN',
        'SLIME',
        'SPIDER_JOCKEY',
        'STRAY',
        'WITCH',
        'WITHER_SKELETON',
        'ZOMBIE',
        'ZOMBIE_VILLAGER',
        'GIANT',
        'KILLER_BUNNY',
        'ZOMBIE_HORSE'
      ],

      'OTHERS' => [
        'ARROW'
      ]

  ],

  /*
  * Üyelik şifreleme methodu: bcrypt, md5
  */

  'auth' => [
    'encryption' => 'bcrypt'
  ]

];
