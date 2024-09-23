<?php 
include('../config/function.php');

if (isset($_POST['saveAdmin'])) {
	// code...
	$name = validation($_POST['name']);
	$email = validation($_POST['email']);
	$password= validation($_POST['password']);
	$phone = validation($_POST['phone']);
	$is_ban = isset($_POST['is_ban'])==true ? 1:0;

	if ($name != '' && $email != '' && $password !='') {
		// code...
		$emailCheck =mysqli_query($conn, "SELECT * FROM admins WHERE email = '$email'");
		if ($emailCheck) {
			// code...
			if (mysqli_num_rows($emailCheck)> 0) {
				// code...
			redirect('admins-create.php', 'Email as already exist.');

			}
		}
        $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);
        $data =[
        'name' => $name,
        'email'=>$email,
        'password'=>$password,
        'phone'=>$phone,
        'is_ban'=>$is_ban

        ];
        $result = insert('admins', $data);
        if ($result) {
        	// code...
        redirect('admin.php', 'Admin Created Successfully.');

        }else{
        redirect('admins-create.php', 'Something went wrong.');

        }
	}else{
		redirect('admins-create.php', 'please fill required fields.');
	}
}



//admin update

if (isset($_POST['updateAdmin'])) {
    // Validate input
    $adminid = validation($_POST['adminid']);
    $adminData = getById('admins', $adminid);

    if ($adminData['status'] != 200) {
        redirect('admins-edit.php?id=' . $adminid, 'Please fill required fields.');
    }

    $name = validation($_POST['name']);
    $email = validation($_POST['email']);
    $password = validation($_POST['password']);
    $phone = validation($_POST['phone']);
    $is_ban = isset($_POST['is_ban']) ? 1 : 0;

    // Check if the email already exists for another admin
    $emailCheckQuery = "SELECT * FROM admins WHERE email = '$email' AND id != '$adminid'";
    $checkResult = mysqli_query($conn, $emailCheckQuery);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        redirect('admin-edit.php?id=' . $adminid, 'Email already exists.');
    }

    // If a new password is provided, hash it, otherwise keep the existing password
    if ($password != '') {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $password_hash = $adminData['data']['password'];
    }

    if ($name != '' && $email != '') {
        // Data to update
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password_hash, // Corrected this line
            'phone' => $phone,
            'is_ban' => $is_ban
        ];

        $result = update('admins', $data, $adminid);

        if ($result) {
            redirect('admin-edit.php?id=' . $adminid, 'Update Successfully.');
        } else {
            redirect('admin-edit.php?id=' . $adminid, 'Something went wrong.');
        }
    } else {
        redirect('admin-edit.php?id=' . $adminid, 'Please fill required fields.');
    }
}





//categories


if (isset($_POST['saveCategory'])) {
    // Validate input
    $name = validation($_POST['name']);
    $description = validation($_POST['description']);
    $status = isset($_POST['status']) && $_POST['status'] == true ? 1 : 0;

    // Data to insert
    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status
    ];

    // Insert data into 'categories' table
    $result = insert('categories', $data);
    if ($result) {
        redirect('categories.php', 'Category Created Successfully.');
    } else {
        redirect('categories-create.php', 'Something went wrong.');
    }
}

if (isset($_POST['updateCategory'])) {
    // Validate input
    $categoryid = validation($_POST['categoryid']);
    $name = validation($_POST['name']);
    $description = validation($_POST['description']);
    $status = isset($_POST['status']) ? 1 : 0;

    // Data to update
    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status
    ];

    // Update data in 'categories' table
    $result = updatee('categories', $data, $categoryid);
    if ($result) {
        redirect('categories-edit.php?id=' . $categoryid, 'Category Updated Successfully.');
    } else {
        redirect('categories-edit.php?id=' . $categoryid, 'Something went wrong.');
    }
}




