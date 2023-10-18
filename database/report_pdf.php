<?php
    require('fpdf/fpdf.php');

    class PDF extends FPDF{
        function __construct(){
            parent::__construct('L');
        }

        // Colored table
        function FancyTable($headers, $data, $row_height = 50)
        {
            // Colors, line width, and bold font
            $this->SetFillColor(255, 0, 0);
            $this->SetTextColor(255);
            $this->SetDrawColor(128, 0, 0);
            $this->SetLineWidth(.3);
            $this->SetFont('', 'B');

            $width_sum = 0;
            foreach ($headers as $header_key => $header_data) {
                $width = $header_data['width'];
                $this->Cell($width, 7, $header_key, 1, 0, 'C', true);
                $width_sum += $width;
            }

            $this->Ln();
            // Color and font restoration
            $this->SetTextColor(0);
            $this->SetFont('');

            $img_pos_y = 40;
            $header_keys = array_keys($headers);
            foreach ($data as $row) {
                foreach ($header_keys as $header_key) {
                    $content = $row[$header_key]['content'];
                    $width = $headers[$header_key]['width'];
                    $align = $row[$header_key]['align'];

                    // Inside the foreach loop for data rows
                    if ($header_key == 'image') {
                        $img_width = $width - 2; // Adjusted width to fit inside the container
                        $img_height = $row_height - 2; // Adjusted height to fit inside the container

                        if (!is_null($content) && $content != "") {
                            $imagePath = '.././uploads/products/' . $content;
                            $img_pos_x = $this->GetX() + 1; // X-position for image
                            $img_pos_y = $this->GetY() + 1; // Y-position for image

                            $this->Cell($width, $row_height, '', 'LTRB', 0, $align); // Empty container cell
                            $this->Image($imagePath, $img_pos_x, $img_pos_y, $img_width, $img_height); // Image placement
                        } else {
                            $this->Cell($width, $row_height, 'No Image', 'LTRB', 0, $align); // Text for no image
                        }
                    } else {
                        $this->Cell($width, $row_height, $content, 'LTRB', 0, $align); // Other data cells
                    }
                }

                $this->Ln();
                $img_pos_y += $row_height;
            }

            // Closing line
            $this->Cell($width_sum, 0, '', 'T');
        }
    }

    $type = $_GET['report'];
    // $report_headers = [
    //     'product' => 'KING SUN ENTERPRISES'."\n".'049 Corrales Ave., cor. Domingo Velez St.,'."\n".' Cagayan de Oro City, Mis. Or. Philippines'."\n".' Cell No. 0922-872-6189'."\n".'NEMIA LAO SING - Prop.'."\n".'VAT REG. TIN: 180-808-484-00000.',
    //     'supplier' => 'Supplier Report',
    //     'delivery' => 'Delivery Report',
    //     'purchase_orders' => 'Purchase Order Report'
    // ];
    $report_headers = [
        'product' => 'KING SUN ENTERPRISES'."\n".'049 Corrales Ave., cor. Domingo Velez St.,'."\n".' Cagayan de Oro City, Mis. Or. Philippines'."\n".' Cell No. 0922-872-6189'."\n".'NEMIA LAO SING - Prop.'."\n".'VAT REG. TIN: 180-808-484-00000.',
        'supplier' => 'KING SUN ENTERPRISES'."\n".'049 Corrales Ave., cor. Domingo Velez St.,'."\n".' Cagayan de Oro City, Mis. Or. Philippines'."\n".' Cell No. 0922-872-6189'."\n".'NEMIA LAO SING - Prop.'."\n".'VAT REG. TIN: 180-808-484-00000.',
        'delivery' => 'KING SUN ENTERPRISES'."\n".'049 Corrales Ave., cor. Domingo Velez St.,'."\n".' Cagayan de Oro City, Mis. Or. Philippines'."\n".' Cell No. 0922-872-6189'."\n".'NEMIA LAO SING - Prop.'."\n".'VAT REG. TIN: 180-808-484-00000.',
        'purchase_orders' => 'KING SUN ENTERPRISES'."\n".'049 Corrales Ave., cor. Domingo Velez St.,'."\n".' Cagayan de Oro City, Mis. Or. Philippines'."\n".' Cell No. 0922-872-6189'."\n".'NEMIA LAO SING - Prop.'."\n".'VAT REG. TIN: 180-808-484-00000.',
        'employee' => 'KING SUN ENTERPRISES'."\n".'049 Corrales Ave., cor. Domingo Velez St.,'."\n".' Cagayan de Oro City, Mis. Or. Philippines'."\n".' Cell No. 0922-872-6189'."\n".'NEMIA LAO SING - Prop.'."\n".'VAT REG. TIN: 180-808-484-00000.',
        'collect_receipts' => 'KING SUN ENTERPRISES'."\n".'049 Corrales Ave., cor. Domingo Velez St.,'."\n".' Cagayan de Oro City, Mis. Or. Philippines'."\n".' Cell No. 0922-872-6189'."\n".'NEMIA LAO SING - Prop.'."\n".'VAT REG. TIN: 180-808-484-00000.'
    ];
    $row_height = 18;

    // Pull data from database.
    include('connection.php');


    //Product Export
    if($type == 'product'){
        // Column headings - replace from mysql datábase or hardcode it
        $headers = [
            'id' => [
                'width' => 15
            ],
            'item_code' => [
                'width' => 30
            ],
            'product_name' => [
                'width' => 55
            ],
            'category' => [
                'width' => 35
            ],
            'stocks' => [
                'width' => 15
            ],
            'price' => [
                'width' => 15
            ],
            'created_by' => [
                'width' => 22
            ],
            'created_at' => [
                'width' => 40
            ],
            'updated_at' => [
                'width' => 40
            ]
        ];
    

        //Load product
        $stmt = $conn->prepare("SELECT 
            `products`.`item_code`,
            `products`.`product_name`,
            `products`.`description`,
            `products`.`category`,
            `products`.`img`,
            `products`.`stocks`,
            `products`.`price`,
            `products`.`created_by`,
            `products`.`created_at`,
            `products`.`updated_at`,
            `users`.`first_name`,
            `users`.`last_name`,
            products.id as pid 
            FROM products 
            INNER JOIN 
                users ON 
                products.created_by = users.id 
                ORDER BY 
                products.created_at DESC");

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $products = $stmt->fetchAll();

        $data = [];
        foreach($products as $product){
            $product['created_by'] = $product['first_name'] . ' ' . $product['last_name'];
            unset($product['first_name'], $product['last_name'], $product['password'], $product['email']);

            // detect double-quotes and escape any value that contains the

            array_walk($product, function(&$str){
                $str = preg_replace("/\t/", "\\t", $str);
                $str = preg_replace("/\r?\n/", "\\n", $str);
                if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
            });
            
            $data[] = [
                'id' => [
                    'content' => $product['pid'],
                    'align' => 'C'
                ],
                'item_code' => [
                    'content' => $product['item_code'],
                    'align' => 'C',
                ],
                'product_name' => [
                    'content' => $product['product_name'],
                    'align' => 'C'
                ],
                'category' => [
                    'content' => $product['category'],
                    'align' => 'C'
                ],
                'stocks' => [
                    'content' => number_format($product['stocks']) ,
                    'align' => 'C'
                ],
                'price' => [
                    'content' => number_format($product['price']) ,
                    'align' => 'C'
                ],
                'created_by' => [
                    'content' => $product['created_by'],
                    'align' => 'C'
                ],
                'created_at' => [
                    'content' => date('M d,Y h:i:s A', strtotime($product['created_at'])),
                    'align' => 'C'
                ],
                'updated_at' => [
                    'content' => date('M d,Y h:i:s A', strtotime($product['updated_at'])),
                    'align' => 'C'
                ]
            ];
        }
    }              



// Supplier Export
if ($type === 'supplier') {
    $stmt = $conn->prepare("SELECT suppliers.id as sid, suppliers.supplier_name as 'supplier_name', users.first_name, users.last_name, suppliers.supplier_location, suppliers.s_tin, suppliers.c_number, suppliers.email, suppliers.created_by, suppliers.created_at FROM suppliers INNER JOIN users ON suppliers.created_by = users.id ORDER BY suppliers.created_at DESC");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $suppliers = $stmt->fetchAll();

    // Column headings - replace from mysql database or hardcode it
    $headers = [
        'supplier_id' => [
            'width' => 10
        ],
        's_tin' => [
            'width' => 32
        ], 
        'supplier_name' => [
            'width' => 55
        ], 
        'supplier_location' => [
            'width' => 50
        ],
        'c_number' => [
            'width' => 25
        ],
        'email' => [
            'width' => 50
        ],
        'created_by' => [
            'width' => 25
        ],
        'created_at' => [
            'width' => 35
        ]
    ];

    foreach ($suppliers as $supplier) {
        $supplier['created_by'] = $supplier['first_name'] . ' ' . $supplier['last_name'];

        $data[] = [
            'supplier_id' => [
                'content' => $supplier['sid'],
                'align' => 'C'
            ],
            's_tin' => [
                'content' => $supplier['s_tin'],
                'align' => 'C'
            ], 
            'supplier_name' => [
                'content' => $supplier['supplier_name'],
                'align' => 'C'
            ], 
            'supplier_location' => [
                'content' => $supplier['supplier_location'],
                'align' => 'C'
            ],
            'c_number' => [
                'content' => $supplier['c_number'],
                'align' => 'C'
            ],
            'email' => [
                'content' => $supplier['email'],
                'align' => 'C'
            ],
            'created_by' => [
                'content' => $supplier['created_by'],
                'align' => 'C'
            ],
            'created_at' => [
                'content' => $supplier['created_at'],
                'align' => 'C'
            ]
        ];
    }

    $row_height = 20;
}



// Delivery Export
if ($type === 'delivery') {
    $stmt = $conn->prepare("SELECT date_received, qty_received, first_name, last_name, products.product_name, category, supplier_name, batch
        FROM order_product_history, order_product, users, suppliers, products
        WHERE
            order_product_history.order_product_id = order_product.id
        AND
            order_product.created_by = users.id
        AND 
            order_product.supplier = suppliers.id
        AND
            order_product.product = products.id
        ORDER BY order_product.batch DESC
    ");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $headers = [
        'date_received' => [
            'width' => 40
        ],
        'qty_received' => [
            'width' => 30
        ],
        'product_name' => [
            'width' => 50
        ],
        'category' => [
            'width' => 30
        ],
        'supplier_name' => [
            'width' => 40
        ],
        'batch' => [
            'width' => 35
        ],
        'created_by' => [
            'width' => 50
        ]
    ];

    $deliveries = $stmt->fetchAll();

    foreach($deliveries as $delivery) {
        $delivery['created_by'] = $delivery['first_name'] . ' ' . $delivery['last_name'];

        $data[] = [
            'date_received' => [
                'content' => $delivery['date_received'],
                'align' => 'C'
            ],
            'qty_received' => [
                'content' => $delivery['qty_received'],
                'align' => 'C'
            ],
            'product_name' => [
                'content' => $delivery['product_name'],
                'align' => 'C'
            ],
            'category' => [
                'content' => $delivery['category'],
                'align' => 'C'
            ],
            'supplier_name' => [
                'content' => $delivery['supplier_name'],
                'align' => 'C'
            ],
            'batch' => [
                'content' => $delivery['batch'],
                'align' => 'C'
            ],
            'created_by' => [
                'content' => $delivery['created_by'],
                'align' => 'C'
            ]
        ];
    }
    $row_height = 10;
}


// Purchase Orders Export
if ($type === 'purchase_orders') {
    $stmt = $conn->prepare("SELECT products.product_name, order_product.id as oid, order_product.quantity_ordered, order_product.quantity_received, order_product.quantity_remaining, order_product.status, order_product.batch, users.first_name, users.last_name, suppliers.supplier_name, order_product.created_at,products.item_code
        FROM order_product
        INNER JOIN users ON order_product.created_by = users.id
        INNER JOIN suppliers ON order_product.supplier = suppliers.id
        INNER JOIN products ON order_product.product = products.id
        WHERE order_product.quantity_ordered > 0
        ORDER BY order_product.id DESC
    ");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $headers = [
        'ITEM CODE' => [
            'width' => 20
        ],
        'PRODUCT NAME' => [
            'width' => 30
        ],
        'ORDER ID' => [
            'width' => 18
        ],
        'QTY ORDERED' => [
            'width' => 25
        ],
        'QTY RECEIVED' => [
            'width' => 25
        ],
        'QTY REMAINING' => [
            'width' => 25
        ],
        'STATUS' => [
            'width' => 20
        ],
        'BATCH' => [
            'width' => 25
        ],
        'CREATED AT' => [
            'width' => 35
        ],
        'CREATED BY' => [
            'width' => 30
        ],
        'SUPPLIER NAME' => [
            'width' => 30
        ]
    ];

    $purchaseOrders = $stmt->fetchAll();

    foreach ($purchaseOrders as $order) {
        $order['created_by'] = $order['first_name'] . ' ' . $order['last_name'];

        $data[] = [
            'ITEM CODE' => [
                'content' => $order['item_code'],
                'align' => 'C',
                'angle' => 45 // Angle value for slanting text
            ],
            'PRODUCT NAME' => [
                'content' => $order['product_name'],
                'align' => 'C',
                'angle' => 45 // Angle value for slanting text
            ],
            'ORDER ID' => [
                'content' => $order['oid'],
                'align' => 'C',
                'angle' => 45 // Angle value for slanting text
            ],
            'QTY ORDERED' => [
                'content' => $order['quantity_ordered'],
                'align' => 'C',
                'angle' => 45 // Angle value for slanting text
            ],
            'QTY RECEIVED' => [
                'content' => $order['quantity_received'],
                'align' => 'C',
                'angle' => 45 // Angle value for slanting text
            ],
            'QTY REMAINING' => [
                'content' => $order['quantity_remaining'],
                'align' => 'C',
                'angle' => 45 // Angle value for slanting text
            ],
            'STATUS' => [
                'content' => $order['status'],
                'align' => 'C',
                'angle' => 45 // Angle value for slanting text
            ],
            'BATCH' => [
                'content' => $order['batch'],
                'align' => 'C',
                'angle' => 45 // Angle value for slanting text
            ],
            'CREATED AT' => [
                'content' => $order['created_at'],
                'align' => 'C',
                'angle' => 45 // Angle value for slanting text
            ],
            'CREATED BY' => [
                'content' => $order['created_by'],
                'align' => 'C',
                'angle' => 45 // Angle value for slanting text
            ],
            'SUPPLIER NAME' => [
                'content' => $order['supplier_name'],
                'align' => 'C',
                'angle' => 45 // Angle value for slanting text
            ]
        ];
    }
    $row_height = 10;
}



// Employee Export
if ($type === 'employee') {
    $stmt = $conn->prepare("SELECT id, employee_id, first_name, last_name, role, expertise, email, c_number, created_at FROM users");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $employees = $stmt->fetchAll();

    // Column headings
    $headers = [
        'Employee ID' => [
            'width' => 25
        ],
        'First Name' => [
            'width' => 30
        ], 
        'Last Name' => [
            'width' => 30
        ],
        'Role' => [
            'width' => 25
        ],
        'Expertise' => [
            'width' => 30
        ],
        'Email' => [
            'width' => 40
        ],
        'Contact Number' => [
            'width' => 40
        ],
        'Created At' => [
            'width' => 40
        ]
    ];

    foreach ($employees as $employee) {
        $data[] = [
            'Employee ID' => [
                'content' => $employee['employee_id'],
                'align' => 'C'
            ],
            'First Name' => [
                'content' => $employee['first_name'],
                'align' => 'C'
            ], 
            'Last Name' => [
                'content' => $employee['last_name'],
                'align' => 'C'
            ],
            'Role' => [
                'content' => $employee['role'],
                'align' => 'C'
            ],
            'Expertise' => [
                'content' => $employee['expertise'],
                'align' => 'C'
            ],
            'Email' => [
                'content' => $employee['email'],
                'align' => 'C'
            ],
            'Contact Number' => [
                'content' => $employee['c_number'],
                'align' => 'C'
            ],
            'Created At' => [
                'content' => date('M d, Y', strtotime($employee['created_at'])),
                'align' => 'C'
            ]
        ];
    }

    $row_height = 10;
}


if ($type == 'collect_receipts') {
    $stmt = $conn->prepare("SELECT *, date(a.date_order) as date FROM tbl_cart a
    LEFT JOIN products b ON a.product_id = b.id
    where a.status = 'completed' and a.date_order is not null and a.time_order = ".$_GET['time_order']."");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $headers = [
        'ITEM CODE' => [
            'width' => 50
        ],
        'PRODUCT NAME' => [
            'width' => 50
        ],
        'ITEM PER PRICE' => [
            'width' => 50
        ],
        'QTY ORDER' => [
            'width' => 50
        ],
        'TOTAL' => [
            'width' => 50
        ],

    ];
    $purchaseOrders = $stmt->fetchAll();
    $data = [];
    $sub_total = 0;
    foreach ($purchaseOrders as $key => $value) {
    $sub_total += $value['qty'] * $value['price'];
    $data[] = [
        'ITEM CODE' => [
            'content' => $value['item_code'],
            'align' => 'C',
            'angle' => 45 // Angle value for slanting text
        ],
        'PRODUCT NAME' => [
            'content' => $value['product_name'],
            'align' => 'C',
            'angle' => 45 // Angle value for slanting text
        ],
        'ITEM PER PRICE' => [
            'content' => "P".number_format($value['price'],2),
            'align' => 'C',
            'angle' => 45 // Angle value for slanting text
        ],
        'QTY ORDER' => [
            'content' => $value['qty'] == 1 ? $value['qty'].'pc' : $value['qty'].'pcs',
            'align' => 'C',
            'angle' => 45 // Angle value for slanting text
        ],
        'TOTAL' => [
            'content' => 'P'.number_format($value['qty'] * $value['price'],2),
            'align' => 'C',
            'angle' => 45 // Angle value for slanting text
        ],

    ];
    }
    if ($value['discounted'] != null) {
        $dis = ($sub_total * $value['discounted']) / 100;
        $grand_total = $sub_total - $dis;
        $discounted = $value['discounted'].'%';
    }else{
        $grand_total = $sub_total;
        $discounted = '0%';
    }
    $data[] = [
        'ITEM CODE' => [
            'content' => '',
            'align' => 'C',
            'angle' => 45 // Angle value for slanting text
        ],
        'PRODUCT NAME' => [
            'content' =>  '',
            'align' => 'C',
            'angle' => 45 // Angle value for slanting text
        ],
        'ITEM PER PRICE' => [
            'content' =>  '',
            'align' => 'C',
            'angle' => 45 // Angle value for slanting text
        ],
        'QTY ORDER' => [
            'content' =>  'SUB TOTAL:',
            'align' => 'C',
            'angle' => 45 // Angle value for slanting text
        ],
        'TOTAL' => [
            'content' => 'P'.number_format($sub_total,2),
            'align' => 'C',
            'angle' => 45 // Angle value for slanting text
        ]
    ];
    $data[] = [
        'ITEM CODE' => [
            'content' => '',
            'align' => 'C',
            'angle' => 45 // Angle value for slanting text
        ],
        'PRODUCT NAME' => [
            'content' =>  '',
            'align' => 'C',
            'angle' => 45 // Angle value for slanting text
        ],
        'ITEM PER PRICE' => [
            'content' =>  '',
            'align' => 'C',
            'angle' => 45 // Angle value for slanting text
        ],
        'QTY ORDER' => [
            'content' =>  'DISCOUNT:',
            'align' => 'C',
            'angle' => 45 // Angle value for slanting text
        ],
        'TOTAL' => [
            'content' => $discounted,
            'align' => 'C',
            'angle' => 45 // Angle value for slanting text
        ]
    ];
    $data[] = [
        'ITEM CODE' => [
            'content' => '',
            'align' => 'C',
            'angle' => 45 // Angle value for slanting text
        ],
        'PRODUCT NAME' => [
            'content' =>  '',
            'align' => 'C',
            'angle' => 45 // Angle value for slanting text
        ],
        'ITEM PER PRICE' => [
            'content' =>  '',
            'align' => 'C',
            'angle' => 45 // Angle value for slanting text
        ],
        'QTY ORDER' => [
            'content' =>  'GRAND TOTAL:',
            'align' => 'C',
            'angle' => 45 // Angle value for slanting text
        ],
        'TOTAL' => [
            'content' => number_format($grand_total,2),
            'align' => 'C',
            'angle' => 45 // Angle value for slanting text (originalPrice * discountPercentage) / 100
        ]
    ];

    $row_height = 10;

}

    //start PDF
    $pdf = new PDF();
    $pdf->SetFont('Arial','',11);
    $pdf->AddPage();
    
    $imagePath = '../images/log.png';
    $pdf->Image($imagePath, 40, 0, 60); // Adjust the X-coordinate (10) for left alignment
    

    $pdf->Cell(80);
    //$pdf->Cell(100,10, $report_headers[$type], 0,0, 'C');
    $pdf->MultiCell(100, 10, $report_headers[$type], 0, 'C');

    $pdf->SetFont ('Arial', '',8);
    $pdf->Ln();
    $pdf->Ln();

    $pdf->FancyTable($headers,$data,$row_height);
    $pdf->Output();
?>