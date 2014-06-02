<?php
	var_dump($_GET);
	var_dump($_POST);
	var_dump($_FILES);

	define('FILENAME', 'list.txt');

	function load_file($filename){
		$handle = fopen($filename,'r');
		$contents = trim(fread($handle,filesize($filename)));
		$contents_array = explode("\n", $contents);
		fclose($handle);
		return $contents_array;
	}

	function save_file($array,$filename){
		$handle = fopen($filename,'w');
		$string = implode("\n", $array);
		$contents = fwrite($handle,$string);
		fclose($handle);
	}

	$items = load_file(FILENAME);
	if(!empty($_POST)){
		$push_item = $_POST['item'];
		array_push($items,$push_item);
		save_file($items,FILENAME);
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
	<header>
		<title>TODO List</title>
	</header>
	<body>
			<? if(!empty($_GET)): ?>
				<? if(($_GET['action'] == 'remove')): ?>
					<? unset($items[$_GET['index']]);?>
				<? elseif($_GET['action'] == 'mark'): ?>
					<?= "<h2>{$items[$_GET['index']]} is marked complete</h2>"; ?>
					<? save_file($items,FILENAME);?>
				<? endif; ?>
			<? endif; ?>
			<ol>
				<? foreach($items as $key => $item): ?>
						<? echo "<li>{$item}
								<a href=\"TODOlist.php?action=remove&index={$key}\">Remove Item</a>
								<a href=\"TODOlist.php?action=mark&index={$key}\">Mark Complete</a>
							  </li>";?>
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
	</body>
</html>