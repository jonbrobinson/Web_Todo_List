
<?php
	require_once('Classes/filestore.php');

	$todo_data_store = new Filestore('list.txt');

	$items = $todo_data_store->read_lines();
	if(!empty($_POST)){
		$push_item = $_POST['item'];
		array_push($items,$push_item);
		$todo_data_store->write_lines($items);
	}

	if(count($_FILES) > 0 && $_FILES['file1']['error']== 0 && $_FILES['file1']['type']){

		//Set the destination directory for uploads
		$upload_dir = '/vagrant/sites/todo.dev/public/uploads/';
		// Grab hte filename from the upload file by using basename
		$filename = basename($_FILES['file1']['name']);
		// Create the saved filename using the file's original name and our upload directory
		$save_filename = $upload_dir . $filename;
		//Move the file from the temp location to our uploads directory
		move_uploaded_file($_FILES['file1']['tmp_name'], $save_filename);
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>TODO List</title>
		<link rel="stylesheet" href="todolist_style.css">
		<link href='http://fonts.googleapis.com/css?family=Josefin+Slab' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<div class="papers">
		<h1>Todo List</h1>
		<? if(!empty($_GET)): ?>
			<? if(($_GET['action'] == 'remove')): ?>
				<? unset($items[$_GET['index']]);?>
			<? elseif($_GET['action'] == 'mark'): ?>
				<?= "<h2>{$items[$_GET['index']]} is marked complete</h2>"; ?>
			<? endif; ?>
			<? $todo_data_store->write_lines($items);?>
		<? endif; ?>
		<ol>
			<? foreach($items as $key => $item): ?>
					<li> <?= htmlspecialchars(strip_tags($item));?>
							<?= "<a href=\"TODOlist.php?action=remove&index={$key}\">Remove Item</a>"; ?>
							<?= "<a href=\"TODOlist.php?action=mark&index={$key}\">Mark Complete</a>"; ?>
					</li>
			<? endforeach; ?>
		</ol>
		<form method="post" action="TODOlist.php">
			<p>
	        <label for="item">Todo Item</label>
	        <input id="item" name="item" type="text" placeholder="Enter Item">
		    </p>

		    <p>
		        <button type="submit">Enter Item</button>
		    </p>
		    <br>
		    <br>
		    <hr>
		</form>
		<h1>UPLOAD FILE</h1>
		<form method="POST" enctype="multipart/form-data" action="TODOlist.php">
			<p>
				<label for="file1">File to upload: </label>
				<input type="file" id="file1" name="file1">
			</p>
			<p>
				<input type="submit" value="Upload">
			</p>
		</form>
			<?	if(isset($save_filename)): ?>
					<?= "<p>You can download your file <a href='/uploads/{$filename}'>Here</a>.</p>"; ?>
			<? endif; ?>
		</div>
	</body>
</html>