if (isset($_POST['saveProduct'])) {
    // Include necessary files and functions
      // Validate and sanitize input
    $category_id = validation($_POST['category_id']);
    $name = validation($_POST['name']);
    $description = validation($_POST['description']);
    $price = validation($_POST['price']);
    $quantity = validation($_POST['quantity']);
    $status = isset($_POST['status']) && $_POST['status'] ? 1 : 0;

    // Handle image upload
    $finalImage = "";
    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $path = "../assets/uploads/products";
        $img_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = time() . '.' . $img_ext;

        // Create the directory if it doesn't exist
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        // Attempt to move the uploaded file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $path . "/" . $filename)) {
            $finalImage = 'assets/uploads/products/' . $filename;
        } else {
            redirect('products-create.php', 'Image upload failed.');
            exit();
        }
    }

    // Data to insert
    $data = [
        'category_id' => $category_id,
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'quantity' => $quantity,
        'image' => $finalImage,
        'status' => $status
    ];

    // Insert data into 'products' table
    $result = insert('products', $data);
    if ($result) {
        redirect('product.php', 'Product Created Successfully.');
    } else {
        redirect('products-create.php', 'Something went wrong.');
    }
}




if (isset($_POST['updateProduct'])) {
    $product_id = validation($_POST['product_id']);
    $productData = getById('products', $product_id);

    if (!$productData) {
        redirect('product.php', 'No product found');
        exit();
    }

    $category_id = validation($_POST['category_id']);
    $name = validation($_POST['name']);
    $description = validation($_POST['description']);
    $price = validation($_POST['price']);
    $quantity = validation($_POST['quantity']);
   $status = isset($_POST['status']) ? 1 : 0;

    // Handle image upload
    $finalImage = $productData['data']['image']; // Default to existing image
    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $path = "../assets/uploads/products";
        $img_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = time() . '.' . $img_ext;

        // Create the directory if it doesn't exist
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        // Attempt to move the uploaded file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $path . "/" . $filename)) {
            $finalImage = 'assets/uploads/products/' . $filename;

            // Delete the old image if a new image was uploaded successfully
            $deleteimage = "../" . $productData['data']['image'];
            if (file_exists($deleteimage)) {
                unlink($deleteimage);
            }
        } else {
            redirect('products-edit.php?id=' . $product_id, 'Image upload failed.');
            exit();
        }
    }

    // Data to update
    $data = [
        'category_id' => $category_id,
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'quantity' => $quantity,
        'image' => $finalImage,
        'status' => $status
    ];

    // Update data in 'products' table
    try {
        $result = update('products', $data, $product_id);
        if ($result) {
            redirect('products-edit.php?id=' . $product_id, 'Product updated successfully.');
        } else {
            redirect('products-edit.php?id=' . $product_id, 'Something went wrong.');
        }
    } catch (Exception $e) {
        // Handle the exception and provide feedback
        redirect('products-edit.php?id=' . $product_id, 'Error: ' . $e->getMessage());
    }
}





//customer
if (isset($_POST['saveCustomer'])) {
$name = validation($_POST['name']);
$email = validation($_POST['email']);
$phone = validation($_POST['phone']);
$status = isset($_POST['status']) ? 1 : 0;
if ($name != '') {
  // code...
		$emailCheck =mysqli_query($conn, "SELECT * FROM customers WHERE email = '$email'");
		if ($emailCheck) {
			// code...
			if (mysqli_num_rows($emailCheck)> 0) {
				// code...
			redirect('customers-create.php', 'Email as already exist.');

			}
		}
        $data = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'status' => $status
    ];
  $result = insert('customers', $data);
    if ($result) {
        redirect('customer.php', 'Customer Created Successfully.');
    } else {
        redirect('customers-create.php', 'Something went wrong.');
    }
	}
else
{
redirect('customers.php', 'please fill required fields');
}
}


if (isset($_POST['updateCustomer'])) {
    $customerid = validation($_POST['customerid']);
    $name = validation($_POST['name']);
    $email = validation($_POST['email']);
    $phone = validation($_POST['phone']);
    $status = isset($_POST['status']) ? 1 : 0;

    if ($name != '') {
        // Check if the email already exists and does not belong to the current customer
        $emailCheck = mysqli_query($conn, "SELECT * FROM customers WHERE email = '$email' AND id != '$customerid'");
        if ($emailCheck) {
            if (mysqli_num_rows($emailCheck) > 0) {
                redirect('customers-edit.php?id='.$customerid, 'Email already exists.');
                exit();
            }
        }

        // Prepare the data for updating
        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'status' => $status
        ];

        // Update the customer information
        $result = updatee('customers', $data, $customerid);
        if ($result) {
            redirect('customers-edit.php?id='.$customerid, 'Customer updated successfully.');
        } else {
            redirect('customers-edit.php?id='.$customerid, 'Something went wrong.');
        }
    } else {
        redirect('customers-edit.php?id='.$customerid, 'Please fill in the required fields.');
    }
}
?>
