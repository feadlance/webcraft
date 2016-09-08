<?php

return [

  /*
  * Sunucu Rcon
  */

  'rcon' => [
    'port' => env('RCON_PORT', 25575),
    'password' => env('RCON_PASSWORD')
  ],

  /*
  * Query Portu
  */

  'query' => [
    'port' => env('QUERY_PORT', 25585)
  ],

  /*
  * Sunucu bilgileri
  */

  'server' => [
    'name' => env('APP_NAME', 'WebCraft'),
  	'host' => env('SERVER_HOST', 'localhost'),
  	'port' => env('SERVER_PORT', 25565)
  ],

  /*
  * Üyelik şifreleme methodu: bcrypt, md5
  */

  'auth' => [
    'encryption' => env('AUTH_ENCRYPTION', 'md5')
  ],

  /*
  * Site Teması
  */

  'template' => env('SITE_TEMPLATE', 'default'),

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
        'ARROW',
        'FALL',
        'LAVA'
      ]

  ]

];
