<?php

// Defining menu structure here
// the items that need to appear when user is logged in should have logged_in set as true
return array(

    'menu' => array(
        array(
            'label' => '浏览',
            'route' => 'browse.recent',
            'active' => array('/','popular','comments'),
        ),
        array(
            'label' => '分类',
            'route' => 'browse.categories',
            'active' => array('categories*'),
        ),
        array(
            'label' => '标签',
            'route' => 'browse.tags',
            'active' => array('tags*'),
        ),
        array(
            'label' => '发布',
            'route' => 'tricks.new',
            'active' => array('user/tricks/new'),
            // 'logged_in' => true
        ),
    ),

    'browse' => array(
        array(
            'label' => '最新',
            'route' => 'browse.recent',
            'active' => array('/'),
        ),
        array(
            'label' => '热门',
            'route' => 'browse.popular',
            'active' => array('popular'),
        ),
        array(
            'label' => '评论最多',
            'route' => 'browse.comments',
            'active' => array('comments'),
        ),
    ),

);
