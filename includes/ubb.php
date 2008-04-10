<?PHP

function UBB($post)
{
	if ((get_magic_quotes_gpc() == '0') OR (strtolower(get_magic_quotes_gpc()) == 'off'))
	{
		$post = str_replace("\'","'",$post);
	}
	
		$post = str_replace("\n","<br>",$post);
		$post = str_replace("\r","",$post);

	return $post;
}

function UBB2($post)
{
	if ((get_magic_quotes_gpc() == '0') OR (strtolower(get_magic_quotes_gpc()) == 'off'))
	{
		$post = str_replace("\'","'",$post);
	}
	
	return $post;
}

function DEUBB($post)
{
	if ((get_magic_quotes_gpc() == '0') OR (strtolower(get_magic_quotes_gpc()) == 'off'))
	{
		$post = str_replace("'","\'",$post);
	}

	return $post;
}

//For comments
function DEUBB2($post)
{
	$post = str_replace("'","\'",$post);
	$post = str_replace("\n","<br>",$post);
	$post = str_replace("\r","",$post);

	return $post;
}

?>