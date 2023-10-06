<?php

$table_columns_mapping = [
	'users' => [
		'employee_id','first_name', 'last_name', 'email', 'c_number', 'password','role', 'created_at', 'updated_at'
	],
	'products' => [
		'id','item_code','product_name', 'category', 'description',  'stocks', 'price', 'img', 'created_by', 'created_at', 'updated_at'
	],
	'suppliers' => [
		'supplier_name', 'supplier_location', 'email','c_number', 'created_by', 'created_at', 'updated_at'
	]
];