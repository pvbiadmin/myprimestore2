<?php

return [
    'admin' => [
        'pending' => [
            'status' => 'Pending',
            'details' => 'Your order is currently pending'
        ],
        'processed_and_ready_to_ship' => [
            'status' => 'Processed and ready to ship',
            'details' => 'Your order has been processed and will be with our delivery partner soon'
        ],
        'dropped_off' => [
            'status' => 'Dropped off',
            'details' => 'Your package has been dropped off by the seller'
        ],
        'shipped' => [
            'status' => 'Shipped',
            'details' => 'Your package has arrived at our logistics facility'
        ],
        'out_for_delivery' => [
            'status' => 'Out for delivery',
            'details' => 'Our delivery partner will attempt to deliver your package'
        ],
        'delivered' => [
            'status' => 'Delivered',
            'details' => 'Your package has been delivered'
        ],
        'cancelled' => [
            'status' => 'Cancelled',
            'details' => 'Your order has been cancelled'
        ],
        'completed' => [
            'status' => 'Completed',
            'details' => 'Your order has been completed'
        ]
    ],
    'vendor' => [
        'pending' => [
            'status' => 'Pending',
            'details' => 'Your order is currently pending'
        ],
        'processed_and_ready_to_ship' => [
            'status' => 'Processed and ready to ship',
            'details' => 'Your order has been processed and will be with our delivery partner soon'
        ]
    ]
];
