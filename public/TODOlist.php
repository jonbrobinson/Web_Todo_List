<!DOCTYPE html>
<html>

<?php
	var_dump($_GET);
	var_dump($_POST);
?>

	<header>
		<title>Todo_List</title>
	</header>
	<body>
			<h4>TODO List</h4>
			<p>
				<ol>
					<li>Complete Codeup</li>
					<li>Present a Project</li>
					<li>Interview with companies</li>
				</ol>
			</p>
		<form method="POST">
			<p>
	        <label for="item">Todo Item</label>
	        <input id="item" name="item" type="text" placeholder="Enter Item">
		    </p>
		    <p>
		        <label for="password">Password</label>
		        <input id="password" name="password" type="password" placeholder="Username">
		    </p>
		    <p>
		        <button type="submit">Add Item</button>
		    </p>
		</form>
	</body>
</html>