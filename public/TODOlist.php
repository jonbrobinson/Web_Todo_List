<!DOCTYPE html>
<html>

<?php
	var_dump($_GET);
	var_dump($_POST);
?>

	<header>
		<title>TODO List</title>
	</header>
	<body>
			<?php
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

			if(!empty($_GET)){
				if(($_GET['action'] == 'remove')){
					unset($items[$_GET['index']]);
				} else if($_GET['action'] == 'mark'){
					echo "<h2>{$items[$_GET['index']]} is marked complete</h2>";
				}
				save_file($items,FILENAME);
			}

			?>
			<ol>
				<?php
					foreach($items as $key => $item){
						echo "<li>{$item}
								<a href=\"TODOlist.php?action=remove&index={$key}\">Remove Item</a>
								<a href=\"TODOlist.php?action=mark&index={$key}\">Mark Complete</a>
							  </li>";
					}
				?>
			</ol>
		<form method="post" action="TODOlist.php">
			<p>
	        <label for="item">Todo Item</label>
	        <input id="item" name="item" type="text" placeholder="Enter Item">

		    </p>

		    <p>
		        <button type="submit">Enter Item</button>
		    </p>
		</form>
	</body>
</html>