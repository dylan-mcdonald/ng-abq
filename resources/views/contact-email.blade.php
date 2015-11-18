<h1>Contact From Albuquerque Angular Site</h1>
<ul>
	<li><strong>Name:</strong> [[ $name ]]</li>
	<li><strong>Subject:</strong> [[ $subject ]]</li>
</ul>
<p>
	@foreach($messageLines as $messageLine)
		[[ $messageLine ]]<br />
	@endforeach
</p>
<hr />
<h2>Anti Abuse Data</h2>
<ul>
	<li><strong>IP Address:</strong> [[ $_SERVER["REMOTE_ADDR"] ]]</li>
	<li><strong>Browser:</strong> [[ $_SERVER["HTTP_USER_AGENT"] ]]</li>
</ul>