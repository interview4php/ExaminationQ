<?php

    /*一.按照给定菜单(menu)和订单(order)，计算订单价格总和*/
    $menu = '[
                {"type_id":1,"name":"大菜","food":[
                                                {"food_id":1,"name":"鱼香肉丝","price":"10"},
                                                {"food_id":2,"name":"红烧肉","price":"11"},
                                                {"food_id":3,"name":"香辣粉","price":"12"}
                                                ]},
                {"type_id":2,"name":"中菜","food":[
                                                {"food_id":4,"name":"小炒肉","price":"13"},
                                                {"food_id":5,"name":"云吞","price":"14"}
                                                ]},
                {"type_id":3,"name":"小菜","food":[
                                                {"food_id":6,"name":"雪糕","price":"15"},
                                                {"food_id":7,"name":"黄瓜","price":"16"}
                                                ]}	    
            ]';
    $order = '[{"food_id":1,"num":2},{"food_id":3,"num":1},{"food_id":6,"num":2},{"food_id":7,"num":1}]';

    $menu      = array_column( json_decode( $menu, true ), 'food' );
    $menu_data = [];
    foreach ($menu as $item) {
        $menu_data = array_merge( $menu_data, $item );
    }
    $price = 0;
    $order = json_decode( $order, true );
    foreach ( $order as $detail ) {
        foreach ( $menu_data as $menu ) {
            if ( $menu['food_id'] == $detail['food_id'] ) {
                $price += $menu['price'] * $detail['num'];
            }
        }
    }
    echo '一:<br>本次应付金额为:' . $price;
    echo '<hr>';
    /****************************************分割线************************************************/
    /*
    二.设计一个类Menu，实现以下功能：
    1. 设定菜单，每个实例必须有且只有一个菜单(json字符串，结构如上题)
    2. 方法calculate, 输入订单后(json字符串，结构如上题), 输出格价
    3. 方法discount, 可设定折扣，输出格价时自动计算折扣
    4. 静态方法counter。输出calculate方法被调用的次数
    5. 将结果发送到2926269816@qq.com，邮件标题写上姓名，谢谢！
    */
    class Menu
    {
        public $menu;
        public static $count;

        public function __construct( $menu = null )
        {
            $this->menu = $menu;
        }

        /**
         * @param $order    type:json 订单
         * @param $discount type:int 折扣
         * @return $price   type:int 最终价格
         */
        public function calculate( $order, $discount = 0 )
        {
            $menu = array_column( json_decode($this->menu, true), 'food' );
            $order = json_decode( $order, true );
            $menu_data = [];
            foreach ( $menu as $v ) {
                $menu_data = array_merge( $menu_data, $v );
            }
            $price = 0;
            foreach ( $order as $item ) {
                foreach ($menu_data as $info) {
                    if ($info['food_id'] == $item['food_id']) {
                        $price += $info['price'] * $item['num'];
                    }
                }
            }
            self::$count += 1;
            if ( $discount != 0 ) {
                $price = $this->discount( $discount, $price );
                return $price;
            }
            return $price;
        }

        /**
         * @param $discount type:int 折扣
         * @param $price    type:int 总价
         * @return          type:int 打完折后的价格
         */
        public function discount( $discount, $price )
        {
            return $price * ( $discount / 10 );
        }

        /**
         * @return $count type:int 下单次数
         * 本来是应该是存储为持久化数据在数据库或者redis中
         */
        public static function counter()
        {
            return self::$count;
        }
    }

    $menu = !empty( $_GET['menu'] ) ? $_GET['menu'] : '[
                {"type_id":1,"name":"大菜","food":[
                                                {"food_id":1,"name":"鱼香肉丝","price":"10"},
                                                {"food_id":2,"name":"红烧肉","price":"11"},
                                                {"food_id":3,"name":"香辣粉","price":"12"}
                                                ]},
                {"type_id":2,"name":"中菜","food":[
                                                {"food_id":4,"name":"小炒肉","price":"13"},
                                                {"food_id":5,"name":"云吞","price":"14"}
                                                ]},
                {"type_id":3,"name":"小菜","food":[
                                                {"food_id":6,"name":"雪糕","price":"15"},
                                                {"food_id":7,"name":"黄瓜","price":"16"}
                                                ]}	    
            ]';
    $order = !empty( $_GET['order'] ) ? $_GET['order'] : '[{"food_id":1,"num":2},{"food_id":3,"num":1},{"food_id":6,"num":2},{"food_id":7,"num":1}]';
    $Menu = new Menu( $menu );
    $price1 = $Menu -> calculate( $order, 5 );
    $price2 = $Menu -> calculate( $order, 6 );
    $price3 = $Menu -> calculate( $order, 7 );
    echo '二:<br>';
    echo '订单1打完5折后的价格是' . $price1 . '<br>';
    echo '订单2打完6折后的价格是' . $price2 . '<br>';
    echo '订单3打完7折后的价格是' . $price3 . '<br>';
    echo '今天总共有:' . Menu::counter() . '张订单';