<?PHP

function UBB($post)
{
	if (!magic_quotes_on())
		$post = stripslashes($post);
		
	$post = linebreak_to_br($post);

	return $post;
}

function UBB2($post)
{
	if (!magic_quotes_on())
		$post = stripslashes($post);
	
	return $post;
}

function DEUBB($post)
{
	if (!magic_quotes_on())
		$post = addslashes($post);

	return $post;
}

//For comments
function DEUBB2($post)
{
	if (!magic_quotes_on())
		$post = addslashes($post);
	$post = linebreak_to_br($post);

	return $post;
}

?>