<!DOCTYPE html>
<html>
<head>
	<title>SoundBox</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="container">
		<form action="php/create.php" 
		      method="post" enctype="multipart/form-data">
            
		   <h4 class="display-4 text-center">SOUNDBOX</h4><hr><br>
		   <?php if (isset($_GET['error'])) { ?>
		   <div class="alert alert-danger" role="alert">
			  <?php echo $_GET['error']; ?>
		    </div>
		   <?php } ?>
		   <div class="form-group">
		     <label for="name">Name of the Song</label>
		     <input type="name" 
		           class="form-control" 
		           id="name" 
		           name="name" 
		           value="<?php if(isset($_GET['name']))
		                           echo($_GET['name']); ?>" 
		           placeholder="Enter name">
		   </div>

		   <div class="form-group">
		     <label for="singer">Singer</label>
		     <input type="name" 
		           class="form-control" 
		           id="singer" 
		           name="singer" 
		           value="<?php if(isset($_GET['singer']))
		                           echo($_GET['singer']); ?>"
		           placeholder="Enter singer">
		   </div>

		   <div class="form-group">
		     <label for="song">Upload a song:</label>
		     <input type="file" 
		           class="form-control" 
		           id="song" 
		           name="song" 
		           placeholder="Upload Song">
		   </div>

			<div class="form-group">
		     <label for="cover">Upload the image:</label>
		     <input type="file" 
		           class="form-control" 
		           id="cover" 
		           name="cover" 
		           placeholder="Upload Album Cover">
		   </div>



		   <button type="submit" 
		          class="btn btn-primary"
		          name="create">Create</button>
		    <a href="read.php" class="link-primary">View</a>
	    </form>
	</div>
</body>
</html>