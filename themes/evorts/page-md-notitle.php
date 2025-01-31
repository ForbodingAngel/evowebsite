</head>
<body>

	<!-- Primary Page Layout
	–––––––––––––––––––––––––––––––––––––––––––––––––– -->
	<div class="contentcontainer">
		<div class="content">
			<div class="section group">
					<?php
						$filename = file_get_contents("./pages/" . $pagename . ".html");
						$parsed_content = parse_shortcodes($filename);
						echo from_markdown($parsed_content);
					?>
			</div>
		</div>
	</div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->