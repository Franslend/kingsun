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
    $report_headers = [
        'product' => 'Product Reports',
        'supplier' => 'Supplier Report',
        'delivery' => 'Delivery Report',
        'purchase_orders' => 'Purchase Order Report'
    ];
    $row_height = 38;

    // Pull data from database.
    include('connection.php');


    //Product Export
if($type == 'product'){
    $stmt = $conn->prepare("SELECT *, products.id as pid FROM products 
    INNER JOIN 
        users ON 
        products.created_by = users.id 
        ORDER BY 
        products.created_at DESC");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $products = $stmt->fetchAll();

    // Column headings - replace from mysql database or hardcode it
    $headers = [
        'id' => [
            'width' => 15
        ],
        'item_code' => [
            'width' => 30
        ],
        'image' => [
            'width' => 40
        ],
    ];

    foreach ($products as $product) {
        $created_by = $product['first_name'] . ' ' . $product['last_name'];

        $data[] = [
            'id' => [
                'content' => $product['pid'],
                'align' => 'C'
            ],
            'item_code' => [
                'content' => $product['item_code'],
                'align' => 'C',
            ],
            'image' => [
                'content' => $product['img'],
                'align' => 'C',
            ],
        ];
    }

    $row_height = 20;
}              



// Supplier Export
if ($type === 'supplier') {
    $stmt = $conn->prepare("SELECT suppliers.id as sid, suppliers.created_at as 'created at', users.first_name, users.last_name, suppliers.supplier_location, suppliers.email, suppliers.created_by FROM suppliers INNER JOIN users ON suppliers.created_by = users.id ORDER BY suppliers.created_at DESC");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $suppliers = $stmt->fetchAll();

    // Column headings - replace from mysql database or hardcode it
    $headers = [
        'supplier_id' => [
            'width' => 23
        ],
        'created_at' => [
            'width' => 70
        ], 
        'supplier_location' => [
            'width' => 60
        ],
        'email' => [
            'width' => 60
        ],
        'created_by' => [
            'width' => 60
        ]
    ];

    foreach ($suppliers as $supplier) {
        $supplier['created_by'] = $supplier['first_name'] . ' ' . $supplier['last_name'];

        $data[] = [
            'supplier_id' => [
                'content' => $supplier['sid'],
                'align' => 'C'
            ],
            'created_at' => [
                'content' => $supplier['created at'],
                'align' => 'C'
            ], 
            'supplier_location' => [
                'content' => $supplier['supplier_location'],
                'align' => 'C'
            ],
            'email' => [
                'content' => $supplier['email'],
                'align' => 'C'
            ],
            'created_by' => [
                'content' => $supplier['created_by'],
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
    $stmt = $conn->prepare("SELECT products.product_name, order_product.id as oid, order_product.quantity_ordered, order_product.quantity_received, order_product.quantity_remaining, order_product.status, order_product.batch, users.first_name, users.last_name, suppliers.supplier_name, order_product.created_at
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
        'product_name' => [
            'width' => 35
        ],
        'order_id' => [
            'width' => 18
        ],
        'quantity_ordered' => [
            'width' => 20
        ],
        'quantity_received' => [
            'width' => 20
        ],
        'quantity_remaining' => [
            'width' => 20
        ],
        'status' => [
            'width' => 30
        ],
        'batch' => [
            'width' => 35
        ],
        'created_at' => [
            'width' => 40
        ],
        'created_by' => [
            'width' => 30
        ],
        'supplier_name' => [
            'width' => 30
        ]
    ];

    $purchaseOrders = $stmt->fetchAll();

    foreach ($purchaseOrders as $order) {
        $order['created_by'] = $order['first_name'] . ' ' . $order['last_name'];

        $data[] = [
            'product_name' => [
                'content' => $order['product_name'],
                'align' => 'C',
                'angle' => 45 // Angle value for slanting text
            ],
            'order_id' => [
                'content' => $order['oid'],
                'align' => 'C',
                'angle' => 45 // Angle value for slanting text
            ],
            'quantity_ordered' => [
                'content' => $order['quantity_ordered'],
                'align' => 'C',
                'angle' => 45 // Angle value for slanting text
            ],
            'quantity_received' => [
                'content' => $order['quantity_received'],
                'align' => 'C',
                'angle' => 45 // Angle value for slanting text
            ],
            'quantity_remaining' => [
                'content' => $order['quantity_remaining'],
                'align' => 'C',
                'angle' => 45 // Angle value for slanting text
            ],
            'status' => [
                'content' => $order['status'],
                'align' => 'C',
                'angle' => 45 // Angle value for slanting text
            ],
            'batch' => [
                'content' => $order['batch'],
                'align' => 'C',
                'angle' => 45 // Angle value for slanting text
            ],
            'created_at' => [
                'content' => $order['created_at'],
                'align' => 'C',
                'angle' => 45 // Angle value for slanting text
            ],
            'created_by' => [
                'content' => $order['created_by'],
                'align' => 'C',
                'angle' => 45 // Angle value for slanting text
            ],
            'supplier_name' => [
                'content' => $order['supplier_name'],
                'align' => 'C',
                'angle' => 45 // Angle value for slanting text
            ]
        ];
    }
    $row_height = 10;
}




    //start PDF
    $pdf = new PDF();
    $pdf->SetFont('Arial','',11);
    $pdf->AddPage();

    $pdf->Cell(80);
    $pdf->Cell(100,10, $report_headers[$type], 0,0, 'C');
    $pdf->SetFont ('Arial', '',10);
    $pdf->Ln();
    $pdf->Ln();

    $pdf->FancyTable($headers,$data,$row_height);
    $pdf->Output();
?>